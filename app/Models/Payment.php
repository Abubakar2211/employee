<?php

namespace App\Models;
use App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = 'employee_payment';
    protected $fillable = ['employee_id','payment','date_time','employee_status'];
    protected $primaryKey = 'payment_id';

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','employee_id');
    }
}
