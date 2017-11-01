@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <demand-detail :attributes="{{ $demand }}"></demand-detail>
    </div>
    {{-- @include('posts.menu') --}}
</div>
@endsection
