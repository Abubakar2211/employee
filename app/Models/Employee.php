<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $table = 'employees';
    protected $fillable = ['employee_code','employee_name','employee_email','employee_password','employee_number','employee_CNIC','employee_d_o_b','employee_d_o_j','employee_status'];
    protected $primaryKey = 'employee_id';
    public function payments()
    {
        return $this->hasMany(Payment::class, 'employee_id', 'employee_id');
    }   
}
