<?php

namespace App\Listeners;

use App\Events\UserActivated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Notifikasi;

class SendNotificationUserActivated
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
    public function handle(UserActivated $event): void
    {
        $activateduser = $event->getUser();

        $npsn = $activateduser->userable->npsn;
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
                'title' => 'Aktivasi Pengguna ('.ucfirst($activateduser->role).')',
                'body' => ucfirst($activateduser->role).' '.$activateduser->nama.' Berhasil Mengaktivasi Akun.'
            ]);
        }
    }
}
