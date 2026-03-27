<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'application_id',
        'name',
        'price',
        'duration_days',
        'features',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
