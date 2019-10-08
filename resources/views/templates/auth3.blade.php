<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    
    <link rel="stylesheet" href="{{asset('fontawsome.5.10.1/releases/v5.10.1/css/pro.min.css')}}">

    @if(App::isLocale('fa'))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css" rel="stylesheet">
    @endif

    @yield('css')
    
    <link rel="stylesheet" href="{{asset('assets3/css/argon.min.css?v=1.1.0')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets3/css/admin3.css')}}" type="text/css">

    @if(App::isLocale('fa'))
    <link rel="stylesheet" href="{{asset('assets3/css/admin3_rtl.css')}}" type="text/css">
    @endif

    <link href="<?=asset('css/admin_auth3.css');?>" rel="stylesheet" />
</head>
<body class="{{App::isLocale('fa')?'rtl':''}}">

    @yield('content')

    <script src="{{asset('assets3/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/js-cookie/js.cookie.js')}}"></script>
    <script src="{{asset('assets3/js/argon.min.js?v=1.1.0')}}"></script>
    <script src="{{asset('assets3/js/admin3.js')}}"></script>
    @yield('javascript')
</body>
</html>
