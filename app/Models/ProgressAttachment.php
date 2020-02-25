<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressAttachment extends Model
{
    protected $table = 'progress_attachments';
    protected $primaryKey = 'progress_attachment_id';

    protected $fillable = [
        'progress_attachment_id',
        'progress_job_id',
        'cloudinary_public_id',
        'cloudinary_secure_url'
    ];   

    public function progress_job()
    {
        return $this->belongsTo('App\Models\ProgressJob', 'progress_job_id');
    }
}
