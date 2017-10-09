@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="thread-header">
            <div class="thread-create">
                <a href="{{ route('threads.create') }}">
                    <img src="/images/reply-create.png" height="18px">
                    提问
                </a>
            </div>
            <div class="thread-channel">
                <a href="{{ route('threads.channels') }}"><img src="/images/reply-menu.png" alt=""></a>
            </div>
        </div>
        <div class="thread-menu">
            <li><a
                class="{{ request()->query('type') == null ? 'on' : '' }}"
                href="{{ request()->url() }}{{ request()->query('by') ? 'by=' . request()->query('by') : '' }}">
                全部
                </a>
            </li>
            <li><a
                class="{{ request()->query('type') == 'reward' ? 'on' : '' }}"
                href="{{ request()->url() }}?{{ request()->query('by') ? 'by=' . request()->query('by') . '&' : '' }}type=reward">
                悬赏
                </a>
            </li>
            <li><a
                class="{{ request()->query('type') == 'ordinary' ? 'on' : '' }}"
                href="{{ request()->url() }}?{{ request()->query('by') ? 'by=' . request()->query('by') . '&' : '' }}type=ordinary">
                普通
                </a>
            </li>
        </div>
        @foreach ($threads as $thread)
            <thread :attributes="{{ $thread }}"></thread>
        @endforeach
        @include('threads.menu')
    </div>
</div>
@endsection
