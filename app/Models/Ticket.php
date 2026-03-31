<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'subject',
        'description',
        'status',
        'priority',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'cli_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }
}