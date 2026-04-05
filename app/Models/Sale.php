<?php

namespace App\Models;

use App\Traits\HasAuditLog;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasAuditLog;
    protected $fillable = [
        'client_id',
        'service_id',
        'amount',
        'payment_method',
        'sale_date',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
