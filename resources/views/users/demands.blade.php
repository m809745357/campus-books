@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="demands">
            <div class="demands-desc" style="margin-top: 0;padding-top: 0.4rem;">
                @foreach ($demands as $demand)
                    <demand :attributes="{{ $demand }}"></demand>
                @endforeach
            </div>
        </div>
    </div>
    @include('users.menu')
</div>
@endsection
