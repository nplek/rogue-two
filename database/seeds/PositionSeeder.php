<?php

use Illuminate\Database\Seeder;
use App\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'Unassigned',
            'short_name' => 'UNAS',
        ]);

        Position::create([
            'name' => 'IT Manager',
            'short_name' => 'IT-MGR'
        ]);

        Position::create([
            'name' => 'IT Support',
            'short_name' => 'IT-SPT',
            'parent_id' => '2'
        ]);

        Position::create([
            'name' => 'Staff',
            'short_name' => 'STAFF'
        ]);
    }
}
