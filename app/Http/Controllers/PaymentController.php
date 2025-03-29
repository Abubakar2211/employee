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
        ->where('payment_status', 1)
        ->whereBetween('date_time', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])
        ->orderByDesc('payment_id')
        ->get()
        ->unique('employee_id');

    $allStatus = ['Active', 'Deactive', 'All'];

    return view('payments', compact('payments', 'allStatus'));
}
    public function filterPayments(Request $request)
    {
        // If only need employees list (same as before)
        if ($request->has('employees_only')) {
            $query = Employee::select('employee_id', 'employee_name')
                     ->whereHas('payments');

            if ($request->status === '1') {
                $query->whereHas('payments', function($q) {
                    $q->where('payment_status', 1);
                });
            } elseif ($request->status === '0') {
                $query->whereHas('payments', function($q) {
                    $q->where('payment_status', 0);
                });
            }

            return response()->json([
                'employees' => $query->pluck('employee_name', 'employee_id'),
                'payments' => []
            ]);
        }

        // Normal filtering for table data
        $status = $request->status;
        $employeeId = $request->employee_id;
        $paymentDate = $request->payment_date; // YYYY-MM format में date आएगी

        $baseQuery = Payment::with('employee:employee_id,employee_name')
                    ->select('payment_id', 'employee_id', 'payment', 'date_time', 'created_at', 'payment_status');

        if ($status === '1') {
            $baseQuery->where('payment_status', 1);
        } elseif ($status === '0') {
            $baseQuery->where('payment_status', 0);
        }

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

        return response()->json([
            'payments' => $payments
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('employee_status',1)->select('employee_id','employee_name')->get();
        return view('payment_create',compact('employees'));
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
            'payment_status' => 'boolean',
        ]);
        $payment['date_time'] = Carbon::parse($payment['date_time'])->format('Y-m-d');
        Payment::create($payment);
        return redirect()->route('payment.index')->with('success','Payment Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with('employee')->where('payment_id', $id)->first();
        return view('payment_show',compact('payment'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::with('employee')->where('payment_id',$id)->first();
        return view('payment_edit',compact('payment'));
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
                'payment_status' => 'boolean',
            ]);

            $payment->update($validatedData);

            return redirect()->route('payment.index');
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
