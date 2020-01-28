<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $table = 'managements';
    protected $primaryKey = 'management_id';

    protected $fillable = [
        'management_id',
        'management_user_name',
        'management_password',
        'management_full_name'
    ];

    protected $hidden = [
        'management_password'
    ];

    public function progress_job()
    {
        return $this->hasMany('App\Models\ProgressJob', 'management_id');
    }
}
