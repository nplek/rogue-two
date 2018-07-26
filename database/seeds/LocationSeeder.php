<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create([
            'name' => 'Head Office',
            'short_name' => 'HQ'
        ]);
        Location::create([
            'name' => 'Head Office/IT',
            'short_name' => 'IT'
        ]);
        Location::create([
            'name' => 'Head Office/Safty',
            'short_name' => 'SAFTY'
        ]);
        Location::create([
            'name' => 'Depot',
            'short_name' => 'DEPOT'
        ]);
        Location::create([
            'name' => 'Site/AAA',
            'short_name' => 'AAA'
        ]);
    }
}
