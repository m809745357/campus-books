@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-menu">
            <li class="on" onclick="window.location.href='{{ route('user.threads') }}'">提问</li>
            <li onclick="window.location.href='{{ route('user.replies') }}'">回答</li>
        </div>
        @if (! empty($threads->toArray()))
            @foreach ($threads as $thread)
                <thread :attributes="{{ $thread }}"></thread>
            @endforeach
        @else
            <div class="none">
                <img src="/images/none.png" alt="">
                <span>暂无记录</span>
            </div>
        @endif
    </div>
    @include('users.menu')
</div>
@endsection
