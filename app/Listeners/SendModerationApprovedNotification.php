<?php

namespace App\Listeners;

use App\Mail\ApprovedMail;
use Illuminate\Support\Facades\Mail;
use App\Events\UserModerationApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        Mail::to($user->email)->send(new ApprovedMail([
            'nama' => $user->nama,
            'subject' => 'Pemberitahuan Akses Pengguna Telah Disetujui'
        ]));
        // $user->sendModerationApprovedNotification();
    }
}
