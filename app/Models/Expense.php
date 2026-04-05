<?php

namespace App\Models;

use App\Traits\HasAuditLog;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasAuditLog;
    protected $fillable = [
        'description',
        'amount',
        'expense_date',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];
}
