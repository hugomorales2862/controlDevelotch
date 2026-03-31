<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasAuditLog;

class Contact extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'client_id',
        'name',
        'role',
        'email',
        'phone',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }
}