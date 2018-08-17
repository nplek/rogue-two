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
            'short_name' => 'PR-NUM',
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
            'short_name' => 'SR-NUM',
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
            'name' => 'Goods Receipts Form',
            'short_name' => 'GR-NUM',
            'prefix' => 'GR-',
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
            'short_name' => 'GRR-NUM',
            'prefix' => 'GRR-',
            'suffix' => '',
            'digit_num' => 5,
            'delimiter' => '-',
            'doc_format' => '{DEP}-{YY}{DELI}{NN}',
            'doc_year' => date('Y'),
            'doc_month' => date('m'),
            'year_reset_num' => 'Y',
            'month_reset_num' => 'N'
        ]);
    }
}
