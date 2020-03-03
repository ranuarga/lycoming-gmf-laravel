<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressAttachment;
use App\Models\ProgressJob;

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
                'progress_attachment_file' => 'required|file',
                'progress_job_id' => 'required'
            ]);

            $file = $request->file('progress_attachment_file');
            $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $public_id =  time() . '-' . $file_name;

            \Cloudder::upload($file, $public_id);
            $result = \Cloudder::getResult();

            $progress_attachment = ProgressAttachment::create([
                'progress_job_id' => $request->progress_job_id,
                'cloudinary_public_id' => $result['public_id'],
                'cloudinary_secure_url' => $result['secure_url'],
            ]);

            return response()->json(array(
                'progress_attachment' => $progress_attachment,
                'message' => 'Success'
            ));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $progress_attachment = ProgressAttachment::findOrFail($id);
            $progress_attachment->progress_job_id = $request->progress_job_id;
            
            if($request->hasFile('progress_attachment_file')) {
                $file = $request->file('progress_attachment_file');
                if($progress_attachment->cloudinary_public_id) {
                    \Cloudder::delete($progress_attachment->cloudinary_public_id);
                }

                $file = $request->file('progress_attachment_file');
                $file_name = rawurlencode(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $public_id =  time() . '-' . $file_name;

                \Cloudder::upload($file, $public_id);
                $result = \Cloudder::getResult();
                
                $progress_attachment->cloudinary_public_id = $result['public_id'];
                $progress_attachment->cloudinary_secure_url = $result['secure_url'];
            }
            $progress_attachment->save();

            return response()->json($progress_attachment, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $progress_attachment = ProgressAttachment::findOrFail($id);
            $cloudinary_public_id = $progress_attachment->cloudinary_public_id;
            
            if($cloudinary_public_id)
                \Cloudder::delete($cloudinary_public_id);

            $progress_attachment->delete();

            return response()->json(array(
                'message' => 'File Deleted Successfully'
            ));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
