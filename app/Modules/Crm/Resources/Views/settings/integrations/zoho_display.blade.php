@extends('admin.main')


@section('content')

@section('content_header')
<h1>Zoho Invoices</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
  </li>
  <li>Integrations</li>
  <li class="active">Zoho Invoices</li>
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
     <a href="javascript:;" data-target="#modal-reset"  data-id="" data-toggle="modal" class="btn btn-sm btn-primary pull-right">Reset Auth Token</a>
    </div>
  </div>



<form id="edit_zoho_form" class="form-horizontal">
  <div class="form-group">
    <label for="date_format" class="col-sm-2 control-label">Zoho Email</label>
    <div class="col-sm-4">
       {!! Form::input('text','email',$zoho_arr['email'], ['placeholder'=>"Zoho Email",'class'=>"form-control"]) !!}
    </div>
  </div>
  <div class="form-group">
    <label for="time_format" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-4">
     {!! Form::input('password','password',$zoho_arr['password'], ['placeholder'=>"Password",'class'=>"form-control"]) !!}
    </div>
  </div>
  <div class="form-group">
    <label for="time_zone" class="col-sm-2 control-label">Auth Token</label>
    <div class="col-sm-4">
     {!! Form::input('text','token',$zoho_arr['auth_token'], ['placeholder'=>"Auth token",'class'=>"form-control"]) !!}
    </div>
  </div>


</form>

<div class="col-sm-12 divider"></div>
<div class="col-sm-2"></div>
<div class="col-sm-4 noleftpad"><button class="btn btn-primary " id="edit_zoho">Update</button></div>


</section>

@include('crm::settings.integrations.zoho_reset_token_modal_ajax')
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

$('#edit_zoho').click(function() {
    $.ajax({
        url: "{{ URL::route('admin.setting.crm.integration.zoho_store')}}",
       
        type: 'POST',
        dataType: 'json',
        data: $('#edit_zoho_form').serialize(),
        success: function(response){
        if(response.success)
        {

         
              $('#edit_zoho').html('Saved');
              $('#edit_zoho').toggleClass('btn-primary btn-success');
              setTimeout(function() {
                $('#edit_zoho').toggleClass('btn-primary btn-success');
                $('#edit_zoho').html('Update');
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
