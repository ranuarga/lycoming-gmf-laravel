<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressJob extends Model
{
    protected $table = 'progress_jobs';
    protected $primaryKey = 'progress_job_id';

    protected $fillable = [
        'progress_job_id',
        'job_id',
        'job_sheet_id',
        'engineer_id',
        'management_id',
        'progress_status_id',
        'progress_job_date_start',
        'progress_job_date_completion',
        'progress_job_remark',
        'progress_job_note'
    ];

    public function progress_job()
    {
        return $this->hasMany('App\Models\ProgressJob', 'job_id');
    }

    public function engine_model()
    {
        return $this->belongsTo('App\Models\EngineModel', 'engine_model_id');
    }

    public function job_order()
    {
        return $this->belongsTo('App\Models\JobOrder', 'job_order_id');
    }
}
