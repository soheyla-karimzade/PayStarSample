<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,20) as $index) {
            User::create([
                'name' => 'name'.$index,
                'price' =>rand(1,1000),
                'description' => 'desc'.$index
            ]);
        }
    }

}
