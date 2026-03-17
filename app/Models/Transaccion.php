<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'tipo', 'categoria_id', 'descripcion', 'monto', 'fecha', 
        'metodo_pago', 'comprobante'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
