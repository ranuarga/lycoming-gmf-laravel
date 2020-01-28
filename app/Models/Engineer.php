<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    protected $table = 'engineers';
    protected $primaryKey = 'engineer_id';

    protected $fillable = [
        'engineer_id',
        'engineer_user_name',
        'engineer_password',
        'engineer_full_name'
    ];

    protected $hidden = [
        'engineer_password'
    ];

    public function progress_job()
    {
        return $this->hasMany('App\Models\ProgressJob', 'engineer_id');
    }
}
