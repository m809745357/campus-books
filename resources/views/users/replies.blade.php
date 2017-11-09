@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-menu">
            <li onclick="window.location.href='{{ route('user.threads') }}'">提问</li>
            <li class="on" onclick="window.location.href='{{ route('user.replies') }}'">回答</li>
        </div>
        @foreach ($replies as $reply)
            <reply :attributes="{{ $reply }}" :thread="{{ $reply->thread }}"></reply>
        @endforeach
    </div>
    @include('users.menu')
</div>
@endsection
