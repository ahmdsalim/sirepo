<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Mail\SendEmailAktivasi;

class SendEmailNotification
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
    public function handle(UserRegistered $event): void
    {
        $user = $event->getUser();
        if($user->role == 'sekolah'){
            Mail::to($user->email)->send(new SendEmail([
                'nama' => $user->nama,
                'subject' => 'Welcome to RuangBaca.me!'
            ]));
        }else{
            $token = $event->getToken();
            Mail::to($user->email)->send(new SendEmailAktivasi([
                'nama' => $user->nama,
                'subject' => 'Aktivasi Akun ('.$user->nama.')',
                'token' => $token
            ]));
        }
    }
}
