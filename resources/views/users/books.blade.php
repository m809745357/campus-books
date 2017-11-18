@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (! empty($books->toArray()))
            <div class="hot-books">
                <div class="books-desc">
                    @foreach ($books as $book)
                        <book :attributes="{{ $book }}"></book>
                    @endforeach
                </div>
            </div>
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
