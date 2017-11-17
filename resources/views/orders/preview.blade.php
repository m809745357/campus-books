@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <order-preview :attrbook="{{ $book }}"></order-preview>
    </div>
</div>
@endsection
