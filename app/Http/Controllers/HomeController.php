<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        $jobController = app('App\Http\Controllers\JobController');
        
        return view('home.index', [
            'done' => count($jobController->done()),
            'onProgress' => count($jobController->onProgress()),
            'all' => Job::all()->count()
        ]);
    }

    public function root()
    {
        return redirect()->route('home');
    }
}
