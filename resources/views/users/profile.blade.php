@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row top">
        <div class="user-profile-item" style="height: 1.87rem !important">
            <h4>头像</h4>
            <p><img src="https://lorempixel.com/50/50/?43531" alt=""></p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>昵称</h4>
            <p>沈一飞</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>学校</h4>
            <p>浙江工贸职业技术学院</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>专业</h4>
            <p>软件技术</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>手机</h4>
            <p>18367831980</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item border-none">
            <h4>管理收货地址</h4>
            <p></p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        @include('users.menu')
    </div>
</div>
@endsection
