@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <notifications :attributes="{{ $notifications }}"></notifications>
    </div>
    @include('users.menu')
</div>
@endsection
