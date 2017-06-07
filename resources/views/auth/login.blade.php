<?php
//
//  THIS FILE IS NOT BEING USED!!!
//  Instead use resources/views/admin/login.blade.php
//
//
//
//
//

 ?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->

        <!-- <script type="text/javascript" src="{{asset('resources/assets/js/jquery.js')}}"></script> -->
        <!-- font Awesome -->

        <link href="/css/app.css" rel="stylesheet" />


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>

          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                     @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-body">

                    <form method="POST" action="/auth/login" role="form">
                        {!! csrf_field() !!}
                        <fieldset>
                            <div class="form-group">


                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                        </div>

                         <div class="form-group">

                            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                        </div>

                         <div class="form-group">
                            <input type="checkbox" name="remember" value="true"> Remember Me
                        </div>

                         <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                        </div>
                        </fieldset>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <script type="text/javascript" src="/js/app.js"></script>

</body>
</html>
