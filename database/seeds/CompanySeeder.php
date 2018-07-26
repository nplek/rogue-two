<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Create company');
        Company::create([
            'name' => 'KTech Construction pcl.',
            'short_name' => 'KCONS',
        ]);
        Company::create([
            'name' => 'KTech Building Contactor',
            'short_name' => 'KBUILD',
        ]);

        Company::create([
            'name' => 'KTech Infrastructure',
            'short_name' => 'KINFA',
        ]);
        Company::create([
            'name' => 'KTech Innovation',
            'short_name' => 'KINNO',
        ]);

    }
}
