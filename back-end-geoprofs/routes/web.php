<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\hash_password;

Route::post('/login', [log_in_controller::class, 'logIn'])->name('login');

Route::get('/hash/{user:id}', [hash_password::class, 'hashPassword'])->name('hash');//for hashing for testing

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