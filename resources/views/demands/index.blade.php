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
                    <demand :attributes="{{ $demand }}"></demand>
                @endforeach
            </div>
        </div>
    </div>
    @include('posts.menu')
</div>
@endsection
