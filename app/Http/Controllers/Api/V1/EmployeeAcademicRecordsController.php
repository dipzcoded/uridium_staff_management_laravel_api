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
        //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeAcademicsRecords = EmployeeAcademicRecords::where('employee_id',$employee->id)->get();

        return $this->success(EmployeeAcademicRecordsResource::collection($employeeAcademicsRecords));
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

        $employee->academicRecords()->create($request->all());

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
        $employee = Employee::find($employeeId);
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeAcademicRecord = EmployeeAcademicRecords::find($academicRecordId);

        if(!$employeeAcademicRecord)
        {
            return $this->error(null,"employee academic doesnt exist",404);
        }

        if($employeeAcademicRecord->employee_id != $employee->id)
        {
            return $this->error(null,"the academic record is not for the employee");
        }

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
        $employee = Employee::find($employeeId);
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeAcademicRecord = EmployeeAcademicRecords::find($academicRecordId);

        if(!$employeeAcademicRecord)
        {
            return $this->error(null,"employee academic doesnt exist",404);
        }

        if($employeeAcademicRecord->employee_id != $employee->id)
        {
            return $this->error(null,"the academic record is not for the employee");
        }

        $employeeAcademicRecord->update($request->all());

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
        //
        $employee = Employee::find($employeeId);
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeAcademicRecord = EmployeeAcademicRecords::find($academicRecordId);

        if(!$employeeAcademicRecord)
        {
            return $this->error(null,"employee academic doesnt exist",404);
        }

        if($employeeAcademicRecord->employee_id != $employee->id)
        {
            return $this->error(null,"the academic record is not for the employee");
        }

        $employeeAcademicRecord->delete();
        return $this->success(null,null,204);
    }
}
