<?php

// app/Helpers/ActivityLogger.php


namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log($action, $model = null, $description = null, $changes = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model->id ?? null,
            'description' => $description,
            'changes' => $changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
