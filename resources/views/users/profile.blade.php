@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row top">
        <users-profile-items :attributes="{{ $user }}"></users-profile-items>
    </div>
    @include('users.menu')
</div>
@endsection
