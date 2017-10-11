@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <thread-channels :attributes="{{ $channels }}"></thread-channels>
    </div>
    @include('threads.menu')
</div>
@endsection
