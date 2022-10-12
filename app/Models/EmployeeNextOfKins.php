<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeNextOfKins extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','name','phone_number','nin'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
