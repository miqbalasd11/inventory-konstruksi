<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityHelper
{
    public static function log($aktivitas, $deskripsi = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
        ]);
    }
}
