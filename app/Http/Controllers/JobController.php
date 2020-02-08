<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineModel;
use App\Models\Job;
use App\Models\JobOrder;
use App\Models\JobSheet;
use App\Models\ProgressJob;

class JobController extends Controller
{
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
    
    public function all()
    {
        return response()
            ->json(
                Job::with('engine_model')
                    ->with('job_order')
                    ->get()
            );
    }

    public function index()
    {        
        return view('job.index', ['jobs' => Job::all()]);
    }

    public function progress($id)
    {        
        return view(
            'job.progress',
            [
                'progress_jobs' => ProgressJob::where('job_id', $id)
                    ->with('job')
                    ->with('job_sheet')
                    ->with('engineer')
                    ->with('management')
                    ->with('progress_status')
                    ->get()
            ]
        );
    }

    public function progressDetail($pid)
    {        
        return view(
            'job.progress-detail',
            [
                'jobs' => ProgressJob::with('job')
                            ->with('job_sheet')
                            ->with('engineer')
                            ->with('management')
                            ->with('progress_status')
                            ->findOrFail($pid)
            ]
        );
    }

    public function done()
    {
        // $jobs = Job::with('engine_model')
        //             ->with('job_order')
        //             ->get();
        $jobs = Job::all();
        $jobsDone = [];
        foreach ($jobs as $job) {
            $allDone = true;
            $progress_jobs = ProgressJob::where('job_id', $job->job_id)->get();
            foreach ($progress_jobs as $progress_job) {
                if ($progress_job->progress_status) {
                    if ($progress_job->progress_status->progress_status_name != 'Done') {
                        $allDone = false;
                        break;
                    }
                } else {
                    $allDone = false;
                    break;
                }
            }
            
            if($allDone == true) {
                $job['engine_model_name'] = EngineModel::where('engine_model_id', $job->engine_model_id)
                    ->first()
                    ->engine_model_name;
                $job['job_order_name'] = JobOrder::where('job_order_id', $job->job_order_id)
                    ->first()
                    ->job_order_name;
                array_push($jobsDone, $job);
            }
        }

        return $jobsDone;
    }
    
    public function allDoneWeb()
    {
        return view('job.index', ['jobs' => $this->done(), 'title' => 'Done']);
    }

    public function allDone()
    {        
        return response()->json(array(
            'job_done' => $this->done()
        ));
    }

    public function onProgress()
    {
        $jobs = Job::with('engine_model')
                    ->with('job_order')
                    ->get();
        $jobsProgress = [];
        foreach ($jobs as $job) {
            $allProgress = false;
            $progress_jobs = ProgressJob::where('job_id', $job->job_id)->get();
            foreach ($progress_jobs as $progress_job) {
                if ($progress_job->progress_status) {
                    if ($progress_job->progress_status->progress_status_name != 'Done') {
                        $allProgress = true;
                        break;
                    }
                } else {
                    $allProgress = true;
                }
            }
            
            if($allProgress == true) {
                $job['engine_model_name'] = EngineModel::where('engine_model_id', $job->engine_model_id)
                    ->first()
                    ->engine_model_name;
                $job['job_order_name'] = JobOrder::where('job_order_id', $job->job_order_id)
                    ->first()
                    ->job_order_name;
                array_push($jobsProgress, $job);
            }
        }

        return $jobsProgress;
    }
    
    public function allProgressWeb()
    {
        return view('job.index', ['jobs' => $this->onProgress(), 'title' => 'On Progress']);
    }

    public function allProgress()
    {
        return response()->json(array(
            'job_progress' => $this->onProgress()
        ));
    }

    public function show($id)
    {
        try {
            return response()
                ->json(
                    Job::with('progress_job')
                        ->with('progress_job.progress_status')
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
                'job_engine_number' => 'string|max:255',
                'job_customer' => 'string|max:255',
                'job_reference' => 'string|max:255',
                'job_entry_date' => 'string'
            ]);

            $job = Job::create([
                'engine_model_id' => $request->engine_model_id,
                'job_order_id' => $request->job_order_id,
                'job_engine_number' => $request->job_engine_number,
                'job_customer' => $request->job_customer,
                'job_reference' => $request->job_reference,
                'job_entry_date' => $request->job_entry_date
            ]);

            $job->job_number = sprintf("%06d", $job->job_id);
            $job->save();

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
    
    public function storeWeb(Request $request)
    {
        try {            
            $job = Job::create([
                'engine_model_id' => $request->engine_model_id,
                'job_order_id' => $request->job_order_id,
                'job_engine_number' => $request->job_engine_number,
                'job_customer' => $request->job_customer,
                'job_reference' => $request->job_reference,
                'job_entry_date' => $request->job_entry_date
            ]);

            $job->job_number = sprintf("%06d", $job->job_id);
            $job->save();

            $job_sheets = JobSheet::all();
            foreach ($job_sheets as $job_sheet) {
                ProgressJob::create([
                    'job_id' => $job->job_id,
                    'job_sheet_id' => $job_sheet->job_sheet_id,
                ]);
            }

            return redirect()->route('job');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function create()
    {
        return view('job.createOrUpdate', [
            'engine_models' => $this->getEngineModels(),
            'job_orders' => $this->getJobOrders(),
        ]);
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);

        return view('job.createOrUpdate', [
            'job' => $job,
            'engine_models' => $this->getEngineModels(),
            'job_orders' => $this->getJobOrders(),
        ]);
    }

    public function update($id, Request $request)
    {
        try {
            $job = Job::findOrFail($id);
            $job->engine_model_id = $request->engine_model_id;
            $job->job_order_id = $request->job_order_id;
            $job->job_engine_number = $request->job_engine_number;
            $job->job_customer = $request->job_customer;
            $job->job_reference = $request->job_reference;
            $job->job_entry_date = $request->job_entry_date;
            $job->save();

            return response()->json($job, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function updateWeb($id, Request $request)
    {
        try {
            $job = Job::findOrFail($id);
            $job->engine_model_id = $request->engine_model_id;
            $job->job_order_id = $request->job_order_id;
            $job->job_engine_number = $request->job_engine_number;
            $job->job_customer = $request->job_customer;
            $job->job_reference = $request->job_reference;
            $job->job_entry_date = $request->job_entry_date;
            $job->save();


            return redirect()->route('job');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
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

    public function destroy($id)
    {
        Job::findOrFail($id)->delete();

        return redirect()->route('job');
    }
}
