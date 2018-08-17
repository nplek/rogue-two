<?php

use Illuminate\Database\Seeder;
use App\Item;
class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::create([
            'item_code' => 'ITM-0001',
            'name' => 'Item 0001',
            'description' => 'Desc 0001',
            'unit_name1' => 'pcs',
            'unit_qty1' => '1',
            'unit_name2' => 'dozens',
            'unit_qty2' => '12',
        ]);
        $this->command->info('Create Item ' . $item->item_code);
        $item = Item::create([
            'item_code' => 'STL-0002',
            'name' => 'Steel 0002',
            'description' => 'Desc 0002',
            'unit_name1' => 'kg',
            'unit_qty1' => '1',
            'unit_name2' => 'ton',
            'unit_qty2' => '1000',
        ]);
        $this->command->info('Create Item ' . $item->item_code);
        $item = Item::create([
            'item_code' => 'REB-0003',
            'name' => 'Rebel 003',
            'description' => 'Rebel',
            'unit_name1' => 'kg',
            'unit_qty1' => '1',
            'unit_name2' => 'pcs',
            'unit_qty2' => '100',
        ]);
        $this->command->info('Create Item ' . $item->item_code);

        foreach(['ITM-002','ITM-003','ITM-004','ITM-005','ITM-006','ITM-007','ITM-008','ITM-009','ITM-010'] as $it){
            $item = Item::create([
                'item_code' => $it,
                'name' => 'I' . $it,
                'description' => $it,
                'unit_name1' => 'pcs',
                'unit_qty1' => '1',
                'unit_name2' => 'dozen',
                'unit_qty2' => '12',
            ]);
            $this->command->info('Create Item ' . $item->item_code);
        }
        foreach(['ITM-011','ITM-012','ITM-013','ITM-014','ITM-015','ITM-016','ITM-017','ITM-018','ITM-019','ITM-020'] as $it){
            $item = Item::create([
                'item_code' => $it,
                'name' => 'I' . $it,
                'description' => $it,
                'unit_name1' => 'pack',
                'unit_qty1' => '1',
                'unit_name2' => 'pcs',
                'unit_qty2' => '100',
            ]);
            $this->command->info('Create Item ' . $item->item_code);
        }
        foreach(['ITM-021','ITM-022','ITM-023','ITM-024','ITM-025','ITM-026','ITM-027','ITM-028','ITM-029','ITM-030'] as $it){
            $item = Item::create([
                'item_code' => $it,
                'name' => 'I' . $it,
                'description' => $it,
                'unit_name1' => 'kg',
                'unit_qty1' => '1',
                'unit_name2' => 'ton',
                'unit_qty2' => '1000', //1 ton = 1000 kg
            ]);
            $this->command->info('Create Item ' . $item->item_code);
        }
        foreach(['ABC-011','ABC-012','ABC-013','ABC-014','ABC-015','ABC-016','ABC-017','ABC-018','ABC-019','ABC-020'] as $it){
            $item = Item::create([
                'item_code' => $it,
                'name' => 'A' . $it,
                'description' => $it,
                'unit_name1' => 'pack',
                'unit_qty1' => '1',
                'unit_name2' => 'pcs',
                'unit_qty2' => '200',
            ]);
            $this->command->info('Create Item ' . $item->item_code);
        }
        foreach(['BBC-021','BBC-022','BBC-023','BBC-024','BBC-025','BBC-026','BBC-027','BBC-028','BBC-029','BBC-030'] as $it){
            $item = Item::create([
                'item_code' => $it,
                'name' => 'B' . $it,
                'description' => $it,
                'unit_name1' => 'kg',
                'unit_qty1' => '1',
                'unit_name2' => 'ton',
                'unit_qty2' => '1000', //1 ton = 1000 kg
            ]);
            $this->command->info('Create Item ' . $item->item_code);
        }
    }
}
