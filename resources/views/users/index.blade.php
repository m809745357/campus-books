@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <users-profile></users-profile>
        @include('users.menu')
    </div>
</div>
@endsection
