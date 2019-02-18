<?php

namespace App\Http\Controllers;

use App\Models\Reply;

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

        $reply->owner->gainReputation('reply_favorited');

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite(auth()->id());

        $reply->owner->loseReputation('reply_favorited');
    }
}
