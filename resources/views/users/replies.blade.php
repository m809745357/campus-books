@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-menu">
            <li><a href="{{ route('user.threads') }}">提问</a></li>
            <li><a class="on" href="{{ route('user.replies') }}">回答</a></li>
        </div>
        @foreach ($replies as $reply)
            <reply :attributes="{{ $reply }}" :thread="{{ $reply->thread }}"></reply>
        @endforeach
    </div>
    @include('users.menu')
</div>
@endsection
