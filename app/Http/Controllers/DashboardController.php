<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Payment;


class DashboardController extends Controller
{
    public function index(){
        $employee_total = Employee::count('employee_id');
        $employee_active = Employee::where('employee_status',1)->count();
        $employee_deactive = Employee::where('employee_status',0)->count();
        $total_payments = Employee::where('employee_status',1)->count();
        return view('dashboard',compact('employee_total','employee_active','employee_deactive','total_payments'));
    }
}
