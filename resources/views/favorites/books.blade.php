@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-menu">
            <li class="on" onclick="window.location.href='{{ route('user.favorites.book') }}'">书籍</li>
            <li onclick="window.location.href='{{ route('user.favorites.thread') }}'">问答</li>
        </div>
        <div class="hot-books">
            <div class="books-desc">
                @foreach ($favorites as $favorite)
                    <book :attributes="{{ $favorite->favorited }}"></book>
                @endforeach
            </div>
        </div>
    </div>
    @include('users.menu')
</div>
@endsection
