<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            DepartmentSeeder::class,
            LocationSeeder::class,
            PositionSeeder::class,
            ProjectSeeder::class,
            EmployeeSeeder::class,
            TeamSeeder::class,
            DocNumberSeeder::class,
            ItemUnitSeeder::class,
            ItemSeeder::class,
            WarehouseSeeder::class,
            BusinessPartnerSeeder::class,
            LaratrustSeeder::class,
        ]);
    }
}
