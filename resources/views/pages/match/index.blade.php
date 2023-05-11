@extends('layouts.app')

@section('content')
<div class="p-match-index">
    <div class="container">
        <div class="row">
            <h4 class="mb-2">マッチした人</h4>
            @foreach ($matchedUsers as $matchedUser)
            <form action="{{ route('message.index') }}" name="dm" method="get" class="col-md-12 mb-3">
                <input type="hidden" value="{{ $matchedUser->toUser->id }}" name="matchingUserId">
                <img src="{{ $matchedUser->toUser->img_url }}" class="rounded-circle" style="height: 70px; width: 70px; object-fit:cover">
                <a href="javascript:void(0)" onclick="document.forms['dm'].submit()" class="stretched-link ml-3">{{ $matchedUser->toUser->name }}</a>
            </form>
            @endforeach
        </div>
    </div>
</div>

@endsection
