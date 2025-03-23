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
        $payments = Payment::with('employee')->get();
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
            'date_time' => 'required',
            'employee_status' => 'boolean',
        ]);
        $payment['date_time'] = Carbon::parse($payment['date_time'])->format('Y-m-d H:i:s');
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

    public function getPaymentsByStatus(Request $request)
    {
        $status = $request->input('status');
        $statusMap = [
            "Active" => 1,
            "Deactive" => 0,
        ];
        $statusValue = $statusMap[$status] ?? null;

        if ($statusValue !== null) {
            $employees = Payment::with('employee')
                ->where('employee_status', $statusValue)
                ->join('employees', 'payments.employee_id', '=', 'employees.employee_id')
                ->select('employees.employee_id', 'employees.employee_name')
                ->get()
                ->pluck('employee_name', 'employee_id');

            return response()->json($employees);
        }

        return response()->json([]);
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
}
