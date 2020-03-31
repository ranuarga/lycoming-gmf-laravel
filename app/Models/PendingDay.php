<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingDay extends Model
{
    protected $table = 'pending_days';
    protected $primaryKey = 'pending_day_id';

    protected $fillable = [
        'pending_day_id',
        'progress_job_id',
        'pending_day_date_start',
        'pending_day_date_end'
    ];   

    public function progress_job()
    {
        return $this->belongsTo('App\Models\ProgressJob', 'progress_job_id');
    }
}
