@extends('admin.main')


@section('content')

@section('content_header')
 <h1>Settings</h1>

<ol class="breadcrumb">
  <li>
    <i class="fa fa-gears"></i>  <a href="/admin/settings">Settings</a>
  </li>
  <li class="active">System</li>
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


@permission('view_role_permission')

<form id="system_form" class="form-horizontal">
  <div class="form-group">
    <label for="date_format" class="col-sm-2 control-label">Date Format</label>
    <div class="col-sm-4">
      <?php $date_format = ['dd/mm/yyyy|d/m/Y'=>'dd/mm/yyyy',
                            'mm/dd/yyyy|m/d/Y'=>'mm/dd/yyyy',
                            'dd-mm-yyyy|d-m-Y'=>'dd-mm-yyyy',
                            'mm-dd-yyyy|m-d-Y'=>'mm-dd-yyyy'];?>
      {!! Form::select('date_format',$date_format,$sys_date_fmt['value'].'|'.$sys_date_fmt['key'],['class'=>'form-control multiselect','placeholder' => 'Pick a Date Format','id'=>'date_format'])!!}
    </div>
  </div>
  <div class="form-group">
    <label for="time_format" class="col-sm-2 control-label">Time Format</label>
    <div class="col-sm-4">
      <?php $time_format = ['hh:mm:ss'=>'hh:mm:ss',
                         'hh:mm:ss am/pm'=>'hh:mm:ss am/pm']; ?>
      {!! Form::select('time_format', $time_format,$global_time['value'],['class'=>'form-control multiselect','placeholder' => 'Pick a Time Format','id'=>'time_format'])!!}
    </div>
  </div>
  <div class="form-group">
    <label for="time_zone" class="col-sm-2 control-label">Time Zone</label>
    <div class="col-sm-4">
      {!! Form::select('time_zone',$time_zones,$global_time_zone,['class'=>'form-control multiselect col-lg-6','placeholder' => 'Pick a time zone'])!!}
    </div>
  </div>

  <div class="form-group">
    <label for="telephone" class="col-sm-2 control-label">Phone Format</label>
    <div class="col-sm-4">
      <?php $telephone =['(999) 999-9999'=>'(xxx) xxx-xxxx',
                          '+1(999) 999-9999'=>'+1(xxx) xxx-xxxx'];?>
      {!! Form::select('telephone', $telephone,$global_phone_number_mask,['class'=>'form-control multiselect col-lg-6','placeholder' => 'Pick a phone number format'])!!}
    </div>
  </div>
</form>

<div class="col-sm-12 divider"></div>
<div class="col-sm-2"></div>
<div class="col-sm-4 noleftpad"><button class="btn btn-primary" id="systemsave">Update</button></div>

@endpermission
</section>


@endsection
@section('script')

<script src="/DataTables/datatables.min.js"></script>
@endsection

@section('document.ready')
@parent

{{-- <script type="text/javascript"> --}}

$('#systemsave').click(function() {
  $.ajax({
    url: "{{ URL::route('admin.setting.system.save')}}",
    //headers: {'X-CSRF-TOKEN': token},
    type: 'POST',
    dataType: 'json',
    data: $('#system_form').serialize(),
    success: function(response){
      if(response.result == 'success') {
        $('#systemsave').html('Saved');
        $('#systemsave').toggleClass('btn-primary btn-success');
        setTimeout(function() {
          $('#systemsave').toggleClass('btn-primary btn-success');
          $('#systemsave').html('Update');
        }, 1500);
      }
    }
  });
});

@endsection
@section('styles')
@parent
<link rel="stylesheet" href="/DataTables/datatables.min.css">
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
