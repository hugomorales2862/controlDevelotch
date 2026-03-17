<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'cliente_id', 'nombre', 'tipo', 'descripcion', 'fecha_inicio',
        'precio_mensual', 'dia_pago', 'estado', 'proveedor', 'ip_servidor',
        'so', 'panel_control', 'dominio', 'proveedor_dominio', 
        'fecha_vencimiento_dominio', 'proveedor_dns', 'registros_dns', 'tipo_db'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
