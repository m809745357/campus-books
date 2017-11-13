@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="balances">
            <img src="/images/balances-top.png" alt="">
            <h4>我的余额</h4>
            <p>￥ {{ $balances }}</p>
            <a class="recharge" href="/recharges">充值</a>
            <a class="withdraw" href="/withdraws">提现</a>
        </div>
    </div>
    @include('users.menu')
</div>
@endsection
