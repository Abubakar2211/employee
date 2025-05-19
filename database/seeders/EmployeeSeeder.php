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
        $employees = [
            ['00001', 'Admin', 'admin@gmail.com', 'Admin123@', '03403331943', '42401-854535-8', '2005-04-13', '2024-11-12', 1],
            // ['00002', 'Ali', 'ali@gmail.com', 'Ali123@', '03401234567', '42401-1234567-8', '1995-08-21', '2023-07-10', 1],
            // ['00003', 'Sara', 'sara@gmail.com', 'Sara123@', '03407654321', '42401-7654321-9', '1990-02-15', '2022-03-05', 1],
            // ['00004', 'Bilal', 'bilal@gmail.com', 'Bilal123@', '03409876543', '42401-9876543-0', '1988-12-30', '2021-01-20', 1],
            // ['00005', 'Hina', 'hina@gmail.com', 'Hina123@', '03405678901', '42401-5678901-2', '1997-06-18', '2023-09-14', 0],
            // ['00006', 'Usman', 'usman@gmail.com', 'Usman123@', '03403216548', '42401-3216548-3', '1993-11-25', '2020-10-01', 0],
            // ['00007', 'Zara', 'zara@gmail.com', 'Zara123@', '03407891234', '42401-7891234-5', '1992-04-07', '2019-12-18', 0],
            // ['00008', 'Kamran', 'kamran@gmail.com', 'Kamran123@', '03404321987', '42401-4321987-6', '1985-09-09', '2018-05-30', 0],
        ];

        foreach ($employees as $emp) {
            $encryptedPassword = encrypt($emp[3]);
            Employee::create([
                'employee_code' => $emp[0],
                'employee_name' => $emp[1],
                'employee_email' => $emp[2],
                'employee_password' => $encryptedPassword,
                'employee_number' => $emp[4],
                'employee_CNIC' => $emp[5],
                'employee_d_o_b' => $emp[6],
                'employee_d_o_j' => $emp[7],
                'employee_status' => $emp[8]
            ]);
        }
    }
}
