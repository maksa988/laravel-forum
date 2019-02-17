<?php

namespace App\Services;

use App\Models\User;

class Reputation
{
    const THREAD_WAS_PUBLISHED = 10;
    const REPLY_POSTED = 2;
    const BEST_REPLY_AWARDED = 50;

    /**
     * Award reputation points to the given user.
     *
     * @param User $user
     * @param $points
     */
    public static function award($user, $points)
    {
        $user->increment('reputation', $points);
    }

    /**
     * Reduce reputation points for the given user.
     *
     * @param User $user
     * @param $points
     */
    public static function reduce($user, $points)
    {
        $user->decrement('reputation', $points);
    }
}