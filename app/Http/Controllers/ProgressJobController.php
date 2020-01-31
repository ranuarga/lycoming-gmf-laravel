<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressJob;

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
            $progress_job->save();

            return response()->json($progress_job, 200);
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
            if ($request->progress_status_id) {
                // 1 is for On Progress, 2 is for Done
                if ($request->progress_status_id == 1) {
                    $progress_job->progress_job_date_start = date('Y-m-d');
                } else if ($request->progress_status_id == 2) {
                    $progress_job->progress_job_date_completion = date('Y-m-d');
                }
            }
            $progress_job->save();

            return response()->json($progress_job, 200);
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
}
