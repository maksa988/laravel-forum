<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed(User $user, $take = 50)
    {
        return static::where('user_id', $user->id)
            ->with('subject')
            ->latest()
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format("Y-m-d");
            });
    }
}
