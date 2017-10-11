@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <thread-new :attributes="{{ $channels }}"></thread-new>
    </div>
    @include('threads.menu')
</div>
@endsection
