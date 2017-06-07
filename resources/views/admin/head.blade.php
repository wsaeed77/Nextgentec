    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Nexgentec">
    <title>Nexgentec</title>
    <link rel="manifest" href="manifest.json'">
   <!--  <link href="/css/app.css" rel="stylesheet" /> -->
    {{--  <link href="/css/app_inner.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-extended.css')}}">

    <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}">

    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}"> --}}
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{URL::asset('css/ionicons.min.css')}}">

<link rel="stylesheet" href="{{URL::asset('css/jquery.typeahead.css')}}">

    <link rel="stylesheet" href="{{URL::asset('css/custom_css.css')}}">
    @section('styles')
    @show

    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/skin-blue-light.css')}}">

    <link rel="stylesheet" href="{{URL::asset('css/animate.css')}}">
