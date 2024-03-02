<?php

namespace App\Providers;

use App\Events\Registered;
use Illuminate\Support\Facades\Event;
use App\Events\UserModerationApproved;
use App\Listeners\SendEmailRegisteredNotification;
use App\Listeners\SendModerationApprovedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailRegisteredNotification::class,
        ],
        UserModerationApproved::class => [
            SendModerationApprovedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
