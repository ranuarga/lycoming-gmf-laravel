<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'job_id',
        'engine_model_id',
        'job_order_id',
        'job_number',
        'job_engine_number',
        'job_customer',
        'job_entry_date'
    ];

    protected $casts = [
        'job_entry_date'  => 'date:d-M-Y',
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
