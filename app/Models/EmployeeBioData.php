<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBioData extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'personal_email', 'sex', 'date_of_birth', 'state_of_origin','marital_status','religion','phone_number','home_address'];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
