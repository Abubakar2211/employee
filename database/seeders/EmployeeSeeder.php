<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employee = [
            '00001', 'Admin', 'admin@gmail.com', 'Admin123@', '03403331943', '42401-854535-8', '2005-04-13', '2024-11-12', 1
        ];

        $encryptedPassword = encrypt($employee[3]);
        Employee::create([
            'employee_code' => $employee[0],
            'employee_name' => $employee[1],
            'employee_email' => $employee[2],
            'employee_password' => $encryptedPassword,
            'employee_number' => $employee[4],
            'employee_CNIC' => $employee[5],
            'employee_d_o_b' => $employee[6],
            'employee_d_o_j' => $employee[7],
            'employee_status' => $employee[8]
        ]);
    }
}
