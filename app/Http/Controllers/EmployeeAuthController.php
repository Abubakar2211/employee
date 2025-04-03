<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'employee_code' => 'required',
            'employee_password' => 'required'
        ]);

        $employee = Employee::where('employee_code', $request->employee_code)->first();

        if($employee){
            $decryptedPassword = decrypt($employee->employee_password);
            if($request->employee_password === $decryptedPassword){
                $request->session()->put('employee_id', $employee->employee_id);
                $request->session()->put('employee_name', $employee->employee_name);
                $request->session()->regenerate();
                return redirect()->route('dashboard')->with('success', 'Employee logged in successfully');
            }
        }
        return redirect()->back()->with('login_error', 'Invalid Credentials');
    }
    public function logout(Request $request)
    {
        $request->session()->forget('employee_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

}
