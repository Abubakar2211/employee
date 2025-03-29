<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;


class DashboardController extends Controller
{
    public function index(){
        $employeeTotal = Employee::count('employee_id');
        return view('dashboard',compact('employeeTotal'));
    }
}
