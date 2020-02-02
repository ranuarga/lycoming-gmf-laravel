<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSheetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_sheets')->insert([
            ['job_sheet_name' => '',],
        ]);
    }
}
