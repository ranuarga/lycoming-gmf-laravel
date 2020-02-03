<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    public function all()
    {
        return response()->json(Admin::all());
    }

    public function index()
    {
        $admins = json_decode($this->all());
        
        return view('admin.index', ['admins' => $admins]);
    }

    public function show($id)
    {
        try {
            return response()->json(Admin::findOrFail($id));
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
                'admin_user_name' => 'required|string|unique:admins|max:255',
                'password' => 'required|string|max:255',
                'admin_full_name' => 'string|max:255'
            ]);
            
            $admin = Admin::create([
                'admin_user_name' => $request->admin_user_name,
                'password' => Hash::make($request->password),
                'admin_full_name' => $request->admin_full_name
            ]);

            return response()->json($admin, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->update($request->all());

            return response()->json($admin, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Admin::findOrFail($id)->delete();

            return response()->json('Admin Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
