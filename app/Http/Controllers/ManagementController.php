<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Management;

class ManagementController extends Controller
{
    public function all()
    {
        return response()->json(Management::all());
    }

    public function show($id)
    {
        try {
            return response()->json(Management::findOrFail($id));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'management_user_name' => 'string|max:255',
            'management_password' => 'required|string|max:255',
            'management_full_name' => 'string|max:255'
        ]);

        try {
            $management = Management::create([
                'management_user_name' => $request->management_user_name,
                'management_password' => Hash::make($request->management_password),
                'management_full_name' => $request->management_full_name
            ]);

            return response()->json($management, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $management = Management::findOrFail($id);
            $management->update($request->all());

            return response()->json($management, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Management::findOrFail($id)->delete();

            return response()->json('Management Status Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
