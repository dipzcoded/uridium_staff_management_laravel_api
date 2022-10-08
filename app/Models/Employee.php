<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\EmployeeBioData;
use App\Models\EmployeeAcademicRecords;
use App\Models\EmployeeGuarantors;
use App\Models\EmployeeNextOfKins;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['staffId', 'employmentDate', 'sterlingBankEmail', 'position', 'department','grade','supervisor','bankAcctName','bankAcctNumber','bankBvn'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bioData()
    {
        return $this->hasOne(EmployeeBioData::class,'employeeId','id');
    }

    public function academicRecords()
    {
        return $this->hasMany(EmployeeAcademicRecords::class,'employeeId','id');
    }

    public function nextOfKins()
    {
        return $this->hasMany(EmployeeNextOfKins::class,'employeeId','id');
    }

    public function guarantors()
    {
        return $this->hasMany(EmployeeGuarantors::class,'employeeId','id');
    }
}
