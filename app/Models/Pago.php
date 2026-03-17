<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'cliente_id', 'servicio_id', 'monto', 'fecha_vencimiento', 
        'estado', 'metodo_pago', 'fecha_pago', 'comprobante', 'observaciones'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
