<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendingDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pending_days')->insert([
            'progress_job_id' => 29,
            'pending_day_date_start' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
