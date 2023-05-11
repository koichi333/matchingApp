<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Swipe;
use App\Models\Chat;
use App\Models\Comment;

use Illuminate\Support\Facades\Auth;

use App\Library\Message;   // for new Message;
use App\Events\MessageSent; // for MessageSent::dispatch()

class MessageController extends Controller
{

    public function index(Request $request)
    {
        if (!isset($matchingUserId)) {
            $matchingUserId = $request->input('matchingUserId');
            $request->session()->put('matchingUserId', $request->input('matchingUserId'));
        } else {
            $matchingUserId = $request->session()->get('matchingUserId');
        }
        $request->session()->put('matchingUserId', $request->input('matchingUserId'));
        // $matchingUserId = $request->input('matchingUserId');
        // $matchingUserData = User::where('id', $matchingUserId)->first();
        // $matchingUserId = intval($matchingUserId);


        $comments = Comment::get();

        // $matchingUserUrlId = $request->matchingUserId;

        $mathcedUsers = Swipe::where('from_user_id', Auth::user()->id)->where('to_user_id', $matchingUserId)->where('is_like', true)->first();


        if (!is_null($mathcedUsers)) {
            return view('pages.message.index', [ //マッチしている人とのチャット画面
                'matchingUserId' => $matchingUserId,
                'comments' => $comments,
            ]);
        } else {
            return 'マッチしている相手ではありません。'; //マッチしていない人へのアクセス=>警告表示
        }
    }


    // メッセージ送信時の処理
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $comment = $request->input('comment');
        $matchingUserId = $request->session()->get('matchingUserId');
        Comment::create([
            'login_id' => $user->id,
            'name' => $user->name,
            'comment' => $comment
        ]);
        // return redirect()->route('message.index');
        return view('pages.message.index', [
            'matchingUserId' => $matchingUserId,
        ]);


        // pusherではなく、データベースで試みたスクリプト
        // // リクエストからデータの取り出し
        // $strMessage = $request->input('message');

        // $chat = new Chat;

        // $chat->fromId = 1;
        // $chat->toId = 2;
        // $chat->message = $strMessage;

        // $chat->save();

        // return view("pages.message.index", );



        // ここではpusherによるリアルタイムチャットシステム
        // リクエストからデータの取り出し
        // $strName = Auth::user()->name;
        // $strMessage = $request->input('message');

        // // メッセージオブジェクトの作成
        // $message = new Message;
        // $message->name = $strName;
        // $message->body = $strMessage;


        // 送信者を含めてメッセージを送信
        // MessageSent::dispatch($message);    // Laravel V8以降の書き方

        // return $request;
    }

    public function getData()
    {
        $comments = Comment::orderBy('created_at', 'desc')->get();
        $json = ["comments" => $comments];
        return response()->json($json);
    }
}
