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
            'inProgress' => count($jobController->inProgress()),
            'all' => Job::all()->count()
        ]);
    }
}
