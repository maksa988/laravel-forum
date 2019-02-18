<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilters extends Filters
{
    /**
     * @var array
     */
    protected $filters = ['by', 'popular', 'unanswered'];

    /**
     * @param $builder
     * @param $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * @return mixed
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * @return mixed
     */
    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}