@extends('admin.main')

@section('content')

@section('content_header')
<h1>Gmail Integration</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
  </li>
  <li>Integrations</li>
  <li class="active">Gmail Integration</li>
</ol>
@endsection

<section class="content">
  <div class="col-xs-12">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>

    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
      <ul>
        <li>{{ session('success') }}</li>
      </ul>
    </div>
    @endif
  </div>
  <div class="col-sm-6" id="tab_email">
    <form id="imap_credentials" >
      <div class="box-header with-border border-top ">
        <h3 class="box-title">Imap Credentials</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label">Email Address</label>
            <div class="col-sm-6">
              {!! Form::input('email','gmail_email',$gmail['imap_email'], ['placeholder'=>"Email",'class'=>"form-control"]) !!}
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label">Gmail Password</label>
            <div class="col-sm-6">
              {!! Form::input('password','gmail_password',$gmail['imap_password'], ['placeholder'=>"Gmail Password",'class'=>"form-control"]) !!}
            </div>
          </div>
        </div>

           {{--  <div class="form-group pull-right">
              <button class="btn-md btn btn-primary s btn-block" id="imap_update">Update</button>
            </div> --}}
          </div><!-- /.box-body -->

          <div class="box-header with-border border-top ">
            <h3 class="box-title">Gmail SMTP</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-sm-4 control-label">Server Address</label>
                <div class="col-sm-6">
                  {!! Form::input('text','server_address',$gmail['server_address'], ['placeholder'=>"Server address",'class'=>"form-control"]) !!}
                </div>
                <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
              </div>

              <div class="form-group">
                <label class="col-sm-4 control-label">Gmail Address</label>
                <div class="col-sm-6">
                  {!! Form::input('text','smtp_address',$gmail['gmail_address'], ['placeholder'=>"Gmail Address",'class'=>"form-control"]) !!}
                </div>
                <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Gmail Password</label>
                <div class="col-sm-6">
                  {!! Form::input('password','smtp_password',$gmail['password'], ['placeholder'=>"Gmail Password",'class'=>"form-control"]) !!}
                </div>
                <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Port</label>
                <div class="col-sm-6">
                  {!! Form::input('text','smtp_port',$gmail['port'], ['placeholder'=>"Port",'class'=>"form-control"]) !!}
                  <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                </div>
              </div>
            </div>
            

           {{--  <div class="form-group pull-right">
              <button  class="btn btn-md btn-primary  btn-block  " id="smtp_update">Update</button>
            </div> --}}



          </div>
        </form>
        <div class="col-sm-12 divider"></div>
        <div class="col-sm-2"></div>
        <div class="col-sm-4 noleftpad"><button class="btn btn-primary"  id="imap_smtp_update">Update</button></div>
      </div>
      <div class="col-sm-6">
        <div class="box-header with-border border-top ">
          <h3 class="box-title">Gmail API credentials</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="err_gmail_api"></div>
          <form class="form-horizontal"  id="gmail_api_credentials">
            <div class="form-group">
              <label class="col-sm-4 control-label">Client ID</label>
              <div class="col-sm-6">
                {!! Form::input('text','gmail_auth_client_id',$gmail['gmail_auth_client_id'], ['placeholder'=>"Client ID",'class'=>"form-control",'id'=>'gmail_auth_client_id']) !!}
              </div>
              <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">Client Secret</label>
              <div class="col-sm-6">
                {!! Form::input('text','gmail_auth_client_secret',$gmail['gmail_auth_client_secret'], ['placeholder'=>"Client Secret",'class'=>"form-control",'id'=>'gmail_auth_client_secret']) !!}
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Redirect URI</label>
              <div class="col-sm-6">
                {!! Form::input('text','redirect_uri',$gmail['redirect_uri'], ['placeholder'=>"Redirect URI",'class'=>"form-control",'id'=>'redirect_uri']) !!}
              </div>
            </div>

          </form>

        </div>

        <div class="col-sm-12 divider"></div>
        <div class="col-sm-2"></div>
        <div class="col-sm-4 noleftpad"><button class="btn btn-primary"  id="gmail_api_update">Update</button></div>
      </div>
      <div class="clear-fix"></div>
    </section>

    @include('crm::settings.integrations.zoho_reset_token_modal_ajax')
    @endsection
    @section('script')
    <script type="text/javascript">

      function slack_authorize()
      {
        $.ajax({
          url: "{{ URL::route('admin.setting.crm.slack_token_request')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'GET',
          dataType: 'json',
          data: $('#gmail_api_credentials').serialize(),
          success: function(response){
            popupwindow(response.url,'api',800,400);
          }
        });

      }

      function popupwindow(url, title, w, h) {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
      }
    </script>
    @endsection

    @section('document.ready')
    @parent


    $('#imap_smtp_update').click(function() {

    $.ajax({
    url: "{{ URL::route('admin.setting.crm.integration.smtp_store')}}",
    //headers: {'X-CSRF-TOKEN': token},
    type: 'POST',
    dataType: 'json',
    data: $('#imap_credentials').serialize(),
    success: function(response){
    if(response.success)
    {

    $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_email');

    $.get('{{URL::route("admin.setting.crm.integration.smtp")}}',function(response ) {
    //$('#tab_email_signature').html(response);
    $('#imap_credentials').find('input[name="server_address"]').val(response.server_address);
    $('#imap_credentials').find('input[name="smtp_address"]').val(response.gmail_address);
    $('#imap_credentials').find('input[name="smtp_password"]').val(response.password);
    $('#imap_credentials').find('input[name="smtp_port"]').val(response.port);
    $('#imap_credentials').find('input[name="gmail_email"]').val(response.imap_email);
    $('#imap_credentials').find('input[name="gmail_password"]').val(response.imap_password);
  },"json"
  );

  alert_hide();
}

}

});

});


$('#gmail_api_update').click(function() {
$('#err_gmail_api').html('');
$.ajax({
url: "{{ URL::route('admin.setting.crm.integration.gmail_api_update')}}",
//headers: {'X-CSRF-TOKEN': token},
type: 'POST',
dataType: 'json',
data: $('#gmail_api_credentials').serialize(),
success: function(response){

//console.log(response.gmail.auth_url);
popupwindow(response.gmail.auth_url,'api',600,400);

//console.log(response.gmail.auth_url);
if(response.success)
{

  //wins
  $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_gmail_integration');



  alert_hide();
}
$.get('{{URL::route("admin.setting.crm.integration.google_auth")}}',function(response ) {
$('#gmail_api_credentials').find('input[name="gmail_auth_client_id"]').val(response.gmail_auth_client_id);
$('#gmail_api_credentials').find('input[name="gmail_auth_client_secret"]').val(response.gmail_auth_client_secret);
$('#gmail_api_credentials').find('input[name="redirect_uri"]').val(response.redirect_uri);

});

},
error: function(data){
var errors = data.responseJSON;
//console.log(errors);
var html_error = '<div  class="alert alert-danger"><ul>';
$.each(errors, function (key, value)
{
  html_error +='<li>'+value+'</li>';
})
html_error += "</ul></div>";
$('#err_gmail_api').html(html_error);
//$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();

// Render the errors with js ...
alert_hide();
}
});

});



@endsection
@section('styles')
@parent

<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />

<style>
  .divider {
    position: relative;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 25px;
    margin-top: 10px;
  }
  .noleftpad {
    padding-left: 5px;
  }
</style>
@endsection
