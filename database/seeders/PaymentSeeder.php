<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Payment::create([
                'Employee_id' => rand(1, 8),
                'payment' => rand(5000, 20000),
                'date_time' => Carbon::now()->subDays(rand(1, 365)),
                'payment_status' => rand(0, 1),
            ]);
        }
    }
}

