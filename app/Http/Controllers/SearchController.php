<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Services\Trending;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        $threads =  Thread::search(request('q'))->paginate(25);

        if(request()->expectsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }
}
