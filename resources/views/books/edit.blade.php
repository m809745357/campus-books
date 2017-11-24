@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <book-edit :bookdetail="{{ $book }}" :attributes="{{ $categories }}"></book-edit>
    </div>
</div>
@endsection
