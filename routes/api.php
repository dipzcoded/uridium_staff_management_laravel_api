<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EmployeeAcademicRecordsController;
use App\Http\Controllers\Api\V1\EmployeeBioDataController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\EmployeeGuarantorsController;
use App\Http\Controllers\Api\V1\EmployeeNextOfKinsController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\UserAsEmployeeController;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->name('api.v1.')->group(function(){
    // Employee Routes
    Route::apiResource('employee',EmployeeController::class);

    // update employee active state
    Route::patch('employee/{id}/restore',[EmployeeController::class,'restoreEmployee']);

    // Employee BioData Routes
    Route::apiResource('employee.biodata',EmployeeBioDataController::class);
    // Employee Academic Records Routes
    Route::apiResource('employee.academic-records',EmployeeAcademicRecordsController::class);
    // Employee NextOfKins Routes
    Route::apiResource('employee.next-of-kins',EmployeeNextOfKinsController::class);
    // Employee Guarantors Routes
    Route::apiResource('employee.guarantors',EmployeeGuarantorsController::class);

    // User Logged in As Employee Routes
    Route::get('user/employee',[UserAsEmployeeController::class,'index']);


    // Auth Routes
    Route::get('/auth/current/me',function(Request $request){
        return new UserResource($request->user());
    })->middleware('auth:sanctum');

    Route::post('auth/register/admin',[AuthController::class,'register']);
    Route::post('auth/login',[AuthController::class,'login']);
    Route::post("auth/logout",[AuthController::class,'logout']);
    Route::post('auth/user/change-password', [AuthController::class,'changePassword']);
    

    // Image
    Route::post('/user/profile/image-upload',[ImageController::class,'userProfileImage']);
    
});

Route::fallback(function()
{
    return response()->json(['message' => 'not found'],404);
});