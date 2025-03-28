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
            ->orderByDesc('payment_id')
            ->get()
            ->unique('employee_id');

        $allStatus = ['Active', 'Deactive', 'All'];

        return view('payments', compact('payments', 'allStatus'));
    }

    public function filterPayments(Request $request)
    {
        // If only need employees list
        if ($request->has('employees_only')) {
            $query = Employee::select('employee_id', 'employee_name')
                     ->whereHas('payments'); // Only employees who have payments

            if ($request->status === '1' || $request->status === '0') {
                $query->whereHas('payments', function($q) use ($request) {
                    $q->where('payment_status', $request->status);
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

        $baseQuery = Payment::with('employee:employee_id,employee_name')
                    ->select('payment_id', 'employee_id', 'payment', 'date_time', 'payment_status');

        if ($status === '1') {
            $baseQuery->where('payment_status', 1);
        } elseif ($status === '0') {
            $baseQuery->where('payment_status', 0);
        }

        if ($employeeId) {
            $baseQuery->where('employee_id', $employeeId);
        }

        $payments = $baseQuery->latest('date_time')
                     ->get()
                     ->unique('employee_id');

        // Get all employees who have payments (regardless of employee_status)
        $employees = Employee::select('employee_id', 'employee_name')
                    ->whereHas('payments')
                    ->pluck('employee_name', 'employee_id');

        return response()->json([
            'payments' => $payments,
            'employees' => $employees
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
            'employee_status' => 'boolean',
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
        $payment = Payment::where('payment_id', $paymentId)->first();
        if (!$payment) {
            return 'Payment record not found';
        }
        $employee = Employee::where('employee_id', $payment->employee_id)->first();

        $payments = Payment::where('employee_id', $employee->employee_id)->get();

        return view('employee_payments', [
            'employee_name' => $employee->name,
            'payments' => $payments
        ]);
    }


}
