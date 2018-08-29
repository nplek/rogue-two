<?php

use Illuminate\Database\Seeder;
use App\BusinessPartner;

class BusinessPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Create Businesspartner');
        $bps = BusinessPartner::create([
            'card_code' => 'S10002',
            'card_name' => 'บริษัท โอทูอี ซัพพลาย จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10003',
            'card_name' => 'บริษัท ไพร์ม คอนสตรัคทีฟ โปรดักส์ แอนด์ เซอร์วิส จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10004',
            'card_name' => 'บริษัท คอนสโก เอ็นเตอร์ไพรเซส จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10005',
            'card_name' => 'บริษัท จริงใจ พิทักษ์ทรัพย์ เซอร์วิส จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10006',
            'card_name' => 'บริษัท ชวิศา โซน จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10007',
            'card_name' => 'บริษัท ซีอีแอล เอ็นจิเนียส์ จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10008',
            'card_name' => 'บริษัท ดวงพรดี กรุ๊ป (2002) จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10009',
            'card_name' => 'บริษัท ยูพลัส คอนซัลแตนส์ จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
        $bps = BusinessPartner::create([
            'card_code' => 'S10010',
            'card_name' => 'บริษัท รัตพงษ์ คอนสตรัคชั่น จำกัด',
            'card_type' => 'S'
        ]);
        $this->command->info('Create ' . $bps->card_code . ' ' . $bps->card_name);
    }
}
