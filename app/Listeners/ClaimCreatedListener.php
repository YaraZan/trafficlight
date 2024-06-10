<?php

namespace App\Listeners;

use App\Events\ClaimCreated;
use App\Models\Log;
use App\Models\LogStatus;

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

        $status = LogStatus::where('name', '=', 'Изменение значений параметров')->firstOrFail();

        $log->log_status_id = $status->id;

        $log->save();
    }
}



