<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            [
                'engine_model_id' => 1,
                'job_order_id' => 1,
                'job_number' => sprintf("%06d", 1),
                'job_engine_number' => 'RL-14572-39 A',
                'job_customer' => 'PT MPS',
                'job_reference' => 'OHM60294-7-14',
                'job_entry_date' => '2020-02-02',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'engine_model_id' => 2,
                'job_order_id' => 1,
                'job_number' => sprintf("%06d", 2),
                'job_engine_number' => 'RL-14272-39 A',
                'job_customer' => 'Mr. Chang',
                'job_reference' => 'OHM60294-7-14',
                'job_entry_date' => '2020-02-05',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}    