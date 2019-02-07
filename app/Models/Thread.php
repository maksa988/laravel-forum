<?php

namespace App\Models;

use App\Events\ThreadHasNewReply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $with = ['creator', 'channel'];

    /**
     * @var array
     */
    protected $appends = ['isSubscribedTo'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }

    /**
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param $reply
     * @return Model
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    /**
     * @param $reply
     */
    public function notifySubscribers($reply)
    {
        $this->subscriptions
            ->where('user_id', '!=', $reply->user_id)
            ->each
            ->notify($this->reply);
    }

    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * @param null $userId
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id()
        ]);
    }

    /**
     * @param null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?? auth()->id())
            ->delete();
    }

    /**
     *
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * @return bool
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function hasUpdatesFor(User $user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }
}
