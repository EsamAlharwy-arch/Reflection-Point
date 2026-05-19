<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'token',
        'mime_type',
        'size',
        'file_hash',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
}
