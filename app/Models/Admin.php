<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'admin_id',
        'admin_user_name',
        'admin_password',
        'admin_full_name'
    ];

    protected $hidden = [
        'admin_password'
    ];
}
