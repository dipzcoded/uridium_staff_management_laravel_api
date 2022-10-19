<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\EmployeeBioDate\CreateEmployeeBioDataRequest;
use App\Http\Requests\Api\V1\EmployeeBioDate\UpdateEmployeeBioDataRequest;
use App\Http\Resources\Api\V1\EmployeeBioDataResource;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeBioData;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployeeBioDataController extends Controller
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

        $response = Gate::inspect('viewAny',EmployeeBioData::class);

        if($response->allowed())
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
        }else{
            return $this->error(null,$response->message(),403);
        }

       

        // return $employeeBioData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeBioDataRequest $request, $employeeId)
    {

        $response = Gate::inspect('create',EmployeeBioData::class);

        if($response->allowed())
        {

            $request->validated($request->all());

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
        $employee->bioData()->create([
            'personal_email' => $request->personalEmail,
            'sex' => $request->sex,
            'date_of_birth' => $request->dateOfBirth,
            'state_of_origin' => $request->stateOfOrigin,
            'marital_status' => $request->maritalStatus,
            'religion' => $request->religion,
            'phone_number' => $request->phoneNumber,
            'home_address' => $request->homeAddress
        ]);

        // returning a json response
        return $this->success(new EmployeeResource($employee));
        }else{
            return $this->error(null,$response->message(),403);
        }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employeeId, $bioDataId)
    {

        $response = Gate::inspect('view',EmployeeBioData::class);

        if($response->allowed()){
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
            return $this->error(null,"employee bio data doesnt match the employee id",403);
        }

        // return a json response
        return $this->success(new EmployeeBioDataResource($employeeBioData),null);
        }else{
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
    public function update(UpdateEmployeeBioDataRequest $request, $employeeId, $bioDataId)
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
            return $this->error(null,"employee bio data doesnt match the employee id",403);
        }

        $response = Gate::inspect('update',$employeeBioData);

        if($response->allowed())
        {
            $request->validated($request->all());

            // updating employee bio data
        $employeeBioData->update([
            'personal_email' => $request->personalEmail ? $request->personalEmail : $employeeBioData->personal_email,
            'sex' => $request->sex ? $request->sex : $employeeBioData->sex,
            'date_of_birth' => $request->dateOfBirth ? $request->dateOfBirth : $employeeBioData->date_of_birth,
            'state_of_origin' => $request->stateOfOrigin ? $request->stateOfOrigin : $employeeBioData->state_of_origin,
            'marital_status' => $request->maritalStatus ? $request->maritalStatus : $employeeBioData->marital_status,
            'religion' => $request->religion ? $request->religion : $employeeBioData->religion,
            'phone_number' => $request->phoneNumber ? $request->phoneNumber : $employeeBioData->phone_number,
            'home_address' => $request->homeAddress ? $request->homeAddress : $employeeBioData->home_address
        ]);

        // returning a json response
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
    public function destroy($employeeId, $bioDataId)
    {

        $response = Gate::inspect('delete',EmployeeBioData::class);

        if($response->allowed())
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
            return $this->error(null,"employee bio data doesnt match the employee id",403);
        }

        // deleting employee bio data 
        $employeeBioData->delete();

        // return nothing back
        return $this->success(null,null,204);
        }else{

        return $this->error(null,$response->message(),403);

        }
    }
}
