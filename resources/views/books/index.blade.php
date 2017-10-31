@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="books-menu con">
            <li><a href="">新品 v</a></li>
            <li><a href="">销量 v</a></li>
            <li><a href="">价格 v</a></li>
        </div>
        <div class="books">
            <div class="books-desc">
                @foreach ($books as $book)
                    <book :attributes="{{ $book }}"></book>
                @endforeach
            </div>
        </div>
    </div>
    @include('posts.menu')
</div>
@endsection
