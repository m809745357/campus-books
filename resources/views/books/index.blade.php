@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="books-menu con">
            <li><a href="">新品 v</a></li>
            <li><a href="">销量 v</a></li>
            <li><a href="">价格 v</a></li>
        </div>
        <div class="books">
            <div class="books-desc">
                @foreach ($books as $book)
                    <div class="books-item" onclick="location.href='{{ $book->path() }}'">
                        <img src="{{ json_decode($book->images)[0] }}" alt="">
                        <h4>{{ $book->title }}</h4>
                        <p class="author">作者： {{ $book->author }}</p>
                        <p class="press">出版社： {{ $book->press }}</p>
                        <div class="keywords">
                            @foreach (json_decode($book->keywords) as $keyword)
                                <span>{{ $keyword }}</span>
                            @endforeach
                        </div>
                        <p class="price">￥ {{ $book->money }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('posts.menu')
</div>
@endsection
