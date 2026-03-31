<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasAuditLog;

class Subscription extends Model
{
    use HasAuditLog;

    protected $fillable = [
        'client_id',
        'service_id',
        'amount',
        'billing_cycle',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getNextPaymentDateAttribute(): ?\Carbon\Carbon
    {
        if ($this->status !== 'active') {
            return null;
        }

        $start = \Carbon\Carbon::parse($this->start_date);
        $next = $start->copy();
        $now = \Carbon\Carbon::now();

        if ($this->end_date && $now->gt($this->end_date)) {
            return null;
        }

        while ($next->lte($now)) {
            switch ($this->billing_cycle) {
                case 'weekly':
                    $next->addWeek();
                    break;
                case 'yearly':
                    $next->addYear();
                    break;
                case 'triennial':
                    $next->addYears(3);
                    break;
                case 'monthly':
                default:
                    $next->addMonth();
                    break;
            }
        }

        if ($this->end_date && $next->gt($this->end_date)) {
            return null;
        }

        return $next;
    }
}
