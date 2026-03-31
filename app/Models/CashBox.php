<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;

class CashBox extends Model
{
    use HasAuditLog;

    protected $fillable = [
        'concepto',
        'monto',
        'tipo',
        'saldo_anterior',
        'saldo_nuevo',
        'cashable_type',
        'cashable_id',
        'user_id',
        'ip_address',
        'user_agent',
        'notas',
    ];

    protected $casts = [
        'monto'          => 'decimal:2',
        'saldo_anterior' => 'decimal:2',
        'saldo_nuevo'    => 'decimal:2',
    ];

    // Relación polimórfica: puede ser un Payment, gasto manual, etc.
    public function cashable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receipt()
    {
        return $this->hasOne(PaymentReceipt::class, 'cash_box_id');
    }

    // ─── Scopes ──────────────────────────────────────────────

    public function scopeIngresos($query)
    {
        return $query->where('tipo', 'ingreso');
    }

    public function scopeEgresos($query)
    {
        return $query->where('tipo', 'egreso');
    }

    // ─── Static Helpers ──────────────────────────────────────

    /**
     * Obtiene el saldo actual de la caja (último movimiento).
     */
    public static function saldoActual(): float
    {
        $ultimo = static::latest()->first();
        return $ultimo ? (float) $ultimo->saldo_nuevo : 0.0;
    }

    /**
     * Registra un nuevo movimiento y calcula saldos automáticamente.
     */
    public static function registrarMovimiento(array $data): static
    {
        $saldoAnterior = static::saldoActual();
        $monto = (float) $data['monto'];

        $saldoNuevo = $data['tipo'] === 'ingreso'
            ? $saldoAnterior + $monto
            : $saldoAnterior - $monto;

        return static::create(array_merge($data, [
            'saldo_anterior' => $saldoAnterior,
            'saldo_nuevo'    => $saldoNuevo,
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]));
    }
}
