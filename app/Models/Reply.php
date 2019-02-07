<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
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
     * @return mixed
     */
    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);

        return $matches[1];
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
}
