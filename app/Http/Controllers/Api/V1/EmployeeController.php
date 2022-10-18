<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Employee\CreateEmployeeRequest;
use App\Http\Requests\Api\V1\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
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
    public function index()
    {
        
            $response = Gate::inspect('viewAny',Employee::class);

            if($response->allowed())
            {
             // returning back all employees from the Employee Model
        return $this->success(EmployeeResource::collection(Employee::all()));
            }else {
              return  $this->error(null,$response->message(),403);
            }  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {

        $response = Gate::inspect('create',Employee::class);

        if($response->allowed())
        {

            // store values from the req.body
            $request->validated($request->all());

        // checking if the email aleady exist in the User Model
        $employeeUser = User::where('email',$request->email)->first();

        if($employeeUser)
        {
            return $this->error(null,"user with email already exists",401);
        }

        // create user
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('uwelcome101')
        ]);

        // create a new employee and linking it with the user 
        $newEmployee = Employee::make([
            'staff_id' => $request->staffId,
            'user_id' => $newUser->id,
            'employment_date' => $request->employmentDate,
            'sterling_bank_email' => $request->sterlingBankEmail,
            'position' => $request->position,
            'department' => $request->department,
            'grade' => $request->grade,
            'supervisor' => $request->supervisor,
            'bank_acct_name' => $request->bankAcctName,
            'bank_acct_number' => $request->bankAcctNumber,
            'bank_bvn' => $request->bankBvn
        ]);

        // saving it to the database
        $newEmployee->save();
    
        // returning back a json response to the client
        return $this->success(
            new EmployeeResource($newEmployee),
            'employee created successfully!'
        );

        }else {
            return $this->error(null,$response->message(),403);
        }

        //
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $response = Gate::inspect('view', Employee::class);

        if($response->allowed())
        {
                  // Find user by id 
        $employee = Employee::find($id);

        // first checking if the employee exists
      if(!$employee)
      {
          return $this->error(null,'no employee found',404);
      }

      // return a json response
      return $this->success(new EmployeeResource($employee));       
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
    public function update(UpdateEmployeeRequest $request, $id)
    {

       

        // Find user by id 
        $employee = Employee::find($id);

        // first checking if the employee exists
        if(!$employee)
        {
            return $this->error(null,'no employee found',404);
        }

        $response = Gate::inspect('update',$employee);

        if($response->allowed())
        {

            $request->validated($request->all());

            $userEmployee = User::where('email',$request->email)->first();

            $userEmployee->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

              // den update the employee details
            $employee->update([
            'staff_id' => $request->staffId ? $request->staffId : $employee->staff_id,
            'employment_date' => $request->employmentDate ? $request->employmentDate : $employee->employment_date,
            'sterling_bank_email' => $request->sterlingBankEmail ? $request->sterlingBankEmail : $employee->sterling_bank_email,
            'position' => $request->position ? $request->position : $employee->position,
            'department' => $request->department ? $request->department : $employee->department,
            'grade' => $request->grade ? $request->grade : $employee->grade,
            'supervisor' => $request->supervisor ? $request->supervisor : $employee->supervisor,
            'bank_acct_name' => $request->bankAcctName ? $request->bankAcctName : $employee->bank_acct_name,
            'bank_acct_number' => $request->bankAcctNumber ? $request->bankAcctNumber : $employee->bank_acct_name,
            'bank_bvn' => $request->bankBvn ? $request->bankBvn : $employee->bank_bvn 
            ]);

        // return a json response
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
    public function destroy($id)
    {
        //find employee by id
        $employee = Employee::find($id);

        // check if it employee exists
        if(!$employee)
        {
            return $this->error(null,'no employee found',404);
        }

        $response = Gate::inspect('delete',$employee);

        if($response->allowed())
        {
             // getting user by employee id from the user model
        $employeeUser = User::find($employee->user_id);

        // checking if the employee user_id col matches with the user id
        if($employeeUser->id != $employee->user_id)
        {
            return $this->error(null,'employee user doesnt match with the user',404);
        }

    // change the is_active state of the employee to false
    $employee->update([
        'is_active' => false
    ]);

    $employee->user()->update([
        'is_active' => false
    ]);
        

        // returning nothing back as response
        return $this->success(new EmployeeResource($employee),null,200);  
        }else{
            return $this->error(null,$response->message(),403);
        }
    }

    public function restoreEmployee($id)
    {
        //find employee by id
        $employee = Employee::find($id);

        // check if it employee exists
        if(!$employee)
        {
            return $this->error(null,'no employee found',404);
        }

        $response = Gate::inspect('restoreActive',$employee);

        if($employee->is_active)
        {
            return $this->error(null,"employee is already active...restoring not needed",400);
        }

        if($response->allowed())
        {
             // getting user by employee id from the user model
        $employeeUser = User::find($employee->user_id);

        // checking if the employee user_id col matches with the user id
        if($employeeUser->id != $employee->user_id)
        {
            return $this->error(null,'employee user doesnt match with the user',404);
        }

        // change the is_active state of the employee to false
        $employee->update([
            'is_active' => true
        ]);

        $employee->user()->update([
            'is_active' => true
        ]);

        // returning nothing back as response
        return $this->success(new EmployeeResource($employee),null,200);  
        }else{
            return $this->error(null,$response->message(),403);
        }
    }
}
