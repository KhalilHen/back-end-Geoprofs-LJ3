<?php

use App\Http\Controllers\department_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\LeaveRequestsController;
use App\Http\Controllers\LeaveRequestsController;

Route::post('/login', [log_in_controller::class, 'logIn'])->name('login');

Route::get('/getUsersDepartment', [department_controller::class, 'getUsers']);

Route::get('/getMangerDepartment', [department_controller::class, 'getManger']);

Route::get('/getUserLeaveSaldo', [LeaveRequestsController::class, 'seeCurrentLeaveSaldo']);

Route::post('/createLeaveRequest', [LeaveRequestsController::class, 'createLeaveRequest']);

Route::view('/', function () {
    return view('login_test');
});

Route::get('/leave-requests', [LeaveRequestsController::class, 'index'])->name('leave.requests');
Route::post('/leave-requests/decline/{id}', [LeaveRequestsController::class, 'declineLeaveRequest'])->name('leave.requests.decline');
