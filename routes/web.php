<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('admin', function () {
    return view('dashboard/welcome');
})->name('login');


Route::post('auth/login',[App\Http\Controllers\AuthController::class, 'login']);
Route::get('auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);



Route::middleware('auth')->group(function () {

Route::get('admin/home', function () {
    return view('dashboard/home');
});
Route::get('home', function () {
     return view('dashboard/home');
});
Route::get('admin/category/{id}/professionals', function () {
     return view('dashboard/category/layouts/single-category-professionals');
});
Route::get('admin/category/{id}/services', function () {
     return view('dashboard/category/layouts/single-category-services');
});
Route::get('admin/category/{id}/frequencies', function () {
     return view('dashboard/category/layouts/single-category-frequencies');
});
Route::get('admin/category/{id}/params', function () {
     return view('dashboard/category/layouts/single-category-params');
});

Route::get('admin/users', function () {
     return view('dashboard/users/users-grid');
});

Route::get('admin/category/{id}', function () {
     return view('dashboard/category/single-category');
});

Route::get('admin/categories',function () {
    return view('dashboard/category/categories-grid');
});

Route::get('admin/booking-requests',function () {
    return view('dashboard/bookings/bookings');
});

Route::get('admin/single-booking/{id}',function () {
    return view('dashboard/bookings/single-booking');
});


Route::get('admin/professionals',function () {
    return view('dashboard/professionals/professionals-grid');
});
Route::get('admin/professional/{id}',function () {
    return view('dashboard/professionals/single-professional');
});

//Route::get('admin/{v}',function ($v) {
//    return view('dashboard/'.$v);
//});

Route::get('admin/universal/{v}',[App\Http\Controllers\Admin\UniversalController::class, 'render']);

// Categories routes --------------------
Route::post('backend/categories/insert',[App\Http\Controllers\Admin\CategoriesController::class, 'insert']);
Route::post('backend/categories/update',[App\Http\Controllers\Admin\CategoriesController::class, 'update']);
Route::post('backend/categories/delete',[App\Http\Controllers\Admin\CategoriesController::class, 'delete']);
//-----------------------------------

// Services routes --------------------
Route::post('backend/services/insert',[App\Http\Controllers\Admin\ServicesController::class, 'insert']);
Route::post('backend/services/update',[App\Http\Controllers\Admin\ServicesController::class, 'update']);
Route::post('backend/services/delete',[App\Http\Controllers\Admin\ServicesController::class, 'delete']);
//-----------------------------------


// Frequencies routes --------------------
Route::post('backend/frequencies/insert',[App\Http\Controllers\Admin\FrequenciesController::class, 'insert']);
Route::post('backend/frequencies/update',[App\Http\Controllers\Admin\FrequenciesController::class, 'update']);
Route::post('backend/frequencies/delete',[App\Http\Controllers\Admin\FrequenciesController::class, 'delete']);
//-----------------------------------


// Parameters routes --------------------
Route::post('backend/params/insert',[App\Http\Controllers\Admin\ParamsController::class, 'insert']);
Route::post('backend/params/options/insert',[App\Http\Controllers\Admin\ParamsController::class, 'insertOption']);
Route::post('backend/params/update',[App\Http\Controllers\Admin\ParamsController::class, 'update']);
Route::post('backend/params/delete',[App\Http\Controllers\Admin\ParamsController::class, 'delete']);
Route::post('backend/params/options/delete',[App\Http\Controllers\Admin\ParamsController::class, 'deleteOption']);
//-----------------------------------



Route::post('backend/bookings/alter',[App\Http\Controllers\Admin\BookingsController::class, 'update']);


// Employees routes --------------------
Route::post('backend/employees/insert',[App\Http\Controllers\Admin\EmployeesController::class, 'insert']);
Route::post('backend/employees/update',[App\Http\Controllers\Admin\EmployeesController::class, 'update']);
Route::post('backend/employees/delete',[App\Http\Controllers\Admin\EmployeesController::class, 'delete']);
Route::post('backend/employees/link',[App\Http\Controllers\Admin\EmployeesController::class, 'link']);
Route::post('backend/employees/unlink',[App\Http\Controllers\Admin\EmployeesController::class, 'unlink']);
Route::post('backend/employees/timeslots/add',[App\Http\Controllers\Admin\EmployeesController::class, 'addSlot']);
Route::post('backend/employees/timeslots/delete',[App\Http\Controllers\Admin\EmployeesController::class, 'deleteSlot']);
Route::post('backend/employees/timeslots/update',[App\Http\Controllers\Admin\EmployeesController::class, 'updateSlot']);
//-----------------------------------

});

Route::get('/', function () {
    return view('welcome');
})->name('home');




Route::get('/', function () {
    return view('welcome');
});


