<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsExport implements FromQuery, ShouldAutoSize, WithHeadings
{
    use Exportable;
    
    public function headings(): array
    {
        return [
            'Work Order Link', 
            'Job Number', 
            'Reason', 
            'Tracking Code', 
            'Engine Model', 
            'Engine Serial Number (ESN)',
            'Reference',
            'Customer',
            'Entry Date'
        ];
    }

    public function query()
    {
        return DB::table('jobs')
            ->join('job_orders', 'jobs.job_order_id', '=', 'job_orders.job_order_id')
            ->join('engine_models', 'jobs.engine_model_id', '=', 'engine_models.engine_model_id')
            ->select(
                'job_wo_secure_url',
                'job_number',
                'job_orders.job_order_name',
                'job_track_code',
                'engine_models.engine_model_name',
                'job_engine_number',
                'engine_models.engine_model_reference',
                'job_customer',
                'job_entry_date'
            )
            // ->whereYear('job_entry_date', date('Y'))
            ->orderBy('job_id', 'asc')
            ;
    }
}
