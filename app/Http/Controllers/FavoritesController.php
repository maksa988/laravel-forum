<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Services\Reputation;

class FavoritesController extends Controller
{
    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Reply $reply)
    {
        $reply->favorite(auth()->id());

        Reputation::award($reply->owner, Reputation::REPLY_FAVIROTED);

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite(auth()->id());

        Reputation::reduce($reply->owner, Reputation::REPLY_FAVIROTED);
    }
}
