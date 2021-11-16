<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'History of Bangladesh',
                'written_by' => 'AZM Zaman',
                'delivery_fee' => 15,
                'borrow_fee' => 40,
                'created_at' => now(),
                'updated_at' => now()

            ]
        ]);
    }
}
