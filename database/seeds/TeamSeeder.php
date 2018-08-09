<?php

use Illuminate\Database\Seeder;
use App\Team;
class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Create Team Admin');
        Team::create([
            'name' => 'ADMIN',
            'display_name' => 'Team Admin',
            'description' => 'Team Admin',
        ]);
        $this->command->info('Create Team Head Office');
        Team::create([
            'name' => 'HQ',
            'display_name' => 'Team Head Office',
            'description' => 'Team Head Office',
        ]);
        $this->command->info('Create Team Constructions');
        Team::create([
            'name' => 'CONS',
            'display_name' => 'Team Constructions',
            'description' => 'Team Constructions',
        ]);
    }
}
