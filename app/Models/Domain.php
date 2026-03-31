<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class Domain extends Model
{
    use HasAuditLog;

    protected $fillable = [
        'client_id',
        'name',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }
}
