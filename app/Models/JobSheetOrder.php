<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSheetOrder extends Model
{
    protected $table = 'job_sheet_orders';
    protected $primaryKey = 'job_sheet_order_id';

    protected $fillable = [
        'job_sheet_order_id',
        'job_order_id',
        'job_sheet_id'
    ];   

    public function job_sheet()
    {
        return $this->belongsTo('App\Models\JobSheet', 'job_sheet_id');
    }

    public function job_order()
    {
        return $this->belongsTo('App\Models\JobOrder', 'job_order_id');
    }
}
