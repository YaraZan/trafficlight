<?php

namespace App\Listeners;

use App\Events\ClaimDeclined;
use App\Models\Log;
use App\Models\LogStatus;
class ClaimDeclinedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClaimDeclined $event)
    {
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->ip = request()->ip();
        $log->domain = gethostbyaddr(request()->ip());
        $log->agent = request()->server('HTTP_USER_AGENT');
        $log->action = 'ОТКЛОНЕНО: ' . $event->comment;

        $status = LogStatus::where('name', '=', 'Отклонение заявок')->firstOrFail();

        $log->log_status_id = $status->id;

        $log->save();

    }
}
