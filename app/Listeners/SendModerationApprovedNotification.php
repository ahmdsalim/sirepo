<?php

namespace App\Listeners;

use App\Events\UserModerationApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendModerationApprovedNotification
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
    public function handle(UserModerationApproved $event): void
    {
        $user = $event->user;
        $user->sendModerationApprovedNotification();
    }
}
