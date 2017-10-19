@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="demands-menu con">
            <li><a href="">时间 v</a></li>
        </div>
        <div class="demands">
            <div class="demands-desc">
                @foreach ($demands as $demand)
                    <div class="demands-item" onclick="location.href='{{ $demand->path() }}'">
                        <img src="{{ json_decode($demand->images)[0] }}" alt="">
                        <h4>{{ $demand->title }}</h4>
                        <p>￥ {{ $demand->money }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('posts.menu')
</div>
@endsection
