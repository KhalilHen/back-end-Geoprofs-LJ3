<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Section;
use App\Models\DepartmentEmployee;
use App\Models\DepartmentSection;
use App\Models\Project;
use App\Models\ProjectEmployee;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //clear data base via "php artisan migrate:fresh" first so ids have no conflicts if you don't want to do this with you current data base change database in the .env file

        $employeesStructure = [
            [
                4,
                5,
                6,
            ],
            [
                5,
                6,
            ],
            [
                5,
                6,
            ],
        ];
        
        $userId = 0;
        $employee = 0;
        $departmentId = 0;
        $sectionMangers = [];
        $sections = [];
        $departmentMangers = [];
        $departments = [];
        $employees = [];
        $departmentEmployees = [];
        $departmentSections = [];

        for($i = 1; $i <= sizeof($employeesStructure); $i++) {
            $userId++;
            array_push($sectionMangers, [
                'id' => $userId,
                'name' => 'TestSectionManger' . $i,
                'email' => 'GeoprofsSectionManger' . $i . '@example.com',
                'password' => 'password' . $userId,
                'role' => 'section-Manager',
            ]);

            array_push($sections, [
                'id' => $i,
                'title' => 'TestSection' . $i,
                'manager_role_id' => $sectionMangers[$i-1]['id'],
                'description' => ' this is TestSection' . $i,
            ]);

            for($j = 1; $j <= sizeof($employeesStructure[$i-1]); $j++) {
                
                $userId++;
                $departmentId++;
                array_push($departmentMangers, [
                    'id' => $userId,
                    'name' => 'TestDepartmentManger' . $departmentId,
                    'email' => 'GeoprofsDepartmentManger' . $departmentId . '@example.com',
                    'password' => 'password' . $userId,
                    'role' => 'manager',
                ]);

                array_push($departments , [
                    'id' => $departmentId,
                    'title' => 'TestDepartment' . $departmentId,
                    'manager_role_id' => $departmentMangers[$departmentId-1]['id'],
                    'description' => ' this is TestDepartment' . $departmentId,
                ]);

                array_push($departmentEmployees, [
                    'department_id' => $departmentId,
                    'user_id' => $departmentMangers[$departmentId-1]['id'],
                ]);

                array_push($departmentSections, [
                    'department_id' => $departmentId,
                    'section_id' => $i,
                ]);

                for($k = 1; $k <= $employeesStructure[$i-1][$j-1]; $k++){
                    $userId++;
                    $employee++;
                    array_push($employees, [
                        'id' => $userId,
                        'name' => 'TestEmployee' . $employee,
                        'email' => 'GeoprofsEmployee' . $employee . '@example.com',
                        'password' => 'password' . $userId,
                        'role' => 'employee',
                    ]);

                    array_push($departmentEmployees, [
                        'department_id' => $departmentId,
                        'user_id' => $employees[$employee-1]['id'],
                    ]);
                }
            }
        }

        $userId++;
        $ceo = [
            'id' => $userId,
            'name' => 'CEO',
            'email' => 'GeoprofsCEO' . $i . '@example.com',
            'password' => 'password' . $userId,
            'role' => 'CEO',
        ];
        
        $projectsSetup = [
            [
                1,
                2,
                5,
                6,
                16,
                17,
            ],
            [
                16,
                17,
                32,
                33,
                34,
            ],
        ];

        $projects = [];
        $projectsEmployees = [];

        for ($i = 1; $i <= sizeof($projectsSetup); $i++){
            array_push($projects , [
                'id' => $i,
                'title' => 'Project' . $i,
                'description' => 'This is project ' . $i,
            ]);

            for ($j = 1; $j <= sizeof($projectsSetup[$i-1]); $j++){
                array_push($projectsEmployees, [
                    'project_id' => $i,
                    'user_id' => $employees[$projectsSetup[$i-1][$j-1]-1]['id'],
                ]);
            }
        }
        

        $users = array_merge($employees, $departmentMangers, $sectionMangers , [$ceo]);

        foreach ($users as $user) {
            User::create($user);
        }

        foreach ($departments as $department) {
            Department::create($department);
        }

        foreach ($departmentEmployees as $employee) {
            DepartmentEmployee::create($employee);
        }

        foreach($sections as $section) {
            Section::create($section);
        }

        foreach($departmentSections as $departmentSection) {
            DepartmentSection::create($departmentSection);
        }

        foreach($projects as $project) {
            Project::create($project);
        }

        foreach($projectsEmployees as $projectEmployee) {
            ProjectEmployee::create($projectEmployee);
        }
    }
}