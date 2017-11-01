@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="posts-panel" onclick="window.location.href='/demands/create'">
            <img src="/images/gou.png" alt="" class="posts-panel-img">
            <div class="posts-panel-desc">
                <h4>发布求购</h4>
                <p>寻找你想要的书籍</p>
            </div>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="posts-panel" onclick="window.location.href='/books/create'">
            <img src="/images/book.png" alt="" class="posts-panel-img">
            <div class="posts-panel-desc">
                <h4>发布书籍</h4>
                <p>寻找你想卖的书籍</p>
            </div>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
    </div>
    @include('posts.menu')
</div>
@endsection
