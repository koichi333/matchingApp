@extends('layouts.app')

@section('content')
<h1>Chat app</h1>


<div>ダイレクトメッセージ画面</div>
<img src="{{ $matchingUser->img_url }}" alt="マッチング相手の画像">

<ul id="list_message">
</ul>


{{-- エンターキーによるボタン押下を行うために、
<button type="button">ではなく、<form>と<button type="submit">を使用。
ボタン押下(=submit)時にページリロードが行われないように、
onsubmitの設定の最後に"return false;"を追加。
(return false;の結果として、submitが中断され、ページリロードは行われない。）--}}
<form method="post" action="" onsubmit="onsubmit_Form(); return false;">
    メッセージ : <input type="text" id="input_message" autocomplete="off" />
    <button type="submit">送信</button>
</form>


<script>
    const elementInputMessage = document.getElementById( "input_message" );
    

    {{-- formのsubmit処理 --}}
    function onsubmit_Form()
    {
        {{-- 送信用テキストHTML要素からメッセージ文字列の取得 --}}
        let strMessage = elementInputMessage.value;
        if( !strMessage )
        {
            return;
        }

        params = {'message': strMessage,};

        {{-- POSTリクエスト送信処理とレスポンス取得処理 --}}
        axios
            .post( '', params )
            .then( response => {
                console.log(response);
            } )
            .catch(error => {
                console.log(error.response)
            } );

        {{-- テキストHTML要素の中身のクリア --}}
        elementInputMessage.value = "";
    }

    {{-- ページ読み込み後の処理 --}}
        window.addEventListener( "DOMContentLoaded", ()=>
        {
            const elementListMessage = document.getElementById( "list_message" );

            {{-- Listen開始と、イベント発生時の処理の定義 --}}
            window.Echo.channel('matching-chat-app').listen( 'MessageSent', (e) =>
            {
                console.log(e);
                {{-- メッセージの整形 --}}
                let strMessage = e.message.body;

                {{-- 拡散されたメッセージをメッセージリストに追加 --}}
                let elementLi = document.createElement( "li" );
                let elementMessage = document.createElement( "div" );
                elementMessage.textContent = strMessage;
                elementLi.append( elementMessage );
                // elementListMessage.prepend( elementLi );  // リストの一番上に追加
                elementListMessage.append( elementLi ); // リストの一番下に追加
            });
        } );
</script>



@endsection
