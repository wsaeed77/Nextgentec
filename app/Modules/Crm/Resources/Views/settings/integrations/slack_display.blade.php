@extends('admin.main')


@section('content')

@section('content_header')
<h1>Slack</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
  </li>
  <li>Integrations</li>
  <li class="active">Slack</li>
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
  <div class="row">
    <div class="col-md-12">
      <a href="javascript:;" onclick="slack_authorize();" class="btn btn-sm btn-primary pull-right">Reset Auth Token</a>
    </div>
  </div>



<form id="update_slack_form" class="form-horizontal">      
    <div class="form-group ">
        <label class="col-sm-2 control-label">Client ID</label>
            <div class="col-sm-4">
        {!! Form::input('text','client_id',$slack_arr['client_id'], ['placeholder'=>"Client ID",'class'=>"form-control"]) !!}
        </div>
    </div>

     <div class="form-group ">
        <label class="col-sm-2 control-label">Client Secret</label>
            <div class="col-sm-4">
        {!! Form::input('text','secret',$slack_arr['secret'], ['placeholder'=>"Client Secret",'class'=>"form-control"]) !!}
      </div>
    </div>
<div class="form-group ">
        <label class="col-sm-2 control-label">Channel</label>
            <div class="col-sm-4">
        {!! Form::input('text','channel',$slack_arr['channel'], ['placeholder'=>"Channel",'class'=>"form-control"]) !!}
        </div>
    </div>
     <div class="form-group ">
        <label class="col-sm-2 control-label">Redirect URI</label>
            <div class="col-sm-4">
        {!! Form::input('text','redirect_uri',$slack_arr['redirect_uri'], ['placeholder'=>"Redirect URI",'class'=>"form-control"]) !!}
        </div>
    </div>
   <div class="form-group ">
        <label class="col-sm-2 control-label">Access Token</label>
            <div class="col-sm-4">
        {!! Form::input('text','access_token',$slack_arr['access_token'], ['placeholder'=>"Access Token",'class'=>"form-control"]) !!}
        </div>
    </div>
    
</form>

<div class="col-sm-12 divider"></div>
<div class="col-sm-2"></div>
<div class="col-sm-4 noleftpad"><button class="btn btn-primary " id="edit_slack">Update</button></div>


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

$('#modal-reset').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        //var Id = $(e.relatedTarget).data('id');
 
        $.get("{{URL::route('admin.setting.crm.integration.zoho_reset_token')}}",function( response ) {

          $('#bdy').html(response.msg);

        },"json");
      });

$('#edit_slack').click(function() {
    $.ajax({
        url: "{{ URL::route('admin.setting.crm.integration.slack_store')}}",
       
        type: 'POST',
        dataType: 'json',
        data: $('#update_slack_form').serialize(),
        success: function(response){
        if(response.success)
        {

         
              $('#edit_slack').html('Saved');
              $('#edit_slack').toggleClass('btn-primary btn-success');
              setTimeout(function() {
                $('#edit_slack').toggleClass('btn-primary btn-success');
                $('#edit_slack').html('Update');
              }, 1500);
            
        }

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
