@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <thread-reply :attributes="{{ $thread }}"></thread-reply>
    </div>
</div>
@include('threads.menu')
@endsection
