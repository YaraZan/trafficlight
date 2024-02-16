<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClaimCreated
{
    use Dispatchable, SerializesModels;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }
}
