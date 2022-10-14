<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EmployeeGuarantorsResource;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeGuarantors;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class EmployeeGuarantorsController extends Controller
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
        // finding employee by employeeId param
        $employee = Employee::find($employeeId);

        // checking if the employee exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // returning json response
        return $this->success(EmployeeGuarantorsResource::collection($employee->guarantors));

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
        // finding employee by employeeId param
        $employee = Employee::find($employeeId);

        // checking if the employee exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // storing the employee guarantor
        $employee->guarantors()->create($request->all());

        // returning json response
        return $this->success(new EmployeeResource($employee));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employeeId, $guarantorId)
    {
        //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeGuarantor = EmployeeGuarantors::find($guarantorId);
        if(!$employeeGuarantor)
        {
            return $this->error(null,"employee guarantor not found",404);
        }

        if($employee->id != $employeeGuarantor->employee_id){
            return $this->error(null,"guarantor is not meant for employee",401);
        }

        return $this->success(new EmployeeGuarantorsResource($employeeGuarantor));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employeeId, $guarantorId)
    {
        //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeGuarantor = EmployeeGuarantors::find($guarantorId);

        if(!$employeeGuarantor)
        {
            return $this->error(null,"employee guarantor not found",404);
        }

        if($employeeGuarantor->employee_id != $employee->id)
        {
            return $this->error(null,"guarantor not associated with the employee",403);
        }

        $employee->guarantors()->update($request->all());

        return $this->success(new EmployeeResource($employee));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
