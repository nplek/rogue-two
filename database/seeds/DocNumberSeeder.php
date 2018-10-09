<?php

use Illuminate\Database\Seeder;
use App\DocNumber;

class DocNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doc = DocNumber::create([
            'name' => 'PurchaseRequest Form',
            'short_name' => 'PRF-NUM',
            'prefix' => 'PR-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Subcontact Form',
            'short_name' => 'SRF-NUM',
            'prefix' => 'SR-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Goods Receipts PO Form',
            'short_name' => 'GPP-NUM',
            'prefix' => 'GPP-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Goods Receipts Form',
            'short_name' => 'GRP-NUM',
            'prefix' => 'GRP-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Goods Return Form',
            'short_name' => 'GRT-NUM',
            'prefix' => 'GRT-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Goods Issue',
            'short_name' => 'GIS-NUM',
            'prefix' => 'GIS-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Return item Form',
            'short_name' => 'RIM-NUM',
            'prefix' => 'RIM-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Transfer item Form',
            'short_name' => 'TFI-NUM',
            'prefix' => 'TFI-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Transfer item receipt',
            'short_name' => 'TFR-NUM',
            'prefix' => 'TFR-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
        $doc = DocNumber::create([
            'name' => 'Adjust item Form',
            'short_name' => 'IAD-NUM',
            'prefix' => 'IAD-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
        $this->command->info('Create doc ' . $doc->name);
    }
}
