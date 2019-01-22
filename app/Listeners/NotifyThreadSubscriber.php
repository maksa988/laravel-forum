<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

class NotifyThreadSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ThreadHasNewReply $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        $event->thread->notifySubscribers($event->reply);
    }
}
