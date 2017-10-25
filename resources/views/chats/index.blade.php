@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <chat :to-user="{{ $user }}" :attributes="{{ $notifications }}"></chat>
    </div>
</div>
@endsection
