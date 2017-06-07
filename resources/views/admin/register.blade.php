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
                        <h3 class="panel-title">Please Register</h3>
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


                        <form method="POST" action="/admin/register" role="form">
                            {!! csrf_field() !!}
                             <fieldset>
                                <div class="form-group">
                            
                              <!--  <label> Name </label> -->
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                                </div>

                             <div class="form-group"> 
                              <!--  <label> Email </label> -->
                                <input type="email" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                              <!--  <label> Password </label> -->
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>

                            <div class="form-group">
                              <!--  <label> Confirm Password </label> -->
                                <input type="password" class="form-control" placeholder="Confirm Password " name="password_confirmation">
                            </div>

                             <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-success btn-block">Register</button>
                            </div>
                             </fieldset>
                        </form>

                       <!--  <form  >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                
                               
                            
                                <input type="submit" value="Register" class="btn btn-lg btn-success btn-block">
                            </fieldset>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
  
    <script type="text/javascript" src="/js/app.js"></script> 
 
</body>
</html>