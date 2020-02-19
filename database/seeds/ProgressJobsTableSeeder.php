<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgressJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [];
        for ($i=1; $i <= 10; $i++) { 
            array_push($arr, [
                'job_id' => 1,
                'job_sheet_id' => $i,
                'engineer_id' => 1,
                'management_id' => 1,
                'progress_status_id' => 2,
                'progress_job_date_start' => Carbon::now()->format('Y-m-d H:i:s'),
                'progress_job_date_completion' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            array_push($arr, [
                'job_id' => 3,
                'job_sheet_id' => $i,
                'engineer_id' => 1,
                'management_id' => 1,
                'progress_status_id' => 2,
                'progress_job_date_start' => Carbon::now()->format('Y-m-d H:i:s'),
                'progress_job_date_completion' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        for ($i=1; $i <= 10; $i++) { 
            if($i <= 5){
                array_push($arr, [
                    'job_id' => 2,
                    'job_sheet_id' => $i,
                    'engineer_id' => 1,
                    'management_id' => 1,
                    'progress_status_id' => 2,
                    'progress_job_date_start' => Carbon::now()->format('Y-m-d H:i:s'),
                    'progress_job_date_completion' => Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            } else if($i == 6) {
                array_push($arr, [
                    'job_id' => 2,
                    'job_sheet_id' => $i,
                    'engineer_id' => 1,
                    'management_id' => 1,
                    'progress_status_id' => 1,
                    'progress_job_date_start' => Carbon::now()->format('Y-m-d H:i:s'),
                    'progress_job_date_completion' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            } else if($i == 7) {
                array_push($arr, [
                    'job_id' => 2,
                    'job_sheet_id' => $i,
                    'engineer_id' => 1,
                    'management_id' => 1,
                    'progress_status_id' => 3,
                    'progress_job_date_start' => Carbon::now()->format('Y-m-d H:i:s'),
                    'progress_job_date_completion' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            } else {
                array_push($arr, [
                    'job_id' => 2,
                    'job_sheet_id' => $i,
                    'engineer_id' => null,
                    'management_id' => null,
                    'progress_status_id' => null,
                    'progress_job_date_start' => null,
                    'progress_job_date_completion' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }

        DB::table('progress_jobs')->insert($arr);
    }
}
