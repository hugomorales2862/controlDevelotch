<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'company',
        'contact_name',
        'email',
        'phone',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
