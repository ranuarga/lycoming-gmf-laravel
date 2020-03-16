<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressJob;
use App\Models\ProgressStatus;
use App\Models\Job;
use App\Models\JobSheet;
use App\Models\ProgressAttachment;

class ProgressJobController extends Controller
{
    public function all()
    {
        return response()
            ->json(
                ProgressJob::with('engineer')
                    ->with('job')
                    ->with('job_sheet')
                    ->with('engineer')
                    ->with('management')
                    ->with('progress_status')
                    ->get()
            );
    }

    public function show($id)
    {
        try {
            return response()
                ->json(
                    ProgressJob::with('job')
                        ->with('job_sheet')
                        ->with('engineer')
                        ->with('management')
                        ->with('progress_status')
                        ->findOrFail($id)
                );
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    // Progress Job created when we create Job so probably we not this method in production.
    // But, in development stage I think i need it so I will put it here.
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'job_id' => 'numeric',
                'job_sheet_id' => 'numeric',
                'engineer_id' => 'numeric',
                'management_id' => 'numeric',
                'progress_status_id' => 'numeric',
                'progress_job_date_start' => 'string',
                'progress_job_date_completion' => 'string',
                'progress_job_remark' => 'string',
                'progress_job_note' => 'string',
            ]);
    
            $progress_job = ProgressJob::create([
                'job_id' => $request->job_id,
                'job_sheet_id' => $request->job_sheet_id,
                'engineer_id' => $request->engineer_id,
                'management_id' => $request->management_id,
                'progress_status_id' => $request->progress_status_id,
                'progress_job_date_start' => $request->progress_job_date_start,
                'progress_job_date_completion' => $request->progress_job_date_completion,
                'progress_job_remark' => $request->progress_job_remark,
                'progress_job_note' => $request->progress_job_note,
            ]);

            return response()->json($progress_job, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function edit($id, $pid)
    {
        $progress_job = ProgressJob::findOrFail($pid);

        return view('job.updateProgress', [
            'progress_job' => $progress_job,
            'progress_statuses' => $this->getProgressStatuses()
        ]);
    }

    public function updateWeb($id, Request $request)
    {
        try {
            $progress_job = ProgressJob::findOrFail($id);
            $progress_job->progress_job_remark = $request->progress_job_remark;
            if ($request->progress_status_id) {
                if(!$progress_job->progress_job_date_start) {
                    $progress_job->progress_job_date_start = date('Y-m-d H:i:s');
                }
                // 1 is for In Progress, 2 is for Done, 3 is for Pending
                if ($request->progress_status_id == 1 || $request->progress_status_id == 3) {
                    $progress_job->progress_job_date_completion = null;
                } else if ($request->progress_status_id == 2) {
                    $progress_job->progress_job_date_completion = date('Y-m-d H:i:s');
                } 
            }
            $progress_job->save();

            return redirect()->route('job.progress', ['id' => $progress_job->job_id]);
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }
    
    public function update($id, Request $request)
    {
        try {
            $progress_job = ProgressJob::findOrFail($id);
            $progress_job->update($request->all());

            return response()->json($progress_job, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function updateNote($id, Request $request)
    {
        try {
            $progress_job = ProgressJob::findOrFail($id);
            $progress_job->progress_job_note = $request->progress_job_note;
            $progress_job->management_id = auth()->guard('management')->user()->management_id;
            $progress_job->save();

            return response()->json(array(
                'message' => 'Successfull'
            ), 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function updateStatusAndRemark($id, Request $request)
    {
        try {
            $progress_job = ProgressJob::findOrFail($id);
            $progress_job->progress_status_id = $request->progress_status_id;
            $progress_job->progress_job_remark = $request->progress_job_remark;
            $progress_job->engineer_id = auth()->guard('engineer')->user()->engineer_id;
            if ($request->progress_status_id) {
                if(!$progress_job->progress_job_date_start) {
                    $progress_job->progress_job_date_start = date('Y-m-d H:i:s');
                }
                // 1 is for In Progress, 2 is for Done, 3 is for Pending
                if ($request->progress_status_id == 1 || $request->progress_status_id == 3) {
                    $progress_job->progress_job_date_completion = null;
                } else if ($request->progress_status_id == 2) {
                    $progress_job->progress_job_date_completion = date('Y-m-d H:i:s');
                } 
            }
            $progress_job->save();

            return response()->json(array(
                'message' => 'Successfull'
            ), 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            ProgressJob::findOrFail($id)->delete();

            return response()->json('Progress Job Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function showAttachment($id)
    {
        try {
            return response()->json(array(
                'progress_attachment' => ProgressAttachment::whereProgressJobId($id)->get()
            ));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function progressByJobID($id)
    {        
        $progress_jobs = ProgressJob::where('job_id', $id)->orderBy('progress_job_id', 'asc')->get();
        return view(
            'job.progress',
            [
                'job' => Job::findOrFail($id),
                'progress_jobs' => $progress_jobs,
                'completion_percentage' => $this->completionPercentage($progress_jobs)['completion_percentage'],
                'days_to_complete' => $this->completionPercentage($progress_jobs)['days_to_complete'],
                'days_passed' => $this->completionPercentage($progress_jobs)['days_passed']
            ]
        );
    }

    public function progressDetail($id, $pid)
    {        
        $job = Job::findOrFail($id);
        $progress_job = ProgressJob::findOrFail($pid);
        $progress_jobs = ProgressJob::where('job_id', $id)->orderBy('progress_job_id', 'asc')->get();

        if($job->job_id != $progress_job->job_id) {
            return abort(404);
        }

        return view(
            'job.progress-detail',
            [
                'progress_job' => $progress_job,
                'job' => $job,
                'completion_percentage' => $this->completionPercentage($progress_jobs)['completion_percentage'],
                'days_to_complete' => $this->completionPercentage($progress_jobs)['days_to_complete'],
                'days_passed' => $this->completionPercentage($progress_jobs)['days_passed']
            ]
        );
    }

    public function showProgress($id)
    {
        try {
            $job_progress_list = ProgressJob::where('job_id', $id)->get();
            foreach ($job_progress_list as $list) {
                $job_sheet = JobSheet::find($list->job_sheet_id);
                $progress_status = ProgressStatus::find($list->progress_status_id);
                if ($job_sheet) {                   
                    $list['job_sheet_name'] = $job_sheet->job_sheet_name;
                    // Because there are 2 engineers
                    $list['ideal_hours'] = $job_sheet->job_sheet_man_hours / 2;
                } else {
                    $list['job_sheet_name'] = null;
                    $list['ideal_hours'] = null;
                }

                if ($progress_status) {
                    $list['progress_status_name'] = $progress_status->progress_status_name;
                } else {
                    $list['progress_status_name'] = null;
                }

                // Wrong Algo
                // if ($list->progress_job_date_start) {
                //     $date_start = strtotime($list->progress_job_date_start);
                //     $date_end = strtotime(date('Y-m-d H:i:s'));
                //     if ($list->progress_job_date_completion) {
                //         $date_end = strtotime($list->progress_job_date_completion);
                //     }
                //     $list['actual_hours'] = (int) (abs($date_end - $date_start) / (60 * 60));
                // } else {
                //     $list['actual_hours'] = null;
                // }

                unset($list['job_sheet']);
            }
            return response()->json(array(
                'job_progress_list' => $job_progress_list
            ));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
