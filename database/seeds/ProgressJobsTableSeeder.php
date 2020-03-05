<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


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
                'progress_job_date_start' => date('Y-m-d H:i:s'),
                'progress_job_date_completion' => date('Y-m-d H:i:s', strtotime('+1 hours')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            array_push($arr, [
                'job_id' => 3,
                'job_sheet_id' => $i,
                'engineer_id' => 1,
                'management_id' => 1,
                'progress_status_id' => 2,
                'progress_job_date_start' => date('Y-m-d H:i:s'),
                'progress_job_date_completion' => date('Y-m-d H:i:s', strtotime('+2 days')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        for ($i=1; $i <= 10; $i++) { 
            if($i <= 7){
                array_push($arr, [
                    'job_id' => 2,
                    'job_sheet_id' => $i,
                    'engineer_id' => 1,
                    'management_id' => 1,
                    'progress_status_id' => 2,
                    'progress_job_date_start' => date('Y-m-d H:i:s'),
                    'progress_job_date_completion' => date('Y-m-d H:i:s', strtotime('+1 hours')),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else if($i == 8) {
                array_push($arr, [
                    'job_id' => 2,
                    'job_sheet_id' => $i,
                    'engineer_id' => 1,
                    'management_id' => 1,
                    'progress_status_id' => 1,
                    'progress_job_date_start' => date('Y-m-d H:i:s'),
                    'progress_job_date_completion' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else if($i == 9) {
                array_push($arr, [
                    'job_id' => 2,
                    'job_sheet_id' => $i,
                    'engineer_id' => 1,
                    'management_id' => 1,
                    'progress_status_id' => 3,
                    'progress_job_date_start' => date('Y-m-d H:i:s'),
                    'progress_job_date_completion' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
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
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        DB::table('progress_jobs')->insert($arr);
    }
}
