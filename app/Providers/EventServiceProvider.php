<?php

namespace App\Providers;

use App\Events\ThreadHasNewReply;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\NotifyThreadSubscriber;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ThreadHasNewReply::class => [
            NotifyThreadSubscriber::class,
            NotifyMentionedUsers::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
