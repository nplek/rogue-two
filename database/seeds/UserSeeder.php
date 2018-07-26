<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@me.com',
            'password' => '123456',
            'active' => "A",
            'employee_id' => '5910082',
            'first_name' => 'Administrator',
            'last_name' => 'System',
            'mobile' => '1234567890',
            'phone' => '4321',
        ]);
    }
}
