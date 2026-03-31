<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpsServer extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'hostname',
        'provider',
        'ip_address',
        'region',
        'os',
        'cpu_cores',
        'ram_gb',
        'storage_gb',
        'status',
        'monthly_cost',
        'setup_date',
        'expiry_date',
        'details',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'details' => 'array',
        'setup_date' => 'date',
        'expiry_date' => 'date',
        'monthly_cost' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function credentials()
    {
        return $this->hasMany(ServerCredential::class);
    }
}