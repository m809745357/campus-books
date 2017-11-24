@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <demand-edit :attributes="{{ $demand }}"></demand-edit>
    </div>
</div>
@endsection
