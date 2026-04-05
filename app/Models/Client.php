<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Traits\HasAuditLog;

class Client extends Model
{
    use HasAuditLog, Notifiable;
    protected $primaryKey = 'cli_id';
    
    protected $fillable = [
        'name',
        'company',
        'contact_name',
        'email',
        'phone',
        'nit',
        'dpi',
        'razon_social',
        'ejecutivo_id',
        'metadata',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'client_id', 'cli_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'client_id', 'cli_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'client_id', 'cli_id');
    }

    public function quotes()
    {
        return $this->morphMany(Quote::class, 'quoteable');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id', 'cli_id');
    }

    public function domains()
    {
        return $this->hasMany(Domain::class, 'client_id', 'cli_id');
    }
}
