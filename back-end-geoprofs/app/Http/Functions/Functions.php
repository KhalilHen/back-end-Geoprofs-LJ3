<?php

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DepartmentEmployee;
use App\Models\MangerSection;
use App\Models\Section;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Functions {
    public function sectionMangerCheck($userId , $departmentId)
    {
        $mangerSection = MangerSection::where('manager_role_id_user' , $userId)->first();
        $department = Department::where('id' , $departmentId)->first();
        if($mangerSection?->section_id == $department?->section_id){
            return true;
        }
        return false;
    }
}

?>
