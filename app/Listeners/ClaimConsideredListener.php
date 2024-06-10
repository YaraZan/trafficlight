<?php

namespace App\Listeners;

use App\Events\ClaimConsidered;
use App\Models\Log;
use App\Models\LogStatus;

class ClaimConsideredListener
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
    public function handle(ClaimConsidered $event)
    {
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->ip = request()->ip();
        $log->domain = gethostbyaddr(request()->ip());
        $log->agent = request()->server('HTTP_USER_AGENT');
        $log->action = 'УТВЕРЖДЕНО: ' . $event->comment;

        $status = LogStatus::where('name', '=', 'Утверждение заявок')->firstOrFail();

        $log->log_status_id = $status->id;

        $log->save();

    }
}
