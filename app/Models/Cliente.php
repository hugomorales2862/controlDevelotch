<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre', 'empresa', 'telefono', 'whatsapp', 'email', 
        'direccion', 'ciudad', 'pais', 'fecha_registro', 'estado', 
        'contacto_tecnico', 'contacto_administrativo', 'notas'
    ];

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
