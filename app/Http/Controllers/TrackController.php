<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class TrackController extends Controller
{
    public function index()
    {
        return view('track.index');
    }

    public function search(Request $request)
    {
        try {
            return view('track.index', ['job' => Job::whereJobNumber($request->job_number)->firstOrFail()]);
        } catch(\Exception $ex) {
            return view('track.index', ['message' => 'Job Not Found']);
        }
    }
}
