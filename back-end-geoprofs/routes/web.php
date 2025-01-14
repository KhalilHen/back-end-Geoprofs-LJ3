<?php

use App\Http\Controllers\leave_request_category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log_in_controller;
use App\Http\Controllers\LeaveRequest;
// use App\Http\Controllers\leave_request_category;
use App\Http\Controllers\ProjectController;
use App\Models\LeaveRequestsCategories;

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












//CATEGORY ROUTES

//View Form
Route::get('/create_leave_category_form', function () {
    return view('/create_leave_category_form');
}); 

//Retrieve  Leave Categories
Route::get('/leave-category', [leave_request_category::class, 'displayLeaveCategory'])->name('leave-category');

Route::post('/create_leave_category', action: [leave_request_category::class, 'createLeaveCategory']);






///PROJECT  ROUTES

Route::get('/project', action: function () {
    return view('project');
});
Route::get('/getProjects', action: [ProjectController::class, 'getProjects'])->name('projects');
