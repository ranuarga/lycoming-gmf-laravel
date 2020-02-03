<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Engineer extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $table = 'engineers';
    protected $primaryKey = 'engineer_id';

    protected $fillable = [
        'engineer_id',
        'engineer_user_name',
        'password',
        'engineer_full_name'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
    
    public function progress_job()
    {
        return $this->hasMany('App\Models\ProgressJob', 'engineer_id');
    }
}
