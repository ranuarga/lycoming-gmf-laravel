<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_orders';
    protected $primaryKey = 'job_order_id';

    protected $fillable = [
        'job_order_id',
        'job_order_name'
    ];   

    public function job()
    {
        return $this->hasMany('App\Models\Job', 'job_order_id');
    }
}
