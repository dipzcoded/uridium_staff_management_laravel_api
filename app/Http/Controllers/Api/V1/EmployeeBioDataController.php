<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EmployeeBioDataResource;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeBioData;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class EmployeeBioDataController extends Controller
{

    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($employeeId)
    {
        //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeBioData = EmployeeBioData::where('employee_id',$employee->id)->first();

        if(!$employeeBioData)
        {
            return $this->error(null,"employee doesnt not exist",404);
        }

        return $this->success(new EmployeeBioDataResource($employeeBioData));

        // return $employeeBioData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $employeeId)
    {
        //
        $employee = Employee::find($employeeId);


        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeBioDataExist = EmployeeBioData::where('employee_id',$employee->id)->first();

        if($employeeBioDataExist)
        {
            return $this->error(null,"employee already have a bio data information",401);
        }

        $employee->bioData()->create($request->all());

        return $this->success(new EmployeeResource($employee));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employeeId, $bioDataId)
    {
        //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeBioData = EmployeeBioData::find($bioDataId);
    
        if(!$employeeBioData)
        {
            return $this->error(null,"employee bio data does not exist - invalid id",404);
        }

        if($employeeBioData->employee_id != $employee->id)
        {
            return $this->error(null,"employee bio data doesnt match the employee id",404);
        }

        return $this->success(new EmployeeBioDataResource($employeeBioData),null);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employeeId, $bioDataId)
    {
        //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeBioData = EmployeeBioData::find($bioDataId);
    
        if(!$employeeBioData)
        {
            return $this->error(null,"employee bio data does not exist - invalid id",404);
        }

        if($employeeBioData->employee_id != $employee->id)
        {
            return $this->error(null,"employee bio data doesnt match the employee id",404);
        }

        $employee->bioData()->update($request->all());

        return $this->success(new EmployeeResource($employee));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employeeId, $bioDataId)
    {
        //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeBioData = EmployeeBioData::find($bioDataId);
    
        if(!$employeeBioData)
        {
            return $this->error(null,"employee bio data does not exist - invalid id",404);
        }

        if($employeeBioData->employee_id != $employee->id)
        {
            return $this->error(null,"employee bio data doesnt match the employee id",404);
        }

        $employee->bioData()->delete();

        return $this->success(null,null,204);

    }
}
