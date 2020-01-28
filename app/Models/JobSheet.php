<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSheet extends Model
{
    protected $table = 'job_sheets';
    protected $primaryKey = 'job_sheet_id';

    protected $fillable = [
        'job_sheet_id',
        'job_sheet_name'
    ];   

    public function progress_job()
    {
        return $this->hasMany('App\Models\ProgressJob', 'job_sheet_id');
    }
}
