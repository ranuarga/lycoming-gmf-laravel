<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineModel;
use App\Models\Job;
use App\Models\JobOrder;
use App\Models\JobSheet;
use App\Models\JobSheetOrder;
use App\Models\ProgressJob;
use App\Models\ProgressStatus;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JobsExport;

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

    public function index()
    {        
        return view('job.index', ['jobs' => Job::all()]);
    }

    public function done()
    {
        $jobs = Job::all();
        $jobsDone = [];
        foreach ($jobs as $job) {
            $allDone = true;
            $progress_jobs = ProgressJob::where('job_id', $job->job_id)->orderBy('progress_job_id', 'asc')->get();
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
                $engine_model = EngineModel::find($job->engine_model_id);
                $job_order = JobOrder::find($job->job_order_id);
                if ($engine_model) {
                    $job['engine_model_name'] = $engine_model->engine_model_name;
                    $job['engine_model_reference'] = $engine_model->engine_model_reference;
                } else {
                    $job['engine_model_name'] = null;
                    $job['engine_model_reference'] = null;
                }
                if ($job_order) {
                    $job['job_order_name'] = $job_order->job_order_name;
                } else {
                    $job['job_order_name'] = null;
                }
                $job['completion_percentage'] = $this->completionPercentage($progress_jobs)['completion_percentage'];
                $job['days_to_complete'] = $this->completionPercentage($progress_jobs)['days_to_complete'];
                $job['days_passed'] = $this->completionPercentage($progress_jobs)['days_passed'];
                unset($job['progress_job']);
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

    public function inProgress()
    {
        $jobs = Job::all();
        $jobsProgress = [];
        foreach ($jobs as $job) {
            $allProgress = false;
            $progress_jobs = ProgressJob::where('job_id', $job->job_id)->orderBy('progress_job_id', 'asc')->get();
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
                $engine_model = EngineModel::find($job->engine_model_id);
                $job_order = JobOrder::find($job->job_order_id);
                if ($engine_model) {
                    $job['engine_model_name'] = $engine_model->engine_model_name;
                    $job['engine_model_refernce'] = $engine_model->engine_model_reference;
                } else {
                    $job['engine_model_name'] = null;
                    $job['engine_model_reference'] = null;
                }
                if ($job_order) {
                    $job['job_order_name'] = $job_order->job_order_name;
                } else {
                    $job['job_order_name'] = null;
                }
                $job['completion_percentage'] = $this->completionPercentage($progress_jobs)['completion_percentage'];
                $job['days_to_complete'] = $this->completionPercentage($progress_jobs)['days_to_complete'];
                $job['days_passed'] = $this->completionPercentage($progress_jobs)['days_passed'];
                unset($job['progress_job']);
                array_push($jobsProgress, $job);
            }
        }

        return $jobsProgress;
    }
    
    public function allProgressWeb()
    {
        return view('job.index', ['jobs' => $this->inProgress(), 'title' => 'In Progress']);
    }

    public function allProgress()
    {
        return response()->json(array(
            'job_progress' => $this->inProgress()
        ));
    }

    public function show($id)
    {
        try {
            $job = Job::findOrFail($id);
            $engine_model = EngineModel::find($job->engine_model_id);
            $job_order = JobOrder::find($job->job_order_id);
            $progress_jobs = ProgressJob::where('job_id', $id)->get();
            if ($engine_model) {
                $job['engine_model_name'] = $engine_model->engine_model_name;
                $job['engine_model_reference'] = $engine_model->engine_model_reference;
            } else {
                $job['engine_model_name'] = null;
                $job['engine_model_reference'] = null;
            }
            if ($job_order) {
                $job['job_order_name'] = $job_order->job_order_name;
            } else {
                $job['job_order_name'] = null;
            }
            $job['completion_percentage'] = $this->completionPercentage($progress_jobs)['completion_percentage'];
            $job['days_to_complete'] = $this->completionPercentage($progress_jobs)['days_to_complete'];
            $job['days_passed'] = $this->completionPercentage($progress_jobs)['days_passed'];

            return response()->json(array(
                'job' => $job
            ));
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
                'job_number' => 'string|unique:jobs',
                'job_engine_number' => 'string|max:255',
                'job_customer' => 'string|max:255',
                'job_entry_date' => 'string',
                'job_wo_file' => 'file'
            ]);

            $job = Job::create([
                'engine_model_id' => $request->engine_model_id,
                'job_order_id' => $request->job_order_id,
                'job_track_number' => strtolower(Str::random(12)),
                'job_engine_number' => $request->job_engine_number,
                'job_number' => $request->job_number,
                'job_customer' => $request->job_customer,
                'job_entry_date' => $request->job_entry_date
            ]);

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  $file_name  . '-' . Str::random(2);

                \Cloudder::upload($file, $public_id);
                $result = \Cloudder::getResult();
                
                $job->job_wo_public_id = $result['public_id'];
                $job->job_wo_secure_url = $result['secure_url'];
            }
            $job->save();

            $job_sheets = JobSheetOrder::whereJobOrderId($job->job_order_id)->orderBy('job_sheet_order_id', 'asc')->get();
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
                'job_track_number' => strtolower(Str::random(12)),
                'job_engine_number' => $request->job_engine_number,
                'job_number' => $request->job_number,
                'job_customer' => $request->job_customer,
                'job_entry_date' => $request->job_entry_date
            ]);

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  $file_name  . '-' . Str::random(2);

                \Cloudder::upload($file, $public_id);
                $result = \Cloudder::getResult();
                
                $job->job_wo_public_id = $result['public_id'];
                $job->job_wo_secure_url = $result['secure_url'];
            }
            $job->save();

            $job_sheets = JobSheetOrder::whereJobOrderId($job->job_order_id)->orderBy('job_sheet_order_id', 'asc')->get();
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
            if($request->engine_model_id)
                $job->engine_model_id = $request->engine_model_id;
            if($request->job_engine_number)
                $job->job_engine_number = $request->job_engine_number;
            if($request->job_number)
                $job->job_number = $request->job_number;
            if($request->job_customer)
                $job->job_customer = $request->job_customer;
            if($request->job_entry_date)
                $job->job_entry_date = $request->job_entry_date;

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                if($job->job_wo_public_id) {
                    \Cloudder::delete($job->job_wo_public_id);
                }

                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  $file_name  . '-' . Str::random(2);

                \Cloudder::upload($file, $public_id);
                $result = \Cloudder::getResult();
                
                $job->job_wo_public_id = $result['public_id'];
                $job->job_wo_secure_url = $result['secure_url'];
            }

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
            $job->job_engine_number = $request->job_engine_number;
            $job->job_number = $request->job_number;
            $job->job_customer = $request->job_customer;
            if($request->job_entry_date)
                $job->job_entry_date = $request->job_entry_date;

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                if($job->job_wo_public_id) {
                    \Cloudder::delete($job->job_wo_public_id);
                }

                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  $file_name  . '-' . Str::random(2);

                \Cloudder::upload($file, $public_id);
                $result = \Cloudder::getResult();
                
                $job->job_wo_public_id = $result['public_id'];
                $job->job_wo_secure_url = $result['secure_url'];
            }

            $job->save();

            return redirect()->route('job');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $job = Job::findOrFail($id);
            $job_wo_public_id = $job->job_wo_public_id;

            if($job_wo_public_id)
                \Cloudder::delete($job_wo_public_id);

            $job->delete();

            return response()->json('Job Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
            $job_wo_public_id = $job->job_wo_public_id;

            if($job_wo_public_id)
                \Cloudder::delete($job_wo_public_id);

            $job->delete();

        return redirect()->route('job');
    }

    public function export()
    {
        return (new JobsExport)->download('jobs.xlsx');
    }
}