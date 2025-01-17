<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Section;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //clear data base via "php artisan migrate:fresh" first so ids have no conflicts if you don't want to do this with you current data base change database in the .env file
        $employees = [];
        $userId = 1;

        for($i = 1; $i <= 36; $i++) {
            array_push($employees, [
                'id' => $userId,
                'name' => 'TestUser' . $i,
                'email' => 'GeoprofsTestUser' . $i . '@example.com',
                'password' => 'password' . $userId,
                'role' => 'employee',
            ]);
            $userId++;
        }

        $departmentMangers = [];
        $departmentCount = 7;

        for($i = 1; $i <= $departmentCount; $i++) {
            array_push($departmentMangers, [
                'id' => $userId,
                'name' => 'TestDepartmentManger' . $i,
                'email' => 'GeoprofsDepartmentManger' . $i . '@example.com',
                'password' => 'password' . $userId,
                'role' => 'manager',
            ]);
            $userId++;
        }

        $departments = [];

        for($i = 1; $i <= $departmentCount; $i++) {
            array_push($departments, [
                'id' => $i,
                'title' => 'TestDepartment' . $i,
                'manager_role_id' => $departmentMangers[$i-1]['id'],
                'description' => ' this is TestDepartment' . $i,
            ]);
        }

        $sectionMangers = [];
        $sectionCount = 3;

        for($i = 1; $i <= $sectionCount; $i++) {
            array_push($sectionMangers, [
                'id' => $userId,
                'name' => 'TestSectionManger' . $i,
                'email' => 'GeoprofsSectionManger' . $i . '@example.com',
                'password' => 'password' . $userId,
                'role' => 'section-Manager',
            ]);
            $userId++;
        }

        $sections = [];

        for($i = 1; $i <= $sectionCount; $i++) {
            array_push($sections, [
                'id' => $i,
                'title' => 'TestSection' . $i,
                'manager_role_id' => $sectionMangers[$i-1]['id'],
                'description' => ' this is TestSection' . $i,
            ]);
        }

        $ceo = [
            'id' => $userId,
            'name' => 'CEO',
            'email' => 'GeoprofsCEO' . $i . '@example.com',
            'password' => 'password' . $userId,
            'role' => 'CEO',
        ];
        $userId++;

        $users = array_merge($employees, $departmentMangers, $sectionMangers , [$ceo]);

        foreach ($users as $user) {
            User::create($user);
        }

        foreach ($departments as $department) {
            Department::create($department);
        }

        foreach($sections as $section) {
            Section::create($section);
        }
    }
}