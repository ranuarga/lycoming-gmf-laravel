<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineModel extends Model
{
    protected $table = 'engine_models';
    protected $primaryKey = 'engine_model_id';

    protected $fillable = [
        'engine_model_id',
        'engine_model_name',
        'engine_model_reference'
    ];   

    public function job()
    {
        return $this->hasMany('App\Models\Job', 'engine_model_id');
    }
}
