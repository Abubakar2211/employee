<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'employee_code' => '00001' ,
            'employee_name' => 'Admin',
            'employee_email' => 'Admin@gmail.com',
            'employee_password' => Hash::make('Admin123@'),
            'employee_number' => '03403331943',
            'employee_CNIC' => '42401-854535-8',
            'employee_d_o_b' => '13-April-2005',
            'employee_d_o_j' => '12-November-2024',
            'employee_status' => 1
        ]);
    }
}
