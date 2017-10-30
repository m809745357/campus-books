@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="books">
            {{ $books }}
        </div>
    </div>
    @include('users.menu')
</div>
@endsection
