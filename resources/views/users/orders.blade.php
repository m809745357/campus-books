@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <users-orders :attributes="{{ $books }}"></users-orders>
    </div>
    @include('users.menu')
</div>
@endsection
