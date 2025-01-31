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
use App\Models\MangerSection;
use App\Models\LeaveRequestsCategories;
use App\Models\LeaveRequests;

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
        $mangerSections = [];

        for($i = 1; $i <= sizeof($employeesStructure); $i++) {
            $userId++;
            array_push($sectionMangers, [
                'id' => $userId,
                'name' => 'TestSectionManger' . $i,
                'email' => 'GeoprofsSectionManger' . $i . '@example.com',
                'password' => 'password' . $userId,
                'role' => 'section-Manager',
                'leave_days' => 30,
            ]);

            array_push($mangerSections, [
                'manager_role_id_user' => $userId,
                'section_id' => $i,
            ]);

            array_push($sections, [
                'id' => $i,
                'title' => 'TestSection' . $i,                
                'description' => ' this is TestSection' . $i,
            ]);

            for($j = 1; $j <= sizeof($employeesStructure[$i-1]); $j++) {
                
                $userId++;
                $departmentId++;
                array_push($departmentMangers, [
                    'id' => $userId,
                    'name' => 'TestDepartmentManger' . $departmentId,
                    'email' => 'GeoprofsDepartmentManger' . $departmentId . '@example.com',
                    'department_id' => $departmentId,
                    'password' => 'password' . $userId,
                    'role' => 'manager',
                    'leave_days' => 30,
                ]);

                array_push($departments , [
                    'id' => $departmentId,
                    'title' => 'TestDepartment' . $departmentId,
                    'description' => ' this is TestDepartment' . $departmentId,
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
                        'department_id' => $departmentId,
                        'leave_days' => 30,
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

        $leave_requests_categories = [
            [
                'title' => 'free day',
                'id' =>1,
            ]
        ];

        $leave_request_users = [
            3,
            4,
            5,
            8,
            9,
            1,
            2,
        ];

        $leave_requests = [];

        for($i = 1; $i <= sizeof($leave_request_users); $i++){
            array_push($leave_requests , [
                'id' => $i,
                'description' => 'Leave request from user ' . $leave_request_users[$i-1],
                'employee_id' => $leave_request_users[$i-1],
                'leave_requests_category_id' => 1,
                'leave_status' => 0,
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-02',
                'leave_days' => 2,
                'is_paid' => 1,
            ]);
        }

        foreach($sections as $section) {
            Section::create($section);
        }

        foreach ($departments as $department) {
            Department::create($department);
        }
        foreach ($users as $user) {
            User::create($user);
        }

        foreach($mangerSections as $mangerSection) {
            MangerSection::create($mangerSection);
        }

        foreach($leave_requests_categories as $leave_requests_categorie) {
            LeaveRequestsCategories::create($leave_requests_categorie);
        }

        foreach($leave_requests as $leave_request) {
            LeaveRequests::create($leave_request);
        }
    }
}