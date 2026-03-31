<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasAuditLog;

class Quote extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'client_id',
        'user_id',
        'reference',
        'title',
        'description',
        'valid_until',
        'status',
        'total',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'metadata' => 'array',
        'total' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function calculateTotal(): float
    {
        $total = $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
        
        $this->update(['total' => $total]);
        return $total;
    }
}