<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAcademicRecords extends Model
{
    
    use HasFactory;

    protected $fillable = ['employee_id','course_of_study','intitution','qualification','year_of_grad'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
