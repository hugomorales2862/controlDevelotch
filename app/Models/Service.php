<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class Service extends Model
{
    use HasAuditLog;

    // Uses standard 'id' primary key — do NOT override with pro_id
    // The migration uses $table->id() which creates column 'id'

    protected $fillable = [
        'application_id',
        'name',
        'description',
        'price',
        'duration_days',
        'features',
        'type',
        'billing_cycle',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function quoteItems()
    {
        return $this->hasMany(QuoteItem::class);
    }
}
