<!DOCTYPE html>
<html>
   <head>
   @include('admin.head')

   <link rel="stylesheet" href="{{URL::asset('css/blue.css')}}">
  </head>



    <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
          <a href="/"><b>Nex</b>gentec</a>
      </div>
       <div class="login-box-body">
        <p class="login-box-msg">Please sign in here.</p>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/admin/login" role="form">
                {!! csrf_field() !!}

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="remember" value="true"> Remember Me
                        </label>
                      </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div><!-- /.col -->
                </div>
            </form>



        {{-- <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> --}}

      </div><!-- /.login-box-body -->

      </div>


     <!-- jQuery 2.1.4 -->
    <script src="{{URL::asset('js/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{URL::asset('js/icheck.min.js')}}"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

</body>
</html>
