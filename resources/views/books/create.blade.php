@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <book-new :attributes="{{ $categories }}"></book-new>
    </div>
</div>
@endsection
