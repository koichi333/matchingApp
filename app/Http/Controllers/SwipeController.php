<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Swipe;
use App\Models\Pair;

class SwipeController extends Controller
{
    public function store(Request $request)
    {
        Swipe::create([
            'from_user_id'  => Auth::user()->id,
            'to_user_id'    => $request->input('to_user_id'),
            'is_like'       => $request->input('is_like'),
        ]);

        // // 自分へいいねしてくれたユーザーIDs
        // $likedUserIds = Swipe::where('to_user_id', Auth::user()->id)->where('is_like', true)->pluck('from_user_id');
        // // 自分へいいねしてくれたユーザーへ自分がいいねしたユーザー　＝　マッチしたユーザー
        // $mathcedUsers = Swipe::where('from_user_id', Auth::user()->id)->whereIn('to_user_id', $likedUserIds)->where('is_like', true)->with('toUser')->get();

        // if (!is_null($mathcedUsers->id)) {
        //     Pair::create(
        //         [
        //             'idA' => Auth::user()->id,
        //             'idB' => 11,
        //         ]
        //     );
        // }

        return redirect(route('users.index'));
    }
}
