<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressAttachment;

class ProgressAttachmentController extends Controller
{
    public function all()
    {
        return response()
            ->json(
                ProgressAttachment::with('progress_job')
                    ->get()
            );
    }

    public function show($id)
    {
        try {
            return response()
                ->json(
                    ProgressAttachment::with('progress_job')
                        ->findOrFail($id)
                );
        } catch (\Exceptione $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'progress_attachment_file' => 'required',
                'progress_job_id' => 'required'
            ]);

            $file = $request->file('progress_attachment_file');
            $file_name =  time() . '-' . $file->getClientOriginalName();

            // TODO
            
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function update(Type $var = null)
    {
        # code...
    }

    public function delete($id)
    {
        # code...
    }
}
