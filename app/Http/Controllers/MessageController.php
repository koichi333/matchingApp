<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Swipe;

use Illuminate\Support\Facades\Auth;

use App\Library\Message;   // for new Message;
use App\Events\MessageSent; // for MessageSent::dispatch()

class MessageController extends Controller
{
    public function index(Request $request)
    {

        $matchingUserId = $request->input('matchingUserId');
        $matchingUserData = User::where('id', $matchingUserId)->first();
        $matchingUserId = intval($matchingUserId);

        // $matchingUserUrlId = $request->matchingUserId;

        $mathcedUsers = Swipe::where('from_user_id', Auth::user()->id)->where('to_user_id', $matchingUserId)->where('is_like', true)->first();


        if(!is_null($mathcedUsers)){
            return view('pages.message.index', [ //マッチしている人とのチャット画面
                'matchingUser' => $matchingUserData,
            ]);
        } else {
            return 'マッチしている相手ではありません。'; //マッチしていない人へのアクセス=>警告表示
        }
    }


    // メッセージ送信時の処理
    public function sendMessage( Request $request )
    {
        // リクエストからデータの取り出し
        $strMessage = $request->input('message');

        // メッセージオブジェクトの作成
        $message = new Message;
        $message->body = $strMessage;

        // 送信者を含めてメッセージを送信
        //event( new MessageSent( $message ) ); // Laravel V7までの書き方
        MessageSent::dispatch($message);    // Laravel V8以降の書き方

        // 送信者を除いて他者にメッセージを送信
        // Note : toOthersメソッドを呼び出すには、
        //        イベントでIlluminate\Broadcasting\InteractsWithSocketsトレイトをuseする必要がある。
        //broadcast( new MessageSent($message))->toOthers();

        //return ['message' => $strMessage];
        return $request;
    }
}
