<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Models\User;
use App\Notifications\YouWereMentioned;
use App\Services\Mentions;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param ThreadHasNewReply $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        Mentions::notifyMentionedUsers($event->reply);
    }
}
