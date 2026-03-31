<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class Payment extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'invoice_id',
        'bank_account_id',
        'user_id',
        'subscription_id',
        'receipt_number',
        'payment_method',
        'amount',
        'paid_at',
        'reference',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'date',
        'amount'  => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function receipt()
    {
        return $this->hasOne(PaymentReceipt::class);
    }

    // Relación polimórfica inversa desde CashBox
    public function cashBoxEntry()
    {
        return $this->morphOne(CashBox::class, 'cashable');
    }
}