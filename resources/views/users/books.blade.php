@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="hot-books">
            <div class="books-desc">
                @foreach ($books as $book)
                    <book :attributes="{{ $book }}"></book>
                @endforeach
            </div>
        </div>
    </div>
    @include('users.menu')
</div>
@endsection
