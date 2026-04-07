<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAccessToken extends Model
{
    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];
}
