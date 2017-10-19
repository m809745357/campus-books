@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="demands">
            <div class="demands-desc" style="margin-top: 0;padding-top: 0.4rem;">
                @foreach ($demands as $demand)
                    <div class="demands-item" onclick="location.href='{{ $demand->path() }}'">
                        <img src="{{ json_decode($demand->images)[0] }}" alt="">
                        <h4>{{ $demand->title }}</h4>
                        <p>￥ {{ $demand->money }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('users.menu')
</div>
@endsection
