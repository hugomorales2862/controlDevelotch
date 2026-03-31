<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'invoice_number',
        'status',
        'issue_date',
        'due_date',
        'sub_total',
        'tax',
        'tax_rate',
        'discount',
        'total',
        'notes',
        'items',
        'metadata',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date'   => 'date',
        'sub_total'  => 'decimal:2',
        'tax'        => 'decimal:2',
        'total'      => 'decimal:2',
        'tax_rate'   => 'decimal:2',
        'discount'   => 'decimal:2',
        'items'      => 'array',
        'metadata'   => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getPaidAmountAttribute(): float
    {
        return $this->payments()->sum('amount');
    }

    public function getBalanceAttribute(): float
    {
        return (float) $this->total - $this->paid_amount;
    }

    public function isOverdue(): bool
    {
        return $this->status !== 'paid' &&
            Carbon::now()->gt($this->due_date);
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'draft' => 'Borrador',
            'sent' => 'Enviado',
            'paid' => 'Pagado',
            'partial' => 'Parcial',
            'overdue' => 'Vencido',
            'cancelled' => 'Cancelado',
        ];

        return $labels[$this->status] ?? ucfirst($this->status);
    }
}