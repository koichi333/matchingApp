<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Swipe;

class UserController extends Controller
{
    public function index()
    {
        // すでにスワイプしたuser.idを取得
        $swipedUserIds = Swipe::where('from_user_id', Auth::user()->id)->get()->pluck('to_user_id');

        // スワイプしていないuserを1つを取得

        $user = User::where('id', '<>', Auth::user()->id)->whereNotIn('id', $swipedUserIds)->first();
        // return dd($user);
        if ($user == null) {
            return view('pages.user.done');
        }

        return view('pages.user.index', [
            'user' => $user
        ]);
    }
}
