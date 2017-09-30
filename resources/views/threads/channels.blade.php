@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <thread-channels :attributes="{{ $channels }}"></thread-channels>
        @include('threads.menu')
    </div>
</div>
@endsection
