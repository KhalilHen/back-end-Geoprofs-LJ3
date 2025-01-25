<?php

use App\Http\Controllers\department_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\LeaveRequestsController;
Route::post('/login', [log_in_controller::class, 'logIn'])->name('login');

Route::get('/getUsersDepartment', [department_controller::class, 'getUsers']);

Route::get('/getMangerDepartment', [department_controller::class, 'getManger']);

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

Route::view('/', function () {
    return view('login_test');
});




Route::get('/mock-leave-saldo', [LeaveRequestsController::class, 'seeCurrentLeaveSaldo']);
