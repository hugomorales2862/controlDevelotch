<?php

namespace App\Models;

use App\Traits\HasAuditLog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasAuditLog;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'category',
        'description',
        'receipt_number',
        'balance',
        'purpose',
        'transaction_date',
        'spent_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'spent_at' => 'date',
        'transaction_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}