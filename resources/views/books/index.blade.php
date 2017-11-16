@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <book-list :attributes="{{ $books }}"></book-list>
    </div>
    @include('posts.menu')
</div>
@endsection
