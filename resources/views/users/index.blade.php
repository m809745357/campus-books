@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <users-profile></users-profile>
    </div>
    @include('users.menu')
</div>
@endsection
