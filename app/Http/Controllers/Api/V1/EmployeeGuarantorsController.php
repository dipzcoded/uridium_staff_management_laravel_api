<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EmployeeGuarantorsResource;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeGuarantors;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployeeGuarantorsController extends Controller
{

    use HttpResponses;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($employeeId)
    {

        $response = Gate::inspect('viewAny',EmployeeGuarantors::class);

        if($response->allowed())
        {
             // finding employee by employeeId param
        $employee = Employee::find($employeeId);

        // checking if the employee exists
        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        // returning json response
        return $this->success(EmployeeGuarantorsResource::collection($employee->guarantors));
        }else{
            $this->error(null, $response->message(), 403);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $employeeId)
    {

        $response = Gate::inspect('create',EmployeeGuarantors::class);

        if($response->allowed())
        {
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
        }else{
        return $this->error(null, $response->message(), 403);
        }

       

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

        $response = Gate::inspect('view', EmployeeGuarantors::class);
        
        if($response->allowed()){
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
                return $this->error(null,"guarantor is not meant for employee",403);
            }
    
            return $this->success(new EmployeeGuarantorsResource($employeeGuarantor));
        }else {
            return $this->error(null,$response->message(),403);
        }

       
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
        $response = Gate::inspect('update',EmployeeGuarantors::class);

        if($response->allowed())
        {
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

        $employeeGuarantor->update($request->all());

        return $this->success(new EmployeeResource($employee));
        }else {
        return $this->error(null,$response->message(),403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employeeId, $guarantorId)
    {
        //

        $response = Gate::inspect('delete', EmployeeGuarantors::class);

        if($response->allowed())
        {
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
    
            $employeeGuarantor->delete();
    
            $this->success(null,null,204);
    
        }else{
            return $this->error(null, $response->message(), 403);
        }
    }
}
