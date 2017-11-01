@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="demand-detail">
            <div class="demand-detail-desc">
                <div class="demand-detail-gallery">
                    @foreach ($demand->images as $image)
                        <img src="{{ $image }}" alt="">
                    @endforeach
                </div>
                <div class="demand-detail-title">
                    <h4>{{ $demand->title }}{{ $demand->title }}{{ $demand->title }}</h4>
                </div>
                <div class="demand-money" style="margin: 0.4rem 0.4rem 0 0.4rem;">
                    ￥ {{ $demand->money}}
                </div>
                <div class="demand-footer">
                    <p>发布时间：{{ $demand->created_at }}</p>
                    <div class="demand-footer-img">
                        <img src="{{ $demand->onwer->avatar }}" alt="">
                    </div>
                    <span>{{ $demand->onwer->nickname }}</span>
                </div>
            </div>
            <div class="demand-body">
                <div class="demand-body-title">
                    <h4>求购信息</h4>
                </div>
                <div class="demand-body-content">
                    {{ $demand->body }}
                </div>
            </div>

            <div class="demand-contact-button con">
                <button type="button" name="button">在线联系</button>
            </div>
        </div>
    </div>
    {{-- @include('posts.menu') --}}
</div>
@endsection
