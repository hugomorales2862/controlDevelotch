<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bank_name',
        'account_number',
        'currency',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}