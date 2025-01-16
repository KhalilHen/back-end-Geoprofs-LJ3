<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\LeaveRequestsController;

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






Route::get('/past-30-days', function () {
    return view('past30_days_check');
});

Route::get('/test', [LeaveRequestsController::class, 'past30Days']);