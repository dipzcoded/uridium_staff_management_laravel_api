<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {

        $response = Gate::inspect('create',Employee::class);

        if($response->allowed())
        {

            // store values from the req.body
        $body = $request->all();

        // checking if the email aleady exist in the User Model
        $employeeUser = User::where('email',$body['email'])->first();

        if($employeeUser)
        {
            return $this->error(null,"user with email already exists",401);
        }

        // create user
        $newUser = User::create([
            'name' => $body['name'],
            'email' => $body['email'],
            'password' => Hash::make('uwelcome101')
        ]);

        // create a new employee and linking it with the user 
        $newEmployee = Employee::make([
            'staff_id' => $body['staff_id'],
            'user_id' => $newUser->id,
            'employment_date' => $body['employment_date'],
            'sterling_bank_email' => $body['sterling_bank_email'],
            'position' => $body['position'],
            'department' => $body['department'],
            'grade' => $body['grade'],
            'supervisor' => $body['supervisor'],
            'bank_acct_name' => $body['bank_acct_name'],
            'bank_acct_number' => $body['bank_acct_number'],
            'bank_bvn' => $body['bank_bvn']
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
    public function update(Request $request, $id)
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
              // den update the employee details
        $employee->update($request->all());

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
