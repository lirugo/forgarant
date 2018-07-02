<?php

use Carbon\Carbon;
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
            'id' => '1',
            'name' => 'School uniform',
            'description' => 'The most convenient and high quality school uniform',
            'currency' => 'RUB',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ] );

        DB::table('product_prices')->insert([
            'product_id' => '1',
            'price' => '8000.00',
            'date_start' => '2016-01-01',
            'date_end' => NULL,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ] );

        DB::table('product_prices')->insert([
            'product_id' => '1',
            'price' => '12000.00',
            'date_start' => '2016-05-01',
            'date_end' => '2017-01-01',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ] );

        DB::table('product_prices')->insert([
            'product_id' => '1',
            'price' => '15000.00',
            'date_start' => '2016-07-01',
            'date_end' => '2016-09-10',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ] );

        DB::table('product_prices')->insert([
            'product_id' => '1',
            'price' => '20000.00',
            'date_start' => '2017-06-01',
            'date_end' => '2017-10-20',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ] );

        DB::table('product_prices')->insert([
            'product_id' => '1',
            'price' => '5000.00',
            'date_start' => '2017-12-15',
            'date_end' => '2017-12-31',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ] );
    }
}
