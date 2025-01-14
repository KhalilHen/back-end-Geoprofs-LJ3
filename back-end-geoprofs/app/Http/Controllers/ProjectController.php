<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //
    public function getProjects() {


        $allProjects = Project::select('title')->get();

        // Return the result as a JSON response
        return response()->json($allProjects);
    }
}
