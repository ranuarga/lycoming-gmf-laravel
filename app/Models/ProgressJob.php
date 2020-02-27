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

    protected $casts = [
        'progress_job_date_start'  => 'date:d-M-Y',
        'progress_job_date_completion'  => 'date:d-M-Y',
    ];

    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id');
    }

    public function job_sheet()
    {
        return $this->belongsTo('App\Models\JobSheet', 'job_sheet_id');
    }

    public function engineer()
    {
        return $this->belongsTo('App\Models\Engineer', 'engineer_id');
    }

    public function management()
    {
        return $this->belongsTo('App\Models\Management', 'management_id');
    }
    
    public function progress_status()
    {
        return $this->belongsTo('App\Models\ProgressStatus', 'progress_status_id');
    }

    public function progress_attachment()
    {
        return $this->hasMany('App\Models\ProgressAttachment', 'progress_job_id');
    }
}
