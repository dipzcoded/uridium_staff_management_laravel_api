<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['staff_id', 'user_id', 'employment_date', 'sterling_bank_email', 'position', 'department','grade','supervisor','bank_acct_name','bank_acct_number','bank_bvn', 'is_active'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bioData()
    {
        return $this->hasOne(EmployeeBioData::class);
    }

    public function academicRecords()
    {
        return $this->hasMany(EmployeeAcademicRecords::class);
    }

    public function nextOfKins()
    {
        return $this->hasMany(EmployeeNextOfKins::class);
    }

    public function guarantors()
    {
        return $this->hasMany(EmployeeGuarantors::class);
    }
}
