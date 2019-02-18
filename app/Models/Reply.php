<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $with = ['owner', 'favorites'];

    /**
     * @var array
     */
    protected $appends = ['favoritesCount', 'isFavorited'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');

            $reply->owner->gainReputation('reply_posted');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');

            $reply->owner->loseReputation('reply_posted');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * @return mixed
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(now()->subMinute());
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    /**
     * @param $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body);
    }

    /**
     * @return bool
     */
    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     * @param $body
     * @return mixed
     */
    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }

    /**
     * Get the related title for the reply.
     */
    public function title()
    {
        return $this->thread->title;
    }
}
