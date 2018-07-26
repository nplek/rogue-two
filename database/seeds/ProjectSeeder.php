<?php

use Illuminate\Database\Seeder;
use App\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'project_code' => '10001',
            'name' => 'Head Office',
            'short_name' => 'HQ',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime("+365 days")),
        ]);
        Project::create([
            'project_code' => '10002',
            'name' => 'Depot',
            'short_name' => 'DEPOT',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime("+365 days")),
        ]);
        Project::create([
            'project_code' => '10003',
            'name' => 'Safty',
            'short_name' => 'SAFTY',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime("+365 days")),
        ]);
        Project::create([
            'project_code' => '10004',
            'name' => 'IT',
            'short_name' => 'IT',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime("+365 days")),
        ]);
        Project::create([
            'project_code' => '11016',
            'name' => 'Amber',
            'short_name' => 'AMBER',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime("+365 days")),
        ]);
        Project::create([
            'project_code' => '11023',
            'name' => 'Niche Mono Borom Sales Office',
            'short_name' => 'MONO',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime("+365 days")),
        ]);
    }
}
