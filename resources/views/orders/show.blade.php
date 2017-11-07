@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if ($order->book->onwer->id === auth()->id())
            <users-order-detail :attributes="{{ $order }}"></users-order-detail>
        @else
            <order-detail :attributes="{{ $order }}"></order-detail>
        @endif

    </div>
</div>
@endsection
