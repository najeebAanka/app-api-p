<?php

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



Route::group(
        ['prefix' => 'v1/', 'middleware' =>  ['localization', 'cors']],
        function () {
            Route::get('categories', [App\Http\Controllers\API\CategoryController::class, 'index']);
            Route::get('categories/{id}', [App\Http\Controllers\API\CategoryController::class, 'show']);
            Route::get('categories/detailed/{id}', [App\Http\Controllers\API\CategoryController::class, 'allDetailed']);
            Route::post('calculate_price', [App\Http\Controllers\API\CategoryController::class, 'calculate_price']);
            Route::get('services', [App\Http\Controllers\API\ServicesController::class, 'index']);
            Route::get('find_professionals/{day}/{time}/{category}', [App\Http\Controllers\API\EmployeesController::class, 'getAccordingToSlots']);
            
            
            Route::post('otp/request', [App\Http\Controllers\API\AuthController::class, 'login']);
            Route::post('otp/verify', [App\Http\Controllers\API\AuthController::class, 'checkOtp']);
            Route::post('signup', [App\Http\Controllers\API\AuthController::class, 'createAccount']);
            //
        });
        //---------------
        
           Route::group(['prefix' => 'v1/','middleware' => ['auth:api','localization', 'cors']], function () {
           Route::resource('addresses', App\Http\Controllers\API\AddressController::class);     
           Route::put('account', [App\Http\Controllers\API\AuthController::class ,'update']);   
           Route::post('book', [App\Http\Controllers\API\BookingController::class ,'book']);   
           
           
           Route::get('admin/admin-notifications', [App\Http\Controllers\Admin\API\HomeNotificationsController::class ,'index']);     
           

     });