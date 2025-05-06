<?php

namespace App\Helpers;

use App\Models\Admin\Log;
use Illuminate\Support\Facades\Auth;

class LoggerHelper
{
    public static function logAction(string $action, $model, array $changes = null)
    {
        try {
            Log::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'changes' => $changes,
            ]);
        } catch (\Exception $e) {
            // Optionally log to file instead if database is down
            \Log::error('Failed to log action', ['error' => $e->getMessage()]);
        }
    }
}
