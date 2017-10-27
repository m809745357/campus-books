@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <book-detail :attributes="{{ $book }}"></book-detail>
    </div>
    {{-- @include('posts.menu') --}}
</div>
@endsection
