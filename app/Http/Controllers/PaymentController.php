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
        $current_month = now()->format('F');
        return view('payments', compact('payments', 'allStatus','total_payments','current_month'));
    }
    public function filterPayments(Request $request)
    {
        if ($request->has('employees_only')) {
            $query = Employee::select('employee_id', 'employee_name')
                ->whereHas('payments');
    
            // Filter by employee status if provided
            if ($request->has('status')) {
                $query->where('employee_status', $request->status);
            }
    
            return response()->json([
                'employees' => $query->pluck('employee_name', 'employee_id'),
                'payments' => []
            ]);
        }
    
        // Normal filtering for table data
        $status = $request->status; // employee_status (1 for active, 0 for deactive)
        $employeeId = $request->employee_id;
        $paymentDate = $request->payment_date; // Date in YYYY-MM format
    
        $baseQuery = Payment::with(['employee' => function($query) {
                $query->select('employee_id', 'employee_name', 'employee_status');
            }])
            ->select('payment_id', 'employee_id', 'payment', 'date_time', 'created_at')
            ->whereHas('employee', function($q) use ($status) {
                if ($status !== null) {
                    $q->where('employee_status', $status);
                }
            });
    
        if ($employeeId) {
            $baseQuery->where('employee_id', $employeeId);
        }
    
        if ($paymentDate) {
            $baseQuery->whereYear('date_time', '=', substr($paymentDate, 0, 4))
                ->whereMonth('date_time', '=', substr($paymentDate, 5, 2));
        }
    
        $payments = $baseQuery->latest('date_time')
            ->get()
            ->map(function ($payment) {
                $payment->formatted_created_at = $payment->created_at->format('Y-m-d H:i:s');
                return $payment;
            })
            ->unique('employee_id'); 
    
        $total_payments = Payment::selectRaw('employee_id,SUM(payment) as total_payment')
                            ->whereBetween('date_time',[
                                now()->startOfMonth(),
                                now()->endOfMonth(),
                            ])
                          ->groupBy('employee_id')->pluck('total_payment','employee_id');

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
