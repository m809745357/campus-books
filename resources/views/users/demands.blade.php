@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (! empty($demands->toArray()))
            <div class="demands">
                <div class="demands-desc" style="margin-top: 0;padding-top: 0.4rem;">
                    @foreach ($demands as $demand)
                        <demand :attributes="{{ $demand }}"></demand>
                    @endforeach
                </div>
            </div>
        @else
            <div class="none">
                <img src="/images/none.png" alt="">
                <span>暂无记录</span>
            </div>
        @endif
    </div>
    @include('users.menu')
</div>
@endsection
