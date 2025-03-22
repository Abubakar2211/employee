<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
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
        return view('payment_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('payment_show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('payment_edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
