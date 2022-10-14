<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EmployeeAcademicRecordsResource;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeAcademicRecords;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class EmployeeAcademicRecordsController extends Controller
{

    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($employeeId)
    {
        // fetching employee by employeeLid param
        $employee = Employee::find($employeeId);

        // checking if the employee exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

       

        // returning a json response 
        return $this->success(EmployeeAcademicRecordsResource::collection($employee->academicRecords));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $employeeId)
    {
        // finding the employee by employeeId param
        $employee = Employee::find($employeeId);

        // checking if it exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // storing the employee academic records to the database
        $employee->academicRecords()->create($request->all());

        // returning a json response
        return $this->success(new EmployeeResource($employee));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employeeId, $academicRecordId)
    {
        //
        // finding employee by employeeId param
        $employee = Employee::find($employeeId);

        // checking if the employee exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // getting the employee academic record by academicRecordId param
        $employeeAcademicRecord = EmployeeAcademicRecords::find($academicRecordId);

        // checking if it exist
        if(!$employeeAcademicRecord)
        {
            return $this->error(null,"employee academic doesnt exist",404);
        }


        // checking if it matches with the employee
        if($employeeAcademicRecord->employee_id != $employee->id)
        {
            return $this->error(null,"the academic record is not for the employee",403);
        }

        // returning a json response
        return $this->success(new EmployeeAcademicRecordsResource($employeeAcademicRecord));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employeeId, $academicRecordId)
    {
        //
        // finding employee by employeeId param
        $employee = Employee::find($employeeId);

        // checking if it exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // finding the employee academic record by academicRecordId
        $employeeAcademicRecord = EmployeeAcademicRecords::find($academicRecordId);

        // checking if it exists
        if(!$employeeAcademicRecord)
        {
            return $this->error(null,"employee academic doesnt exist",404);
        }

        // checking if it matches with the employee id
        if($employeeAcademicRecord->employee_id != $employee->id)
        {
            return $this->error(null,"the academic record is not for the employee");
        }

        // updating the employee academic record 
        $employeeAcademicRecord->update($request->all());

        // returning json response
        return $this->success(new EmployeeResource($employee));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employeeId, $academicRecordId)
    {
        // finding the employee by employeeId
        $employee = Employee::find($employeeId);

        // checking if it exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // finding employee academic record by academicRecordId param
        $employeeAcademicRecord = EmployeeAcademicRecords::find($academicRecordId);

        // checking if it exists
        if(!$employeeAcademicRecord)
        {
            return $this->error(null,"employee academic doesnt exist",404);
        }

        // checking if the employee academic record matches with the employee
        if($employeeAcademicRecord->employee_id != $employee->id)
        {
            return $this->error(null,"the academic record is not for the employee");
        }

        // delete the academic record
        $employeeAcademicRecord->delete();

        // return a json response
        return $this->success(null,null,204);
    }
}
