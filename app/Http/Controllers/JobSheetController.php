<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobSheet;

class JobSheetController extends Controller
{
    public function all()
    {
        return response()->json(JobSheet::all());
    }

    public function index()
    {        
        return view('job-sheet.index', ['job_sheets' => JobSheet::all()]);
    }

    public function show($id)
    {
        try {
            return response()->json(JobSheet::findOrFail($id));
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
                'job_sheet_name' => 'string|max:255',
                'job_sheet_man_hours' => 'numeric'
            ]);
            
            $job_sheet = JobSheet::create([
                'job_sheet_name' => $request->job_sheet_name,
                'job_sheet_man_hours' => $request->job_sheet_man_hours
            ]);

            return response()->json($job_sheet, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $job_sheet = JobSheet::findOrFail($id);
            $job_sheet->update($request->all());

            return response()->json($job_sheet, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            JobSheet::findOrFail($id)->delete();

            return response()->json('Job Sheet Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
