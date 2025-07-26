<?php

namespace App\Listeners;

use App\Events\Registered;
use App\Mail\RegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailRegisteredNotification
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
    public function handle(Registered $event): void
    {
        $data = $event->data;
        Mail::to($data['email'])->send(new RegisteredMail([
            'nama' => $data['nama'],
            'username' => $data['username'],
            'password' => $data['password'],
            'subject' => 'Pendaftaran Akun Berhasil'
        ]));
    }
}
