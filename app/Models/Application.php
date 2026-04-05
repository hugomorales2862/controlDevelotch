<?php

namespace App\Models;

use App\Traits\HasAuditLog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasAuditLog;
    use HasFactory;

    protected $fillable = ['name', 'description', 'url', 'status'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
