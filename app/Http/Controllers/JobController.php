<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineModel;
use App\Models\Job;
use App\Models\JobOrder;
use App\Models\JobSheet;
use App\Models\ProgressJob;
use App\Models\ProgressStatus;

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

    public function completionPercentage($progress_jobs)
    {
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

        return ($numerator / $denominator) * 100;
    }
    
    public function progress($id)
    {        
        $progress_jobs = ProgressJob::where('job_id', $id)->orderBy('progress_job_id', 'asc')->get();
        return view(
            'job.progress',
            [
                'job' => Job::findOrFail($id),
                'progress_jobs' => $progress_jobs,
                'completion_percentage' => $this->completionPercentage($progress_jobs)
            ]
        );
    }

    public function progressDetail($id, $pid)
    {        
        $progress_job = ProgressJob::findOrFail($pid);
        $job = Job::findOrFail($id);

        if($job->job_id != $progress_job->job_id) {
            return abort(404);
        }

        return view(
            'job.progress-detail',
            [
                'progress_job' => $progress_job,
                'job' => $job
            ]
        );
    }

    public function done()
    {
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
                $job['completion_percentage'] = $this->completionPercentage($progress_jobs);
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
        $jobs = Job::all();
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
                $job['completion_percentage'] = $this->completionPercentage($progress_jobs);
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

    public function showProgress($id)
    {
        try {
            $job_progress_list = ProgressJob::where('job_id', $id)->get();
            $denominator = 0;
            foreach ($job_progress_list as $list) {
                if($progress_job->job_sheet) {
                    if($progress_job->job_sheet->job_sheet_man_hours) {
                        $denominator += $progress_job->job_sheet->job_sheet_man_hours;
                    }
                }
            }
            foreach ($job_progress_list as $list) {
                $job_sheet = JobSheet::find($list->job_sheet_id);
                $progress_status = ProgressStatus::find($list->progress_status_id);
                if ($job_sheet) {                   
                    $list['job_sheet_name'] = $job_sheet->job_sheet_name;
                    $list['job_sheet_man_hours'] = $job_sheet->job_sheet_man_hours;
                } else {
                    $list['job_sheet_name'] = null;
                    $list['job_sheet_man_hours'] = null;
                }
                if ($progress_status) {
                    $list['progress_status_name'] = $progress_status->progress_status_name;
                } else {
                    $list['progress_status_name'] = null;
                }

                $list['percentage'] = $job_sheet->job_sheet_man_hours / $denominator;
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
            $job['completion_percentage'] = $this->completionPercentage($progress_jobs);

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
                'job_engine_number' => 'string|max:255',
                'job_customer' => 'string|max:255',
                'job_entry_date' => 'string',
                'job_wo_file' => 'file'
            ]);

            $job = Job::create([
                'engine_model_id' => $request->engine_model_id,
                'job_order_id' => $request->job_order_id,
                'job_engine_number' => $request->job_engine_number,
                'job_customer' => $request->job_customer,
                'job_entry_date' => $request->job_entry_date
            ]);

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  time() . '-' . $file_name;

                \Cloudder::upload($file, $public_id);
                $result = \Cloudder::getResult();
                
                $job->job_wo_public_id = $result['public_id'];
                $job->job_wo_secure_url = $result['secure_url'];
            }

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
                'job_entry_date' => $request->job_entry_date
            ]);

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  time() . '-' . $file_name;

                \Cloudder::upload($file, $public_id);
                $result = \Cloudder::getResult();
                
                $job->job_wo_public_id = $result['public_id'];
                $job->job_wo_secure_url = $result['secure_url'];
            }

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
            $job->job_entry_date = $request->job_entry_date;

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                if($job->job_wo_public_id) {
                    \Cloudder::delete($job->job_wo_public_id);
                }

                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  time() . '-' . $file_name;

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
            $job->job_order_id = $request->job_order_id;
            $job->job_engine_number = $request->job_engine_number;
            $job->job_customer = $request->job_customer;
            $job->job_entry_date = $request->job_entry_date;

            if($request->hasFile('job_wo_file')) {
                $file = $request->file('job_wo_file');
                if($job->job_wo_public_id) {
                    \Cloudder::delete($job->job_wo_public_id);
                }

                $file = $request->file('job_wo_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  time() . '-' . $file_name;

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
}