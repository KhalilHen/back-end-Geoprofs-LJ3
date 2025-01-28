<?php

use App\Http\Controllers\department_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\LeaveRequestsController;

Route::post('/login', [log_in_controller::class, 'logIn'])->name('login');

Route::get('/getUsersDepartment', [department_controller::class, 'getUsers']);

Route::get('/getMangerDepartment', [department_controller::class, 'getManger']);

Route::get('/getUserLeaveSaldo', [LeaveRequestsController::class, 'seeCurrentLeaveSaldo']);

Route::view('/', function () {
    return view('login_test');
});

//**  LEAVE REQUEST ROUTES  **//

//Leave request
//create Leave request
Route::post(uri: '/leave-request', action: [LeaveRequestsController::class, 'createLeaveRequest']);

