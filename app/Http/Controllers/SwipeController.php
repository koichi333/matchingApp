<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Swipe;


class SwipeController extends Controller
{
    public function store(Request $request)
    {
        Swipe::create([
            'from_user_id'  => \Auth::user()->id,
            'to_user_id'    => $request->input('to_user_id'),
            'is_like'       => $request->input('is_like'),
        ]);

        return redirect(route('users.index'));
    }
}
