<?php

use Illuminate\Database\Seeder;

class ProgressStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('progress_statuses')->insert([
            ['progress_status_name' => 'On Progress',],
            ['progress_status_name' => 'Done',],
            ['progress_status_name' => 'Pending',],
        ]);
    }
}
