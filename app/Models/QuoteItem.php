<?php

namespace App\Models;

use App\Traits\HasAuditLog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasAuditLog;
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'service_id',
        'description',
        'quantity',
        'unit_price',
        'line_total',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function calculateLineTotal(): self
    {
        $this->line_total = $this->quantity * $this->unit_price;
        $this->save();
        return $this;
    }
}