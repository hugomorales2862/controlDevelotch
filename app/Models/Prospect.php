<?php

namespace App\Models;

use App\Traits\HasAuditLog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Prospect extends Model
{
    use HasAuditLog, HasFactory, Notifiable;

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'website',
        'industry',
        'notes',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function quotes()
    {
        return $this->morphMany(Quote::class, 'quoteable');
    }

    public function toClient(): Client
    {
        $client = Client::create([
            'name' => $this->company_name ?: $this->contact_name,
            'company' => $this->company_name,
            'contact_name' => $this->contact_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'metadata' => json_encode([
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
                'website' => $this->website,
                'industry' => $this->industry,
                'notes' => $this->notes,
                'converted_from_prospect_id' => $this->id
            ]),
        ]);

        // Migrate quotes to the new Client
        foreach ($this->quotes as $quote) {
            $quote->update([
                'quoteable_type' => Client::class,
                'quoteable_id' => $client->cli_id,
            ]);
        }

        // Promover el estado del prospecto o eliminarlo. Actualizaremos su estado a 'converted'
        $this->update(['status' => 'converted']);

        return $client;
    }
}