@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <recharges :attributes="{{ $recharges }}"></recharges>
    </div>
    @include('users.menu')
</div>
@endsection
