<?php

namespace App\Listeners;

use App\Events\Login;
use App\Models\Log;

class LogoutSuccessfull
{
    public function handle()
    {
        // Create a log entry
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->ip = request()->ip();
        $log->domain = gethostbyaddr(request()->ip());
        $log->agent = request()->server('HTTP_USER_AGENT');
        $log->action = 'Выход из системы';
        $log->save();
        
    }
}

