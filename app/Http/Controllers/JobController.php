<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobSheet;
use App\Models\ProgressJob;

class JobController extends Controller
{
    public function all()
    {
        return response()
            ->json(
                Job::with('engine_model')
                    ->with('job_order')
                    ->get()
            );
    }

    public function show($id)
    {
        try {
            return response()
                ->json(
                    Job::with('progress_job')
                        ->with('engine_model')
                        ->with('job_order')
                        ->findOrFail($id)
                );
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
                'engine_model_id' => 'numeric',
                'job_order_id' => 'numeric',
                'job_number' => 'string|max:255',
                'job_engine_number' => 'string|max:255',
                'job_customer' => 'string|max:255',
                'job_reference' => 'string|max:255',
                'job_entry_date' => 'string'
            ]);

            $job = Job::create([
                'engine_model_id' => $request->engine_model_id,
                'job_order_id' => $request->job_order_id,
                'job_number' => $request->job_number,
                'job_engine_number' => $request->job_engine_number,
                'job_customer' => $request->job_customer,
                'job_reference' => $request->job_reference,
                'job_entry_date' => $request->job_entry_date
            ]);

            $job_sheets = JobSheet::all();
            foreach ($job_sheets as $job_sheet) {
                ProgressJob::create([
                    'job_id' => $job->job_id,
                    'job_sheet_id' => $job_sheet->job_sheet_id,
                ]);
            }

            return response()->json($job, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $job = Job::findOrFail($id);
            $job->update($request->all());

            return response()->json($job, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Job::findOrFail($id)->delete();

            return response()->json('Job Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
