@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-header">
            <div class="thread-create">
                <a href="{{ route('threads.create') }}">
                    <img src="/images/replay.png" alt="">
                    提问
                </a>
            </div>
            <div class="thread-menu">
                <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
            </div>
        </div>
        @foreach ($threads as $thread)
            <thread :attributes="{{ $thread }}"></thread>
        @endforeach
    </div>
</div>
@endsection
