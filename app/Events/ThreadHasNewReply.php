<?php

namespace App\Events;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Queue\SerializesModels;

class ThreadHasNewReply
{
    use SerializesModels;

    /**
     * @var Thread
     */
    public $thread;

    /**
     * @var Reply
     */
    public $reply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }
}
