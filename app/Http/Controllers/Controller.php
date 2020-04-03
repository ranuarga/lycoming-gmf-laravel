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
use App\Models\ProgressStatus;
use App\Models\PendingDay;
use DateTime;

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
        // Last Day For In Progress
        $last_day = null;
        $total_pending_day = 0;
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
                if($progress_job->job_sheet->job_sheet_id == 9) {
                    $pending_days = PendingDay::where('progress_job_id' ,$progress_job->progress_job_id)->get();
                    $pending_day_date_start_before = '0000-00-00 00:00:00';
                    $pending_day_date_end_before = '0000-00-00 00:00:00';
                    foreach ($pending_days as $pending_day) {
                        if($pending_day->pending_day_date_end == null) {
                            $last_day = $pending_day->pending_day_date_start;
                        } else {
                            $date_start_before = DateTime::createFromFormat('Y-m-d H:i:s', $pending_day_date_start_before)->format('Y-m-d');
                            $date_end_before = DateTime::createFromFormat('Y-m-d H:i:s', $pending_day_date_end_before)->format('Y-m-d');
                            $date_start = DateTime::createFromFormat('Y-m-d H:i:s', $pending_day->pending_day_date_start)->format('Y-m-d');
                            $date_end = DateTime::createFromFormat('Y-m-d H:i:s', $pending_day->pending_day_date_end)->format('Y-m-d');
                            if($date_start_before != $date_end){
                                $total_pending_day += $this->getWorkingDays(
                                    $pending_day->pending_day_date_start,
                                    $pending_day->pending_day_date_end
                                );
                            }
                            if($date_end_before == $date_start && $date_start_before != $date_start) {
                                $total_pending_day -= 1;
                            }
                            $pending_day_date_end_before = $pending_day->pending_day_date_end;
                        }
                        $pending_day_date_start_before = $pending_day->pending_day_date_start;
                    }
                }
            }
        }
        $completion_percentage =  ($numerator / $denominator) * 100;
        $obj['completion_percentage'] = (int) $completion_percentage;
        // 1 Day Work is 7 Hours and there are 2 engineers
        $obj['days_to_complete'] = ceil($denominator / (7 * 2));

        $obj['days_passed'] = 0;
        $actual_days_passed = 0;
        if($progress_jobs[0])
            if($progress_jobs[0]->progress_job_date_start) {
                if($progress_jobs[count($progress_jobs) - 1]->progress_job_date_completion) {
                    $actual_days_passed = $this->getWorkingDays(
                        $progress_jobs[0]->progress_job_date_start,
                        $progress_jobs[count($progress_jobs) - 1]->progress_job_date_completion
                    );
                } else {
                    if($last_day == null)
                        $last_day = date('Y-m-d H:i:s');
                    $actual_days_passed = $this->getWorkingDays(
                        $progress_jobs[0]->progress_job_date_start,
                        $last_day
                    );
                }
                $obj['days_passed'] = 
                // $last_day
                $actual_days_passed
                - $total_pending_day
                ;
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

    public function getProgressStatuses()
    {
        $progress_statuses = [];
        foreach (ProgressStatus::all() as $progress_status) {
            $progress_statuses[$progress_status->progress_status_id] = $progress_status->progress_status_name;
        }

        return $progress_statuses;
    }

    public function getJobOrders()
    {
        $job_orders = [];
        foreach (JobOrder::all() as $job_order) {
            $job_orders[$job_order->job_order_id] = $job_order->job_order_name;
        }

        return $job_orders;
    }

    public function checkStatusId($request, $progress_job)
    {
        if ($request->progress_status_id) {
            if (!$progress_job->progress_job_date_start) {
                $progress_job->progress_job_date_start = date('Y-m-d H:i:s');
            }
            // 1 is for In Progress, 2 is for Done, 3 is for Pending
            // Client Project Requested Only Pending In Reassembly Counting Day Will Be Freezed
            $pending_day_ongoing = PendingDay::where('progress_job_id' ,$progress_job->progress_job_id)
                ->whereNull('pending_day_date_end')
                ->first();
            $pending_day_done = PendingDay::where('progress_job_id' ,$progress_job->progress_job_id)
                ->whereNotNull('pending_day_date_end')
                ->first();
            if (($request->progress_status_id == 1 || $request->progress_status_id == 2) && $pending_day_ongoing) {
                $pending_day_ongoing->pending_day_date_end = date('Y-m-d H:i:s');
                $pending_day_ongoing->save();
            }
            if ($request->progress_status_id == 1 || $request->progress_status_id == 3) {
                $progress_job->progress_job_date_completion = null;
                if ($progress_job->job_sheet_id == 9 && $request->progress_status_id == 3) {
                    if ($pending_day_done || (!$pending_day_ongoing)) {
                        PendingDay::create([
                            'progress_job_id' => $progress_job->progress_job_id,
                            'pending_day_date_start' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            } else if ($request->progress_status_id == 2) {
                $progress_job->progress_job_date_completion = date('Y-m-d H:i:s');
            } 
        }

        return $progress_job;
    }
}
