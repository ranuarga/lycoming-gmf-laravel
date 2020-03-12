<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Date;
use App\Models\EngineModel;
use App\Models\JobOrder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function completionPercentage($progress_jobs)
    {
        // $progress_jobs must be sorted first by id or created_at
        // Pembilang in English
        $numerator = 0;
        // Penyebut in English
        $denominator = 0;
        foreach ($progress_jobs as $progress_job) {
            if($progress_job->job_sheet) {
                if($progress_job->job_sheet->job_sheet_man_hours) {
                    $denominator += (float) $progress_job->job_sheet->job_sheet_man_hours;
                    if($progress_job->progress_status) {
                        if($progress_job->progress_status->progress_status_name == 'Done') {
                            $numerator += (float) $progress_job->job_sheet->job_sheet_man_hours;
                        }
                    }
                }
            }
        }
        $completion_percentage =  ($numerator / $denominator) * 100;
        $obj['completion_percentage'] = (int) $completion_percentage;
        // 1 Day Work is 7 Hours and there are 2 engineers
        $obj['days_to_complete'] = ceil($denominator / (7 * 2));

        $obj['days_passed'] = 0;
        if($progress_jobs[0])
            if($progress_jobs[0]->progress_job_date_start) {
                if($progress_jobs[count($progress_jobs) - 1]->progress_job_date_completion)
                    $obj['days_passed'] = $this->getWorkingDays(
                        $progress_jobs[0]->progress_job_date_start,
                        $progress_jobs[count($progress_jobs) - 1]->progress_job_date_completion
                    );
                else
                    $obj['days_passed'] = $this->getWorkingDays(
                        $progress_jobs[0]->progress_job_date_start,
                        date('Y-m-d H:i:s')
                    );
            }

        return $obj;
    }

    public function getWorkingDays($startDate, $endDate)
    {
        // Management only request Eid Fitri & X-Mas Holiday, so i did it like this
        // Actually it will be easier if all holidays included
        // Just Requested it from Google Calendar API or something similar
        
        // getWorkingDays based on this
        // https://stackoverflow.com/questions/336127/calculate-business-days
        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);
        
        // Eid Fitri
        // https://github.com/GeniusTS/hijri-dates
        $hijriYear = (int) Date::now()->format('o');

        $oneSyawals = [];
        for($i = -1 ; $i < 3 ; $i++) {
            for($j = -1 ; $j < 2 ; $j++) {
                array_push($oneSyawals, date('Y-m-d', strtotime(Hijri::convertToGregorian(1 + $i, 10, $hijriYear + $j))));
            }
        }
        $christmas = [
            date('Y') . '-12-25',
            date('Y', strtotime('-1 years')) . '-12-25',
            date('Y', strtotime('+1 years')) . '-12-25',
        ];
        $holidays = array_merge($oneSyawals, $christmas);

        $days = ($endDate - $startDate) / 86400 + 1;

        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        } else {
            if ($the_first_day_of_week == 7) {
                $no_remaining_days--;
                if ($the_last_day_of_week == 6) {                    
                    $no_remaining_days--;
                }
            } else {
                $no_remaining_days -= 2;
            }
        }

        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0 ) {
            $workingDays += $no_remaining_days;
        }

        foreach($holidays as $holiday){
            $time_stamp=strtotime($holiday);
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
                $workingDays--;
        }
        
        return (int) $workingDays;
    }

    public function getEngineModels()
    {
        $engine_models = [];
        foreach (EngineModel::all() as $engine_model) {
            $engine_models[$engine_model->engine_model_id] = $engine_model->engine_model_name;
        }
        
        return $engine_models;
    }

    public function getJobOrders()
    {
        $job_orders = [];
        foreach (JobOrder::all() as $job_order) {
            $job_orders[$job_order->job_order_id] = $job_order->job_order_name;
        }

        return $job_orders;
    }
}
