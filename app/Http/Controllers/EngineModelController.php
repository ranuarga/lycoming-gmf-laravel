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
            ]);
            
            $engine_model = EngineModel::create([
                'engine_model_name' => $request->engine_model_name,
            ]);

            return response()->json($engine_model, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
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
}
