@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($threads as $thread)
            <thread :attributes="{{ $thread }}"></thread>
        @endforeach
    </div>
</div>
@endsection
