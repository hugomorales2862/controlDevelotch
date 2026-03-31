<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'user_id',
        'number',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a new unique correlative number for receipts.
     */
    public static function generateNumber(): string
    {
        $lastReceipt = self::orderBy('id', 'desc')->first();
        $nextId = $lastReceipt ? $lastReceipt->id + 1 : 1;
        return 'REC-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}
