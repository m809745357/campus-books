@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <demand-list :attributes="{{ $demands }}"></demand-list>
    </div>
    @include('posts.menu')
</div>
@endsection
