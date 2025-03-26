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
        $payments = Payment::with('employee')->latest()->get()->unique('employee_id');
        $allStatus = Payment::pluck('employee_status')->unique()->values()->all();
        $statusMap = [
            1 => "Active",
            0 => "Deactive",
        ];
        $allStatus = array_map(function ($status) use ($statusMap) {
            return $statusMap[$status] ?? 'Unknown';
        }, $allStatus);
        return view('payments', compact('payments', 'allStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::select('employee_id','employee_name')->get();
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
            'employee_status' => 'boolean',
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

    public function filterPayments(Request $request)
    {
            $query = Payment::with('employee');
            // $query = Payment::with(['employee' => function($query) {
            //     $query->select('employee_name', 'employee_status');
            // }])
            // ->select('payment', 'date_time', 'payment_id');

        // Filter by status if provided
        if ($request->status) {
            $statusMap = [
                "Active" => 1,
                "Deactive" => 0,
            ];
            $statusValue = $statusMap[$request->status] ?? null;

            if ($statusValue !== null) {
                $query->whereHas('employee', function($q) use ($statusValue) {
                    $q->where('employee_status', $statusValue);
                });
            }
        }

        // Filter by employee_id if provided
        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by date if provided
        if ($request->date_time) {
            // Convert the date format from "17 March 2025" to "Y-m-d" format
            $formattedDate = Carbon::createFromFormat('d F Y', $request->date_time)->format('Y-m-d');
            $query->whereDate('date_time', $formattedDate);
        }

        $payments = $query->orderBy('date_time', 'desc')->get();

        return response()->json([
            'success' => true,
            'payments' => $payments,
            'message' => 'Payments filtered successfully'
        ]);
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
