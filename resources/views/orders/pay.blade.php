@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <order-pay :attributes="{{ $order }}"></order-pay>
    </div>
</div>
@endsection
