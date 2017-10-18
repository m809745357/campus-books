@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="categories">
            <div class="categories-left">
                <li class="on">教育</li>
                <li>小说</li>
                <li>文艺</li>
                <li>生活</li>
                <li>人文社科</li>
            </div>

            <div class="categories-right">
                <img src="/images/category-top.png" alt="">

                <div class="categories-desc">
                    <h4>教材</h4>
                    <div class="categories-content">
                        <li><img src="/images/categories/1.png" alt=""><h4>公共课</h4></li>
                        <li><img src="/images/categories/2.png" alt=""><h4>工学</h4></li>
                        <li><img src="/images/categories/3.png" alt=""><h4>理学学</h4></li>
                    </div>
                    <h4>外语</h4>
                    <div class="categories-content">
                        <li><img src="/images/categories/4.png" alt=""><h4>公共课</h4></li>
                        <li><img src="/images/categories/5.png" alt=""><h4>工学</h4></li>
                        <li><img src="/images/categories/6.png" alt=""><h4>理学学</h4></li>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 1.32rem"></div>
    <div class="menu con">
        <li><a href="{{ route('home') }}" class="menu-item"><img src="/images/home.png" alt="">首页</a></li>
        <li><a href="{{ route('categories.index') }}" class="menu-item"><img src="/images/category-on.png" alt="">分类</a></li>
        <li><a href="{{ route('posts.index') }}" class="menu-item post"><img src="/images/post.png" alt="">发布</a></li>
        <li><a href="{{ route('threads.index') }}" class="menu-item"><img src="/images/thread.png" alt="">问答</a></li>
        <li><a href="{{ route('user.index') }}" class="menu-item"><img src="/images/user.png" alt="">我的</a></li>
    </div>
</div>
@endsection
