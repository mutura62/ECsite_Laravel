<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'キーボード',
                'description' => '高性能キーボード',
                'price' => 10000,
                'stock' => 50,
            ],
            [
                'name' => 'マウス',
                'description' => '高性能マウス',
                'price' => 20000,
                'stock' => 30,
            ],
        ]);
    }
}
