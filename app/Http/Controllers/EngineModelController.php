<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineModel;

class EngineModelController extends Controller
{
    public function all()
    {
        return response()->json(EngineModel::all());
    }

    public function index()
    {        
        return view('engine-model.index', ['engine_models' => EngineModel::all()]);
    }
    
    public function show($id)
    {
        try {
            return response()->json(EngineModel::findOrFail($id));
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
                'engine_model_name' => 'string|max:255',
                'engine_model_reference' => 'string|max:255',
            ]);
            
            $engine_model = EngineModel::create([
                'engine_model_name' => $request->engine_model_name,
                'engine_model_reference' => $request->engine_model_reference,
            ]);

            return response()->json($engine_model, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function storeWeb(Request $request)
    {
        try {            
            $engine_model = JobOrder::create([
                'engine_model_name' => $request->engine_model_name,
                'engine_model_reference' => $request->engine_model_reference,
            ]);

            return redirect()->route('engine-model');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function create()
    {
        return view('engine-model.createOrUpdate');
    }

    public function edit($id)
    {
        $engine_model = EngineModel::findOrFail($id);

        return view('engine-model.createOrUpdate', ['engine_model' => $engine_model]);
    }


    public function update($id, Request $request)
    {
        try {
            $engine_model = EngineModel::findOrFail($id);
            $engine_model->update($request->all());

            return response()->json($engine_model, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function updateWeb($id, Request $request)
    {
        try {
            $engine_model = EngineModel::findOrFail($id);
            $engine_model->update($request->all());
            
            return redirect()->route('engine-model');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            EngineModel::findOrFail($id)->delete();

            return response()->json('Engine Model Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        EngineModel::findOrFail($id)->delete();

        return redirect()->route('engine-model');
    }
}
