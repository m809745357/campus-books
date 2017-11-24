<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '校园平台') }}</title>

    <script>
        window.App = <?php echo json_encode([
             'user' => Auth::user() ? Auth::user()->append('notification_count') : null,
             'signedIn' => Auth::check(),
             'wxconfig' => app()->environment('testing') ? '' : $js->config(array(
                 'onMenuShareTimeline',
                 'onMenuShareAppMessage',
                 'onMenuShareQQ',
                 'onMenuShareWeibo',
                 'onMenuShareQZone',
             ), false)
        ]); ?>
    </script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @yield('content')
        <flash message="{{ session('flash') }}"></flash>

    </div>
        {{-- @if (config('app.debug'))
            @include('sudosu::user-selector')
        @endif --}}
    <!-- Scripts -->
    <script src="//{{ Request::getHost() }}:6002/socket.io/socket.io.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
