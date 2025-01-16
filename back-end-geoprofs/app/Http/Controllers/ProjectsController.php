<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;

class ProjectsController extends Controller
{
    public function getProjects() { 
        $allProjects = Projects::select('title')->get();

        // Return the result as a JSON response
        return response()->json($allProjects);
    }
}
