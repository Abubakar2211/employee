<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = 'employee_payment';
    protected $fillable = ['employee_id','date_time','employee_status'];
    protected $primaryKey = 'payment_id';
}
