<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressStatus extends Model
{
    protected $table = 'progress_statuses';
    protected $primaryKey = 'progress_status_id';

    protected $fillable = [
        'progress_status_id',
        'progress_status_name'
    ];   

    public function progress_job()
    {
        return $this->hasMany('App\Models\ProgressJob', 'progress_status_id');
    }
}
