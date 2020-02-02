<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_orders')->insert([
            ['job_order_name' => 'Overhaul',],
            ['job_order_name' => 'Repair',]
        ]);
    }
}
