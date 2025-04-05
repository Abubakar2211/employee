<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('employee')
            ->whereBetween('date_time',[
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->orderByDesc('payment_id')
            ->get()
            ->unique('employee_id');
        $total_payments = Payment::whereBetween('date_time',[now()->startOfMonth(),now()->endOfMonth()])->selectRaw('employee_id, SUM(payment) as total_payment')->groupBy('employee_id')->pluck('total_payment','employee_id');
        $allStatus = ['Active', 'Deactive', 'All'];
        $current_month = now()->format('Y-m');
        return view('payments', compact('payments', 'allStatus','total_payments','current_month'));
    }
    public function filterPayments(Request $request)
    {
        if ($request->has('employees_only')) {
            $query = Employee::select('employee_id', 'employee_name')
                ->whereHas('payments');

            if ($request->filled('status')) {
                $query->where('employee_status', $request->status);
            }

            return response()->json([
                'employees' => $query->pluck('employee_name', 'employee_id'),
                'payments' => []
            ]);
        }

        $status = $request->status;
        $employeeId = $request->employee_id;
        $paymentDate = $request->payment_date; // YYYY-MM format

        // Base query for payments
        $baseQuery = Payment::with(['employee' => function($query) {
                $query->select('employee_id', 'employee_name', 'employee_status');
            }])
            ->select('payment_id', 'employee_id', 'payment', 'date_time', 'created_at');

        // Apply status filter if provided
        if ($status !== null && $status !== '') {
            $baseQuery->whereHas('employee', function($q) use ($status) {
                $q->where('employee_status', $status);
            });
        } else {
            $baseQuery->whereHas('employee');
        }

        // Apply employee filter if provided
        if ($employeeId) {
            $baseQuery->where('employee_id', $employeeId);
        }

        // Get start and end dates for the selected month
        $startDate = $paymentDate ? Carbon::parse($paymentDate)->startOfMonth() : now()->startOfMonth();
        $endDate = $paymentDate ? Carbon::parse($paymentDate)->endOfMonth() : now()->endOfMonth();

        // Get latest payment for each employee in the selected month
        $payments = $baseQuery->clone()
            ->whereBetween('date_time', [$startDate, $endDate])
            ->latest('date_time')
            ->get()
            ->unique('employee_id')
            ->map(function ($payment) {
                $payment->formatted_created_at = $payment->created_at->format('Y-m-d H:i:s');
                return $payment;
            });

        // Get total payments for each employee in the selected month
        $total_payments = Payment::selectRaw('employee_id, SUM(payment) as total_payment')
            ->whereBetween('date_time', [$startDate, $endDate])
            ->groupBy('employee_id')
            ->pluck('total_payment', 'employee_id');

        return response()->json([
            'payments' => $payments,
            'total_payments' => $total_payments
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('employee_status', 1)->select('employee_id', 'employee_name')->get();
        return view('payment_create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payment = $request->validate([
            'employee_id' => 'required',
            'payment' => 'required',
            'date_time' => 'required',
        ]);
        $payment['date_time'] = Carbon::parse($payment['date_time'])->format('Y-m-d');
        Payment::create($payment);
        return redirect()->route('payment.index')->with('success', 'Payment Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with('employee')->where('payment_id', $id)->first();
        return view('payment_show', compact('payment'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::with('employee')->where('payment_id', $id)->first();
        return view('payment_edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::where('payment_id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'date_time' => 'required',
            'payment' => 'required',
        ]);

        $payment->update($validatedData);

        return redirect()->route('payment.index')->with('success', 'Payment Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }



    public function payments($paymentId)
    {
        // Get the payment record to find the employee
        $payment = Payment::with('employee')->find($paymentId);

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment record not found');
        }

        // Get all payments for this employee, ordered by date (newest first)
        $payments = Payment::where('employee_id', $payment->employee_id)
            ->orderBy('date_time', 'desc')
            ->get();

        return view('employee_payments', [
            'employee' => $payment->employee, // Pass the whole employee object
            'payments' => $payments
        ]);
    }


}
