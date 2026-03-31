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
        AuditLog::create([
            'user_id' => Auth::id(),
            'client_id' => $model->cli_id ?? $model->client_id ?? null,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'old_values' => $action === 'updated' ? json_encode($model->getOriginal()) : null,
            'new_values' => $action !== 'deleted' ? json_encode($model->getAttributes()) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
