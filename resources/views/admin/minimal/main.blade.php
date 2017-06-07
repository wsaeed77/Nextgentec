<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - NexgenTec</title>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    @section('styles')
    @show
  </head>
  <body>
    <div class="container">
      @section('content')
      @show
    </div>
  </body>
</html>
