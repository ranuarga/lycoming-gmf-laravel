<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Controller for AdminMaster
class AdminMasterController extends Controller
{
    public function index()
    {        
        return view('admin.index', [
            'admins' => Admin::where('admin_is_master', true)->get(),
            'title' => 'Admin Master',
            'route' => 'admin-master'
        ]);
    }

    public function storeWeb(Request $request)
    {
        try {            
            $admin = Admin::create([
                'admin_user_name' => $request->admin_user_name,
                'password' => Hash::make($request->password),
                'admin_full_name' => $request->admin_full_name,
                'admin_is_master' => true
            ]);

            return redirect()->route('admin-master');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function create()
    {
        return view('admin.createOrUpdate', [
            'title' => 'Admin Master',
            'route' => 'admin-master'
        ]);
    }

    public function edit($id)
    {
        $admin = Admin::where('admin_is_master', true)
                    ->where('admin_id', $id)
                    ->first();
        if(!$admin)
            return abort(404);

        return view('admin.createOrUpdate', [
            'admin' => $admin,
            'title' => 'Admin Master',
            'route' => 'admin-master'
        ]);
    }

    public function updateWeb($id, Request $request)
    {
        try {
            $admin = Admin::where('admin_is_master', true)
                        ->where('admin_id', $id)
                        ->first();
            if(!$admin)
                return abort(404);
            $admin->admin_user_name = $request->admin_user_name;
            if(isset($request->password))
                $admin->password = Hash::make($request->password);
            $admin->admin_full_name = $request->admin_full_name;
            $admin->admin_is_master = true;
            $admin->save();

            return redirect()->route('admin-master');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function destroy($id)
    {
        $admin = Admin::where('admin_is_master', true)
                ->where('admin_id', $id)
                ->first();
        if($admin)
            $admin->delete();
        else
            return abort(404);

        return redirect()->route('admin-master');
    }
}
