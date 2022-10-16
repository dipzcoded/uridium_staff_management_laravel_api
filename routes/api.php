<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EmployeeAcademicRecordsController;
use App\Http\Controllers\Api\V1\EmployeeBioDataController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\EmployeeGuarantorsController;
use App\Http\Controllers\Api\V1\EmployeeNextOfKinsController;
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
    // Test Routes
    Route::get('/test', function(){
        return response()->json(['status' => 'OK'],200);
    })->name('test');

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

    // Auth Routes
    Route::post('auth/register/admin',[AuthController::class,'register']);
    Route::post('auth/login',[AuthController::class,'login']);
    Route::post("auth/logout",[AuthController::class,'logout']);
});

Route::fallback(function()
{
    return response()->json(['message' => 'not found'],404);
});