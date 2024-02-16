<?php

namespace App\Listeners;

use App\Events\ClaimCreated;
use App\Events\Login;
use App\Models\Log;

class ClaimCreatedListener
{
    public function handle(ClaimCreated $event)
    {
        $log = new Log;
        $log->user_id = auth()->user()->id;
        $log->ip = request()->ip();
        $log->domain = gethostbyaddr(request()->ip());
        $log->agent = request()->server('HTTP_USER_AGENT');
        $log->action = 'ИЗМЕНЕНИЕ: ' . $event->comment;
        $log->save();

    }
}



