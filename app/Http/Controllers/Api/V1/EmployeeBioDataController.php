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
        // getting employee by id
        $employee = Employee::find($employeeId);

        // checking if the employee exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // finding employee bioData;
        $employeeBioData = EmployeeBioData::where('employee_id',$employee->id)->first();

        // checking if bio data exists
        if(!$employeeBioData)
        {
            return $this->error(null,"employee biodata doesnt not exist",404);
        }

        // return a json response
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
        // finding employee by employee id
        $employee = Employee::find($employeeId);


        // checking if employee exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // getting employee biodata
        $employeeBioDataExist = EmployeeBioData::where('employee_id',$employee->id)->first();

        // checking if it exist
        if($employeeBioDataExist)
        {
            return $this->error(null,"employee already have a bio data information",401);
        }

        // create employee data
        $employee->bioData()->create($request->all());

        // returning a json response
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
        // find employee by employeeId
        $employee = Employee::find($employeeId);

        // checking if employee exist
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // finding employee biodata by biodataId
        $employeeBioData = EmployeeBioData::find($bioDataId);
    
        // checking if it exist
        if(!$employeeBioData)
        {
            return $this->error(null,"employee bio data does not exist - invalid id",404);
        }

        // checking if the biodata employee_id is the same with the employee id
        if($employeeBioData->employee_id != $employee->id)
        {
            return $this->error(null,"employee bio data doesnt match the employee id",404);
        }

        // return a json response
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
        // find employee by employeeid
        $employee = Employee::find($employeeId);

        // checking if it exist
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // finding employee bio data by employee id
        $employeeBioData = EmployeeBioData::find($bioDataId);
    
        // checking if employee bio data exist
        if(!$employeeBioData)
        {
            return $this->error(null,"employee bio data does not exist - invalid id",404);
        }
        
        //  checking if the biodata employee_id is the same with the employee id
        if($employeeBioData->employee_id != $employee->id)
        {
            return $this->error(null,"employee bio data doesnt match the employee id",404);
        }

        // updating employee bio data
        $employee->bioData()->update($request->all());

        // returning a json response
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
        // find employee by employeeid
        $employee = Employee::find($employeeId);

        // checking if it exist
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // finding employee bio data by employee id
        $employeeBioData = EmployeeBioData::find($bioDataId);
    
        // checking if employee bio data exist
        if(!$employeeBioData)
        {
            return $this->error(null,"employee bio data does not exist - invalid id",404);
        }
        
        //  checking if the biodata employee_id is the same with the employee id
        if($employeeBioData->employee_id != $employee->id)
        {
            return $this->error(null,"employee bio data doesnt match the employee id",404);
        }

        // deleting employee bio data 
        $employee->bioData()->delete();

        // return nothing back
        return $this->success(null,null,204);

    }
}
