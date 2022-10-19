<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserAsEmployeeController extends Controller
{
    //
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $response = Gate::inspect('mustEmployee', User::class);

        if($response->allowed())
        {
            $employee = Employee::where('user_id',$request->user()->id)->first();
            return $this->success(new EmployeeResource($employee));

        }else{
            return $this->error(null,$response->message(),403);
        }
    }

}
