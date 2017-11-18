@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-menu">
            <li onclick="window.location.href='{{ route('user.favorites.book') }}'">书籍</li>
            <li class="on" onclick="window.location.href='{{ route('user.favorites.thread') }}'">问答</li>
        </div>
        @if (! empty($favorites->toArray()))
            @foreach ($favorites as $favorite)
                <thread :attributes="{{ $favorite->favorited }}"></thread>
            @endforeach
        @else
            <div class="none">
                <img src="/images/none.png" alt="">
                <span>暂无记录</span>
            </div>
        @endif
    </div>
    @include('users.menu')
</div>
@endsection
