@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <category :attributes="{{ $categories }}" :image="{{ $carousel }}"></category>
    </div>
    <div style="height: 1.32rem"></div>
    <div class="menu con">
        <li><a href="{{ route('home') }}" class="menu-item"><img src="/images/home.png" alt="">首页</a></li>
        <li><a href="{{ route('categories.index') }}" class="menu-item on"><img src="/images/category-on.png" alt="">分类</a></li>
        <li><a href="{{ route('posts.index') }}" class="menu-item post"><img src="/images/post.png" alt="">发布</a></li>
        <li><a href="{{ route('threads.index') }}" class="menu-item"><img src="/images/thread.png" alt="">问答</a></li>
        <li><a href="{{ route('user.index') }}" class="menu-item"><img src="/images/user.png" alt="">我的</a></li>
    </div>
</div>
@endsection
