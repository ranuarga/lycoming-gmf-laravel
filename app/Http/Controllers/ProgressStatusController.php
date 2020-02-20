<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressStatus;

class ProgressStatusController extends Controller
{
    public function all()
    {
        return response()->json(array(
            'progress_status' => ProgressStatus::all(),
        ));
    }

    public function index()
    {        
        return view('progress-status.index', ['progress_statuses' => ProgressStatus::all()]);
    }

    public function show($id)
    {
        try {
            return response()->json(ProgressStatus::findOrFail($id));
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
                'progress_status_name' => 'string|max:255',
            ]);
            
            $progress_status = ProgressStatus::create([
                'progress_status_name' => $request->progress_status_name,
            ]);

            return response()->json($progress_status, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $progress_status = ProgressStatus::findOrFail($id);
            $progress_status->update($request->all());

            return response()->json($progress_status, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            ProgressStatus::findOrFail($id)->delete();

            return response()->json('Progress Status Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
