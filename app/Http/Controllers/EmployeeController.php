<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // EmployeeController.php

    public function index()
    {
        $employees = Employee::where('employee_status', 1)->get();
        $allStatus = ['Active', 'Deactive', 'All'];

        $allEmployees = Employee::pluck('employee_name', 'employee_id');

        return view('employees', compact('employees', 'allStatus', 'allEmployees'));
    }
    public function filterEmployees(Request $request)
    {
        $status = $request->input('status');
        $employeeId = $request->input('employee_id');

        $query = Employee::query();

        if ($status && $status !== 'All') {
            $statusMap = [
                "Active" => 1,
                "Deactive" => 0,
            ];
            $statusValue = $statusMap[$status] ?? null;

            if ($statusValue !== null) {
                $query->where('employee_status', $statusValue);
            }
        }

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        $employees = $query->get();

        return response()->json($employees);
    }
    public function getEmployeesByStatus(Request $request)
    {
        $status = $request->input('status');

        if ($status === 'All') {
            $employees = Employee::pluck('employee_name', 'employee_id');
        } else {
            $statusMap = [
                "Active" => 1,
                "Deactive" => 0,
            ];
            $statusValue = $statusMap[$status] ?? null;

            if ($statusValue !== null) {
                $employees = Employee::where('employee_status', $statusValue)
                    ->pluck('employee_name', 'employee_id');
            } else {
                $employees = [];
            }
        }

        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latestEmployee = Employee::latest('employee_code')->first();
        $employee_code = $latestEmployee ? sprintf('%05d', $latestEmployee->employee_code + 1) : '00001';
        return view('employee_create', compact('employee_code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = $request->validate([
            'employee_code' => 'required',
            'employee_name' => 'required',
            'employee_email' => 'email|unique:employees,employee_email|nullable',
            'employee_password' => 'required',
            'employee_number' => 'nullable',
            'employee_CNIC' => 'nullable',
            'employee_d_o_b' => 'required',
            'employee_d_o_j' => 'required',
            'employee_status' => 'boolean',
        ]);
        $employee['employee_password'] = Hash::make($request->employee_password);
        Employee::create($employee);
        return redirect()->route('employee.index')->with('success', 'Employee Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $employee = Employee::findOrFail($id);
        // return view('employee_show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::where('employee_id', $id)->first();
        return view('employee_edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::where('employee_id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'employee_code' => 'required',
            'employee_name' => 'required',
            'employee_email' => 'nullable|email|unique:employees,employee_email,' . $id . ',employee_id',
            'employee_password' => 'required',
            'employee_number' => 'nullable',
            'employee_CNIC' => 'nullable',
            'employee_d_o_b' => 'required',
            'employee_d_o_j' => 'required',
            'employee_status' => 'boolean',
        ]);

        $employee->update($validatedData);

        return redirect()->route('employee.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully!');

    }

}
