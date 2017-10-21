@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="demand-detail">
            <div class="demand-detail-desc">
                <div class="demand-detail-gallery">
                    @foreach (json_decode($book->images) as $image)
                        <img src="{{ $image }}" alt="">
                    @endforeach
                </div>
                <div class="demand-detail-title">
                    <h4>{{ $book->title }}{{ $book->title }}{{ $book->title }}</h4>
                </div>
                <div class="book-detail keywords">
                    @foreach (json_decode($book->keywords) as $keyword)
                        <span>{{ $keyword }}</span>
                    @endforeach
                </div>
                <div class="demand-money" style="margin: 0.4rem 0.4rem 0 0.4rem;">
                    ￥ {{ $book->money}}
                </div>
                <div class="demand-footer">
                    <p>快递费：￥ {{ $book->freight }} 浏览量：{{ $book->views_count }}</p>
                    <div class="demand-footer-img">
                        <img src="{{ $book->onwer->avatar }}" alt="">
                    </div>
                    <span>{{ $book->onwer->nickname }}</span>
                </div>
            </div>
            <div class="demand-body">
                <div class="demand-body-title">
                    <h4>图文详情</h4>
                </div>
                <div class="demand-body-content">
                    {{ $book->body }}
                </div>
            </div>

            <div class="demand-contact-button con">
                <div class="book-options">
                    <div class="options">
                        <img src="/images/customer.png" alt="">
                        <p class="customer">卖家</p>
                    </div>
                    <div class="options">
                        <img src="/images/collect.png" alt="">
                        <p>收藏</p>
                    </div>
                </div>
                <button type="button" name="button">立即购买</button>
            </div>
        </div>
    </div>
    {{-- @include('posts.menu') --}}
</div>
@endsection
