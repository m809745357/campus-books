@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row top">
        <div class="user-profile-item">
            <h4>头像</h4>
            <p><img src="{{ $user->avatar }}" alt=""></p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>昵称</h4>
            <p>{{ $user->nickname }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>学校</h4>
            <p>{{ $user->school }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>专业</h4>
            <p>{{ $user->specialty }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>手机</h4>
            <p>{{ $user->mobile }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item">
            <h4>管理收货地址</h4>
            <p></p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>

    </div>
    @include('users.menu')
</div>
@endsection
