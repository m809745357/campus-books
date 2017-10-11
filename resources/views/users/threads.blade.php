@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-menu">
            <li><a class="on" href="{{ route('user.threads') }}">提问</a></li>
            <li><a href="{{ route('user.replies') }}">回答</a></li>
        </div>
        @foreach ($threads as $thread)
            <thread :attributes="{{ $thread }}"></thread>
        @endforeach
    </div>
    @include('users.menu')
</div>
@endsection
