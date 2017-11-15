@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="demands-menu con">
            @if (request()->time == 'desc')
                <li><a href="/demands?time=asc{{ request()->search ? "&search=" . request()->search : ''}}">时间 ↓</a></li>
            @else
                <li><a href="/demands?time=desc{{ request()->search ? "&search=" . request()->search : ''}}">时间 ↑</a></li>
            @endif
        </div>
        <div class="demands">
            <div class="demands-desc">
                @foreach ($demands as $demand)
                    <demand :attributes="{{ $demand }}"></demand>
                @endforeach
            </div>
        </div>
    </div>
    @include('posts.menu')
</div>
@endsection
