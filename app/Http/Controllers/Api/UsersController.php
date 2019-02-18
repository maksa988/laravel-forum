<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $search = request('username');

        return User::where('username', 'LIKE', "$search%")
            ->take(5)
            ->pluck('username');
    }
}
