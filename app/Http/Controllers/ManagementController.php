<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Management;

class ManagementController extends Controller
{
    public function all()
    {
        return response()->json(Management::all());
    }

    public function index()
    {        
        return view('management.index', ['managements' => Management::all()]);
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
        try {
            $this->validate($request, [
                'management_user_name' => 'required|string|unique:managements|max:255',
                'password' => 'required|string|max:255',
                'management_full_name' => 'string|max:255'
            ]);
            
            $management = Management::create([
                'management_user_name' => $request->management_user_name,
                'password' => Hash::make($request->password),
                'management_full_name' => $request->management_full_name
            ]);

            return response()->json($management, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function storeWeb(Request $request)
    {
        try {            
            $management = Management::create([
                'management_user_name' => $request->management_user_name,
                'password' => Hash::make($request->password),
                'management_full_name' => $request->management_full_name
            ]);

            return redirect()->route('management');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function create()
    {
        return view('management.createOrUpdate');
    }

    public function edit($id)
    {
        $management = Management::findOrFail($id);

        return view('management.createOrUpdate', ['management' => $management]);
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

    public function updateWeb($id, Request $request)
    {
        try {
            $management = Management::findOrFail($id);
            $management->management_user_name = $request->management_user_name;
            if(isset($request->password))
                $engineer->password = Hash::make($request->password);
            $management->management_full_name = $request->management_full_name;
            $management->save();

            return redirect()->route('management');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Management::findOrFail($id)->delete();

            return response()->json('Management Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        Management::findOrFail($id)->delete();

        return redirect()->route('management');
    }
}
