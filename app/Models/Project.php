<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasAuditLog;

class Project extends Model
{
    use HasFactory, HasAuditLog;

    protected $fillable = [
        'client_id',
        'user_id',
        'name',
        'description',
        'notes',
        'status',
        'priority',
        'start_date',
        'due_date',
        'budget',
        'assigned_to',
        'settings',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'settings' => 'array',
        'budget' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}