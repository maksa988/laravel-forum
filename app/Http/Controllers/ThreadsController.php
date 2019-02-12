<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Inspections\Spam;
use App\Models\Channel;
use App\Models\Thread;
use App\Services\Trending;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @param Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Spam $spam
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Spam $spam)
    {
        $this->validate($request, [
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $spam->detect(request('body'));

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);

        if (request()->wantsJson()) {
            return response($thread, 201);
        }

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param $channel
     * @param  \App\Models\Thread $thread
     * @param Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread, Trending $trending)
    {
        if(auth()->check()) {
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->increment('visits');

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $channel
     * @param Thread $thread
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update($channel, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $channel
     * @param  \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(25);
    }
}
