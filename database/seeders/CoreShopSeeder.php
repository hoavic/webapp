<?php

namespace Database\Seeders;

use Hoadev\CoreShop\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoreShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Stock Default
        $stock = Stock::create([
            'name' => 'Default Stock',
            'status' => 'active',
            'contact_name' => 'Default Contact Name',
            'contact_info' => 'contact_name@gmail.com'
        ]);
        //Address for Default Stock
        $stock->address()->create([
            'detail' => '123 detail',
            'province' => 'Ho Chi Minh City',
            'district' => 'District 7',
            'ward' => 'Tan Ward',
            'email' => 'default.add@gmail.com',
            'phone' => '0909123456'
        ]);
    }
}
