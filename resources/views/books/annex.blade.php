@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="annex">
            <img src="{{ asset($book->cover) }}" width="100%">
            @foreach ($book->images as $image)
                <img src="{{ asset($image) }}" width="100%">
            @endforeach
        </div>
    </div>
</div>
@endsection
