<?php

namespace Database\Seeders;

use Hoadev\CoreBlog\Models\Term;
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

        //Default product_category
        $term = Term::create([
            'name' => 'Default Product Category',
            'slug' => 'default-pc',
            'group' => 0
        ]);

        $term->taxonomy()->create([
            'taxonomy' => 'product_category',
            'description' => 'This is default Product Category for CoreShop',
            'count' => 0
        ]);
    }
}
