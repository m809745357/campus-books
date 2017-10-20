@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="bills">
            <div class="bills-balances">
                <img src="/images/price.png" alt=""><h4>可用余额：￥ {{ auth()->user()->balances }}</h4>
            </div>
            <div class="bills-title">
                <li>操作时间</li>
                <li>类型</li>
                <li>金额</li>
            </div>
            @foreach ($bills as $bill)
                <div class="bills-desc">
                    <li>{{ $bill->created_at->toDateString() }}</li>
                    @if ($bill->billed_type == 'App\Models\Recharge')
                        <li>充值</li>
                    @else
                        <li>{{ $bill->billed_type }}</li>
                    @endif
                    <li>￥ {{ $bill->billed->money }}</li>
                </div>
            @endforeach

        </div>
    </div>
    @include('users.menu')
</div>
@endsection
