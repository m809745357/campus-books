@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-menu">
            <li><a
                class="{{ request()->query('type') == null ? 'on' : '' }}"
                href="{{ request()->url() }}{{ request()->query('by') ? 'by=' . request()->query('by') : '' }}">
                书籍
                </a>
            </li>
            <li><a
                class="{{ request()->query('type') == 'thread' ? 'on' : '' }}"
                href="{{ request()->url() }}?{{ request()->query('by') ? 'by=' . request()->query('by') . '&' : '' }}type=thread">
                问答
                </a>
            </li>
        </div>
        @foreach ($favorites as $favorite)
            <thread :attributes="{{ $favorite->favorited }}"></thread>
        @endforeach
    </div>
    @include('users.menu')
</div>
@endsection
