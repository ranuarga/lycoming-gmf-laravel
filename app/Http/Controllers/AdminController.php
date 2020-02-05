<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function all()
    {
        return response()->json(Admin::all());
    }

    public function index()
    {        
        return view('admin.index', ['admins' => Admin::all()]);
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

    public function storeWeb(Request $request)
    {
        try {            
            $admin = Admin::create([
                'admin_user_name' => $request->admin_user_name,
                'password' => Hash::make($request->password),
                'admin_full_name' => $request->admin_full_name
            ]);

            return redirect()->route('admin');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function create()
    {
        return view('admin.createOrUpdate');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.createOrUpdate', ['admin' => $admin]);
    }
    
    public function update($id, Request $request)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->admin_user_name = $request->admin_user_name;
            if(isset($request->password))
                $admin->password = Hash::make($request->password);
            $admin->admin_full_name = $request->admin_full_name;
            $admin->save();

            return response()->json($admin, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function updateWeb($id, Request $request)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->admin_user_name = $request->admin_user_name;
            if(isset($request->password))
                $admin->password = Hash::make($request->password);
            $admin->admin_full_name = $request->admin_full_name;
            $admin->save();

            return redirect()->route('admin');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
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

    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();

        return redirect()->route('admin');
    }
}
