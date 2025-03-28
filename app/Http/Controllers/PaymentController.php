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
        $status = $request->status;

        $baseQuery = Payment::with('employee');

        if ($status === '1') {
            // Latest active payments (unique by employee)
            return $baseQuery->where('payment_status', 1)
                ->latest('date_time')
                ->get()
                ->unique('employee_id');

        } elseif ($status === '0') {
            // Latest deactive payments (unique by employee)
            return $baseQuery->where('payment_status', 0)
                ->latest('date_time')
                ->get()
                ->unique('employee_id');

        } else {
            // For 'All' - get both latest active AND deactive for each employee

            // Get all employees who have payments
            $employeeIds = Payment::distinct()->pluck('employee_id');

            $results = collect();

            foreach ($employeeIds as $employeeId) {
                // Get latest active for this employee
                $latestActive = $baseQuery->clone()
                    ->where('employee_id', $employeeId)
                    ->where('payment_status', 1)
                    ->latest('date_time')
                    ->first();

                // Get latest deactive for this employee
                $latestDeactive = $baseQuery->clone()
                    ->where('employee_id', $employeeId)
                    ->where('payment_status', 0)
                    ->latest('date_time')
                    ->first();

                // Add to results if they exist
                if ($latestActive) $results->push($latestActive);
                if ($latestDeactive) $results->push($latestDeactive);
            }

            // Sort all results by date_time descending
            return $results->sortByDesc('date_time')->values();
        }
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
