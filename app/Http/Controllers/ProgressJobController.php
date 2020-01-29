<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressJob;

class ProgressJobController extends Controller
{
    public function all()
    {
        return response()->json(ProgressJob::all());
    }

    public function show($id)
    {
        try {
            return response()->json(ProgressJob::findOrFail($id));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'job_id' => 'number',
                'job_sheet_id' => 'number',
                'engineer_id' => 'number',
                'management_id' => 'number',
                'progress_status_id' => 'number',
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
