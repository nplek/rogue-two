<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Unassigned',
            'short_name' => 'UNAS',
            'company_id' => 1,
        ]);

        Department::create([
            'name' => 'IT Department',
            'short_name' => 'IT',
            'company_id' => 1,
        ]);

        Department::create([
            'name' => 'Site',
            'short_name' => 'Site',
            'company_id' => 2,
        ]);

    }
}
