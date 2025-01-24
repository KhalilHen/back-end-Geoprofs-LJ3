<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\LeaveRequestsController;
use App\Http\Controllers\LeaveRequestsCategoriesController;

Route::post('/login', [log_in_controller::class, 'logIn'])->name('login');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login_test');
});

//**  LEAVE REQUEST ROUTES  **//

//View
//TODO Change this into the front-end view
Route::get('/leaveRequestForm', [LeaveRequestsCategoriesController::class, 'displayLeaveCategory']);


//Leave request
//create Leave request
Route::post(uri: '/leave-request', action: [LeaveRequestsController::class, 'createLeaveRequest']);

