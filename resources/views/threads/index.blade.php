@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <thread-list :attributes="{{ $threads }}"></thread-list>
    </div>
    @include('threads.menu')
</div>
@endsection
