<?php

namespace App\Providers;

use App\Events\ClaimCreated;
use App\Events\ClaimTracked;
use App\Listeners\ClaimCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Events\UserAction;
use App\Listeners\ClaimTrackedListener;
use App\Listeners\LoginSuccessfull;
use App\Listeners\LogoutSuccessfull;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            LoginSuccessfull::class,
        ],
        Logout::class => [
            LogoutSuccessfull::class,
        ],
        ClaimCreated::class => [
            ClaimCreatedListener::class,
        ],
        ClaimTracked::class => [
            ClaimTrackedListener::class,
        ]
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
