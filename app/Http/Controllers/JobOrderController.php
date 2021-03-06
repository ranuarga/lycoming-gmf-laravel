<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOrder;
use App\Models\JobSheet;
use App\Models\JobSheetOrder;

class JobOrderController extends Controller
{
    public function all()
    {
        return response()->json(JobOrder::all());
    }

    public function index()
    {        
        return view('job-order.index', ['job_orders' => JobOrder::all()]);
    }
    
    public function show($id)
    {
        try {
            return response()->json(JobOrder::findOrFail($id));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function jobSheetByJobOrderID($id)
    {
        $job_sheet_orders = JobSheetOrder::where('job_order_id', $id)->orderBy('job_sheet_id', 'asc')->get();
        return view(
            'job-order.job-sheet',
            [
                'job_order' => JobOrder::findOrFail($id),
                'job_sheet_orders' => $job_sheet_orders,
            ]
        );
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'job_order_name' => 'string|max:255',
            ]);
            
            $job_order = JobOrder::create([
                'job_order_name' => $request->job_order_name,
            ]);

            return response()->json($job_order, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }    

    public function storeWeb(Request $request)
    {
        try {
            $job_order = JobOrder::create([
                'job_order_name' => $request->job_order_name,
            ]);

            if($request->has('chosen_job_sheets')) {
                foreach ($request->input('chosen_job_sheets') as $job_sheet_id) {
                    JobSheetOrder::create([
                        'job_sheet_id' => $job_sheet_id,
                        'job_order_id' => $job_order->job_order_id
                    ]);
                }
            }

            return redirect()->route('job-order');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function create()
    {
        return view('job-order.createOrUpdate', [
            'job_sheets' => JobSheet::all()
        ]);
    }

    public function edit($id)
    {
        $job_order = JobOrder::findOrFail($id);
        $job_sheet_orders = JobSheetOrder::where('job_order_id', $id)->get();

        return view('job-order.createOrUpdate', [
            'job_order' => $job_order,
            'job_sheets' => JobSheet::all(),
            'job_sheet_orders' => $job_sheet_orders
        ]);
    }
    
    public function update($id, Request $request)
    {
        try {
            $job_order = JobOrder::findOrFail($id);
            $job_order->update($request->all());

            return response()->json($job_order, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function updateWeb($id, Request $request)
    {
        try {
            $job_order = JobOrder::findOrFail($id);
            $job_order->update($request->all());
            $job_sheet_orders = JobSheetOrder::where('job_order_id', $id)->get();
            // Check If User Add New Job Sheet To Job Order
            if($request->has('chosen_job_sheets')) {
                foreach ($request->input('chosen_job_sheets') as $job_sheet_id) {
                    $found = false;
                    foreach ($job_sheet_orders as $job_sheet_order) {
                        if($job_sheet_id == $job_sheet_order->job_sheet_id) {
                            $found = true;
                            break;
                        }
                    }
                    if($found == false) {
                        JobSheetOrder::create([
                            'job_sheet_id' => $job_sheet_id,
                            'job_order_id' => $id
                        ]);
                    }
                }
            }

            // Check If User Delete Job Sheet From Job Order
            foreach ($job_sheet_orders as $job_sheet_order) {
                $found = false;
                if($request->has('chosen_job_sheets')) {
                    foreach ($request->input('chosen_job_sheets') as $job_sheet_id) {
                        if($job_sheet_id == $job_sheet_order->job_sheet_id) {
                            $found = true;
                            break;
                        }
                    }
                }
                if($found == false) {
                    JobSheetOrder::where('job_sheet_id', $job_sheet_order->job_sheet_id)
                        ->where('job_order_id', $job_sheet_order->job_order_id)
                        ->delete();
                }
            }
            
            return redirect()->route('job-order');
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            JobOrder::findOrFail($id)->delete();

            return response()->json('Job Order Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        JobOrder::findOrFail($id)->delete();

        return redirect()->route('job-order');
    }
}
