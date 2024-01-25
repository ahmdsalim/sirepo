<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notifikasi;
use App\Models\User;
use App\Models\Sekolah;

class SendNotificationUser
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
        $newuser = $event->getUser();

        if($newuser->role == 'sekolah'){
            foreach(User::where('role','owner')->cursor() as $user){
                Notifikasi::create([
                    'user_id' => $user->id,
                    'title' => 'Pengguna Baru (Sekolah)',
                    'body' => 'Pengguna '.$newuser->nama.' dengan Email '.$newuser->email.' berhasil Mendaftar.'
                ]);
            }
        }else{
            $npsn = $newuser->userable->npsn;
            foreach(User::where(function($query) use ($npsn) {
                $query->whereHasMorph(
                    'userable',
                    Sekolah::class,
                    function($query) use ($npsn) {
                        $query->where('npsn', $npsn);
                    }
                )->orWhere('role', 'owner');
            })->cursor() as $user){
                Notifikasi::create([
                    'user_id' => $user->id,
                    'title' => 'Pengguna Baru ('.ucfirst($newuser->role).')',
                    'body' => ucfirst($newuser->role).' '.$newuser->nama.' Berhasil Mendaftar dengan Email '.$newuser->email.'.'
                ]);
            }
        }

    }
}
