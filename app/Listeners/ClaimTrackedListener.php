<?php

namespace App\Listeners;

use App\Events\ClaimTracked;
use App\Events\Login;
use App\Models\Log;

class ClaimTrackedListener
{
    public function handle(ClaimTracked $event)
    {
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->ip = request()->ip();
        $log->domain = gethostbyaddr(request()->ip());
        $log->agent = request()->server('HTTP_USER_AGENT');
        $log->action = 'УТВЕРЖДЕНО: ' . $event->comment;
        $log->save();

    }
}



