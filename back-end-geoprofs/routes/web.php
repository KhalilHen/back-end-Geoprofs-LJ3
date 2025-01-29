<?php

use App\Http\Controllers\department_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\LeaveRequestsController;

Route::post('/login', [log_in_controller::class, 'logIn'])->name('login');

Route::get('/getUsersDepartment', [department_controller::class, 'getUsers']);

Route::get('/getMangerDepartment', [department_controller::class, 'getManger']);

Route::get('/getUserLeaveSaldo', [LeaveRequestsController::class, 'seeCurrentLeaveSaldo']);

Route::post('/createLeaveRequest', [LeaveRequestsController::class, 'createLeaveRequest']);

Route::post('/leave-requests/decline/{id}', [LeaveRequestsController::class, 'declineLeaveRequest']);

Route::post('/approveOrDeclineLeaveRequest', [LeaveRequestsController::class, 'approveOrDeclineLeaveRequest']);

Route::get('/getLeaveRequests', [LeaveRequestsController::class, 'getLeaveRequests']);

Route::get('/getLeaveRequestData', [LeaveRequestsController::class, 'getLeaveRequestData']);

Route::view('/', function () {
    return view('login_test');
});