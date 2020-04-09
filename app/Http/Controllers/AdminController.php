<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Controller for Admin/Production Control Who Isn't Master Admin
class AdminController extends Controller
{
    public function all()
    {
        $admin = Admin::where('admin_is_master', '!=', true)->get();
        return response()->json($admin);
    }

    public function index()
    {        
        return view('admin.index', [
            'admins' => Admin::where('admin_is_master', '!=', true)->get(),
            'title' => 'Production Control',
            'route' => 'admin'
        ]);
    }

    public function show($id)
    {
        try {
            return response()->json(
                Admin::where('admin_is_master', '!=', true)
                    ->where('admin_id', $id)
                    ->first()
            );
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
                'admin_full_name' => $request->admin_full_name,
                'admin_is_master' => false
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
                'admin_full_name' => $request->admin_full_name,
                'admin_is_master' => false
            ]);

            return redirect()->route('admin');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function create()
    {
        return view('admin.createOrUpdate', [
            'title' => 'Production Control',
            'route' => 'admin'
        ]);
    }

    public function edit($id)
    {
        $admin = Admin::where('admin_is_master', '!=', true)
                    ->where('admin_id', $id)
                    ->first();
        if(!$admin)
            return abort(404);

        return view('admin.createOrUpdate', [
            'admin' => $admin,
            'title' => 'Production Control',
            'route' => 'admin'
        ]);
    }
    
    public function update($id, Request $request)
    {
        try {
            $admin = Admin::where('admin_is_master', '!=', true)
                        ->where('admin_id', $id)
                        ->first();
            if(!$admin)
                return abort(404);
            $admin->admin_user_name = $request->admin_user_name;
            if(isset($request->password))
                $admin->password = Hash::make($request->password);
            $admin->admin_full_name = $request->admin_full_name;
            $admin->admin_is_master = false;
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
            $admin = Admin::where('admin_is_master', '!=', true)
                        ->where('admin_id', $id)
                        ->first();
            if(!$admin)
                return abort(404);
            $admin->admin_user_name = $request->admin_user_name;
            if(isset($request->password))
                $admin->password = Hash::make($request->password);
            $admin->admin_full_name = $request->admin_full_name;
            $admin->admin_is_master = false;
            $admin->save();

            return redirect()->route('admin');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $admin = Admin::where('admin_is_master', '!=', true)
                ->where('admin_id', $id)
                ->first();
            if($admin)
                $admin->delete();
            else
                return response()->json('Admin Not Found', 404);

            return response()->json('Admin Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $admin = Admin::where('admin_is_master', '!=', true)
                ->where('admin_id', $id)
                ->first();
        if($admin)
            $admin->delete();
        else
            return abort(404);

        return redirect()->route('admin');
    }
}
