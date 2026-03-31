<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'vps_server_id',
        'username',
        'password',
        'ssh_key',
    ];

    protected $casts = [
        'password' => 'encrypted',
        'ssh_key' => 'encrypted',
    ];

    public function vpsServer()
    {
        return $this->belongsTo(VpsServer::class);
    }
}