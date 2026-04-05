<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait HasAuditLog
{
    public static function bootHasAuditLog()
    {
        static::created(function ($model) {
            static::logAction($model, 'created');
        });

        static::updated(function ($model) {
            static::logAction($model, 'updated');
        });

        static::deleted(function ($model) {
            static::logAction($model, 'deleted');
        });
    }

    protected static function logAction($model, string $action)
    {
        $oldValues = null;
        $newValues = null;

        if ($action === 'updated') {
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            
            // Si Laravel ya actualizó y guardó, getChanges devuelve los campos cambiados.
            if (empty($changes)) {
                // A veces logAction puede llamarse manual, fallback checking
                if ($model->isDirty()) {
                   $changes = $model->getDirty();
                } else {
                   return; // No hay cambios reales, no registrar
                }
            }

            $oldValuesArray = [];
            $newValuesArray = [];

            foreach ($changes as $key => $value) {
                // Ignore timestamp fields if they are the only changes
                if (in_array($key, ['updated_at'])) continue;
                
                $oldValuesArray[$key] = $original[$key] ?? null;
                $newValuesArray[$key] = $value;
            }

            if (empty($newValuesArray)) {
                return; // Solo actualizó el updated_at u otros ignorados
            }

            $oldValues = $oldValuesArray;
            $newValues = $newValuesArray;
        } elseif ($action === 'created') {
            $newValues = $model->getAttributes();
        } elseif ($action === 'deleted') {
            $oldValues = $model->getOriginal();
        }
        $clientId = $model->cli_id ?? $model->client_id ?? null;
        if ($action === 'deleted' && get_class($model) === \App\Models\Client::class) {
            $clientId = null;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'client_id' => $clientId,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
