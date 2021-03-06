<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\ProgressJob;

class TrackController extends Controller
{
    public function index()
    {
        return view('track.index');
    }

    public function search(Request $request)
    {
        try {
            $job_track_code = strtolower($request->job_track_code);
            $job = Job::whereJobTrackCode($job_track_code)->first();
            if ($job) {
                $progress_jobs = ProgressJob::whereJobId($job->job_id)->orderBy('progress_job_id', 'asc')->get();
                $tmp = $this->completionPercentage($progress_jobs);
                if($progress_jobs) {
                    return view('track.index', [
                        'job' => $job,
                        'progress_jobs' => $progress_jobs,
                        'completion_percentage' => $tmp['completion_percentage'],
                        'days_to_complete' => $tmp['days_to_complete'],
                        'days_passed' => $tmp['days_passed']
                    ]);
                }
            }
            
            return view('track.index', ['message' => 'Job Not Found']);
        } catch(\Exception $ex) {
            return view('track.index', ['message' => $ex->getMessage()]);
        }
    }
}
