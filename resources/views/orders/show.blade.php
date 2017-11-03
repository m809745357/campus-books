@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <order-detail :attributes="{{ $order }}"></order-detail>
    </div>
</div>
@endsection
