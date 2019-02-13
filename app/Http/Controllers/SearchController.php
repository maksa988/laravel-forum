<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Services\Trending;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        if(request()->expectsJson()) {
            return Thread::search(request('q'))->paginate(25);
        }

        return view('threads.search', [
            'trending' => $trending->get(),
        ]);
    }
}
