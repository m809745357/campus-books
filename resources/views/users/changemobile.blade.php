@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <users-change-mobile :attributes="{{ $user }}"></users-change-mobile>
    </div>
</div>
@endsection
