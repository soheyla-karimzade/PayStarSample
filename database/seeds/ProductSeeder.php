<?php

use Illuminate\Database\Seeder;
use  App\Model\Product;
use Faker\Generator as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,20) as $index) {
            Product::create([
                    'name' => 'name'.$index,
                    'price' =>rand(5000,10000),
                    'description' => 'desc'.$index
                ]);
            }
        }
}
