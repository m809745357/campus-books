@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="books-menu con">
            @if (request()->time == 'desc')
                <li><a href="/books?time=asc{{ request()->search ? "&search=" . request()->search : ''}}">新品 ↓</a></li>
            @else
                <li><a href="/books?time=desc{{ request()->search ? "&search=" . request()->search : ''}}">新品 ↑</a></li>
            @endif
            @if (request()->view == 'desc')
                <li><a href="/books?view=asc{{ request()->search ? "&search=" . request()->search : ''}}">点击量 ↓</a></li>
            @else
                <li><a href="/books?view=desc{{ request()->search ? "&search=" . request()->search : ''}}">点击量 ↑</a></li>
            @endif
            @if (request()->price == 'desc')
                <li><a href="/books?price=asc{{ request()->search ? "&search=" . request()->search : ''}}">价格 ↓</a></li>
            @else
                <li><a href="/books?price=desc{{ request()->search ? "&search=" . request()->search : ''}}">价格 ↑</a></li>
            @endif
        </div>
        <book-list :attributes="{{ $books }}"></book-list>
    </div>
    @include('posts.menu')
</div>
@endsection
