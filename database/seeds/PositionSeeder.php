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
        $position = Position::create([
            'name' => 'Unassigned',
            'short_name' => 'UNAS',
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'CEO',
            'short_name' => 'CEO',
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'CAD',
            'short_name' => 'CAD',
            'parent_id' => '2'
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'CFO',
            'short_name' => 'CFO',
            'parent_id' => '2'
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'CE',
            'short_name' => 'CE',
            'parent_id' => '2'
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'Project Director',
            'short_name' => 'PD',
            'parent_id' => '6'
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'IT Manager',
            'short_name' => 'IT-MGR',
            'parent_id' => '3'
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'Assisant Manager',
            'short_name' => 'AS-MGR',
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'IT Support',
            'short_name' => 'IT-SPT',
            'parent_id' => '2'
        ]);
        $this->command->info('Create Location ' . $position->name);
        $position = Position::create([
            'name' => 'Staff',
            'short_name' => 'STAFF'
        ]);
        $this->command->info('Create Location ' . $position->name);
    }
}
