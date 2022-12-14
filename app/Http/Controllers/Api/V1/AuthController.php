<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use HttpResponses;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['logout','changePassword']);
    }


    public function register(RegisterRequest $request)
    {
        // validating the request body 
         $request->validated($request->all());

        // creating an admin
        $newAdminUser = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        // issue a token
        return $this->success([
            'user' => $newAdminUser,
            'token' => $newAdminUser->createToken('API Token of ' . $newAdminUser->email)->plainTextToken,
            'token_type' => 'Bearer'
        ],null,201);
    }


    public function login(LoginRequest $request){

        // validating the request body
        $request->validated($request->all());

        // checking the user exist and if the password matches
        if(!Auth::attempt($request->only(['email','password'])))
        {
            return $this->error(null,"Invalid Login Credentails",401);
        }

        // finding user by email
        $user = User::where('email',$request->email)->first();

        // checking if the user is active
        if($user->is_active)
        {
             // issue a token
         return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->email)->plainTextToken,
            'token_type' => 'Bearer'
        ]);
        }else {
            return $this->error(null,"cannot not login...ask admin to give you acccess",403);
        }

        

    }


    public function logout()
    {
        // Revoke the token that was used to authenticate the current request...
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'You have been successfully logout!'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->validated($request->all());

        $user = User::find($request->user()->id);
        $user->makeVisible(['password']);
        
        if($user)
        {
            if(Hash::check($request->oldPassword,$user->password))
            {
                $user->password = Hash::make($request->newPassword);
                $user->save();
                $user->makeHidden(['password']);
                return $this->success($user,"password updated succesfully");
            }else {
                return $this->error(null,"old password didnt match",403);
            }
        }else{
            return $this->error(null,"user not found",404);
        }

    }
}
