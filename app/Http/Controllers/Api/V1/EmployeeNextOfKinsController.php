<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EmployeeNextOfKinsResource;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeNextOfKins;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployeeNextOfKinsController extends Controller
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

        $response = Gate::inspect('viewAny', EmployeeNextOfKins::class);
        if($response->allowed()){
             //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        return $this->success(EmployeeNextOfKinsResource::collection($employee->nextOfKins));
        }else{
        return $this->error(null, $response->message(), 403);
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

        $response = Gate::inspect('create', EmployeeNextOfKins::class);

        if($response->allowed())
        {
             //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employee->nextOfKins()->create($request->all());

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
    public function show($employeeId, $nextOfKinsId)
    {

        $response = Gate::inspect('view', EmployeeNextOfKins::class);

        if($response->allowed())
        {
             //
        $employee = Employee::find($employeeId);

        if(!$employee)
        {
            return $this->error(null,"employee not found",404);
        }

        $employeeNextOfKin = EmployeeNextOfKins::find($nextOfKinsId);
        if(!$employeeNextOfKin)
        {
            return $this->error(null,"employee nextOfKin not found",404);
        }

        if($employee->id != $employeeNextOfKin->employee_id){
            return $this->error(null,"guarantor is not meant for employee",403);
        }

        return $this->success(new EmployeeNextOfKinsResource($employeeNextOfKin));
        }else{
        return $this->error(null, $response->message(), 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employeeId, $nextOfKinsId)
    {
        //

        $response = Gate::inspect('update',EmployeeNextOfKins::class);

        if($response->allowed()){
            $employee = Employee::find($employeeId);

            if(!$employee)
            {
                return $this->error(null,"employee not found",404);
            }
    
            $employeeNextOfKin = EmployeeNextOfKins::find($nextOfKinsId);
            if(!$employeeNextOfKin)
            {
                return $this->error(null,"employee nextOfKin not found",404);
            }
    
            if($employee->id != $employeeNextOfKin->employee_id){
                return $this->error(null,"guarantor is not meant for employee",403);
            }
    
            $employeeNextOfKin->update($request->all());
            
            return $this->success(new EmployeeResource($employee));
        }else{
            return $this->error(null, $response->message(), 403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employeeId, $nextOfKinsId)
    {
        //
        $response = Gate::inspect('delete', EmployeeNextOfKins::class);

        if($response->allowed())
        {

            $employee = Employee::find($employeeId);

            if(!$employee)
            {
                return $this->error(null,"employee not found",404);
            }
    
            $employeeNextOfKin = EmployeeNextOfKins::find($nextOfKinsId);
            if(!$employeeNextOfKin)
            {
                return $this->error(null,"employee nextOfKin not found",404);
            }
    
            if($employee->id != $employeeNextOfKin->employee_id){
                return $this->error(null,"guarantor is not meant for employee",403);
            }
    
            $employeeNextOfKin->delete();
            return $this->success(null,null,204);

        }else{
            return $this->error(null, $response->message(), 403);
        }  
    }
}
