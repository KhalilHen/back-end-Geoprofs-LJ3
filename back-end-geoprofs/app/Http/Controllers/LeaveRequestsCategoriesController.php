<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequestsCategories;
use App\Models\LeaveCategory; // Ensure the model is imported

class LeaveRequestsCategoriesController extends Controller
{
  //


  public function displayLeaveCategory()
  {
    $categories = LeaveRequestsCategories::all(); // Fetch all categories
    return view('create_leave_request_form', compact('categories'));
  }


}
