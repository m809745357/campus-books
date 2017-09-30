@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <thread-reply :attributes="{{ $thread }}"></thread-reply>
        @include('threads.menu')
    </div>
</div>
@endsection
