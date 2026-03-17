<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'tipo'];

    public function transacciones()
    {
        return $this->hasMany(Transaccion::class);
    }
}
