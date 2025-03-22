<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('employee_id');
            $table->string('employee_code');
            $table->string('employee_name');
            $table->string('employee_email')->nullable();
            $table->string('employee_password');
            $table->string('employee_number')->nullable();
            $table->string('employee_CNIC')->nullable();
            $table->string('employee_d_o_b');
            $table->string('employee_d_o_j');
            $table->boolean('employee_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
