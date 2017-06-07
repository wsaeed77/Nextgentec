@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
         Add Asset
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
         <li >
           <a href="{{ URL::route('admin.assets.index')}}"> <i class="fa fa-table"></i> Assests</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Add Assest
        </li>
    </ol>
@endsection



<section class="content">
    <div class="row">

        <div class="col-xs-12">

             <div id="err_msgs"></div>



           <div class="clearfix"></div>
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title ">Asset Detail</h3>
                </div>


                <form id="asset_form">
                 <div class="box-body">
                   <div class="form-group col-lg-6">
                        <label>Name</label>
                        {!! Form::input('text','name',null, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
                    </div>

                            <div class="form-group col-lg-6">
                              <label>Customer</label>
                             <?php if ((session('cust_id')!='') && (session('customer_name')!='')) {
                                  $selected_cust = session('cust_id');?>
                                  {!! Form::text('customername', session('customer_name'), ['class' => 'form-control', 'readonly' => 'true']) !!}
                                  {!! Form::hidden('customer', $selected_cust) !!}

                             <?php } else { ?>
                                        {!! Form::select('customer', $customers, '',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','onChange'=>'load_service_items(this.value)'])!!}
                                <?php } ?>

                            </div>

                            <div class="form-group col-lg-6">
                              <label>Location</label>
                                <?php $locations = [];?>
                             {!! Form::select('location', $locations,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Location', 'id'=>'locations'])!!}
                            </div>

                                <?php $asset_types = ['network'=>'Network',
                                                    'gateway' => 'Gateway',
                                                    'pbx'=>'PBX',
                                                    'server'=>'Server'];?>
                             <div class="form-group col-lg-6">
                              <label>Asset Type</label>

                             {!! Form::select('asset_type', $asset_types,null,['class'=>'form-control multiselect','placeholder' => 'Pick Asset Type','onChange'=>'change_asset_view(this.value)'])!!}
                            </div>

                    <div class="clearfix"></div>
                   </div>

                    <div class="box-header with-border top-border bot_10px">
                      <h3 class="box-title">Asset Detail</h3>
                    </div>

                    <div class="box-body" >
                    <div id="target_div">
                    </div>

                    </div>

                    </form>

                    <div class="form-group col-lg-6 pull-right">
                           <button class="btn btn-lg btn-info pull-right"  id="btn_submit" onclick="submit_asset_form()">Save</button>
                        </div>
                  <div class="clearfix"></div>


                   </div>


                   <div id="network_div" style="display:none;">

                            <div class="form-group col-lg-4">
                                <label>Mac address</label>
                                {!! Form::input('text','mac',null, ['placeholder'=>"Mac Address",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Manufacture</label>
                                {!! Form::input('text','manufacture',null, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
                            </div>

                            <div class="form-group col-lg-4">
                                <label>OS</label>
                                {!! Form::input('text','os',null, ['placeholder'=>"OS",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Model</label>
                                {!! Form::input('text','model',null, ['placeholder'=>"Model",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Ip Address</label>
                                {!! Form::input('text','ip_address',null, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>User Name</label>
                                {!! Form::input('text','user_name',null, ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Password</label>
                                {!! Form::input('text','password',null, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Is Static?</label>
                                <?php $is_static = ['1'=>'Yes',
                                                    '0' =>'No'];?>
                                {!! Form::select('is_static', $is_static,'',['class'=>'form-control','placeholder' => 'Is Static?', 'id'=>'is_static','onChange'=>'show_static_type(this.value)'])!!}
                            </div>
                            <div class="form-group col-lg-4" style="display: none;" id="static_type">
                                <div class="form-group col-lg-6">
                                    <div class="radio top-18px">
                                        <label>
                                            <input type="radio" name="static_type" id="dhcp" value="dhcp" checked="">


                                                <span>DHCP</span>

                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <div class="radio top-18px">
                                        <label>
                                            <input type="radio" name="static_type" id="local" value="local" >


                                            <span>Local</span>

                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group col-lg-12">
                                <label>Notes</label>
                                {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'network_notes','rows'=>10]) !!}
                            </div>

              </div>

               <div id="gateway_div" style="display:none;">
                    <div class="form-group col-lg-4">
                        <label>Manufacture</label>
                        {!! Form::input('text','manufacture',null, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Model</label>
                        {!! Form::input('text','model',null, ['placeholder'=>"Model",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-4">
                        <label>LAN Ip Address</label>
                        {!! Form::input('text','lan_ip_address',null, ['placeholder'=>"LAN IP Address",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-4">
                        <label>WAN Ip Address</label>
                        {!! Form::input('text','wan_ip_address',null, ['placeholder'=>"WAN IP Address",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-4">
                       <label>User Name</label>
                       {!! Form::input('text','user_name',null, ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
                   </div>
                    <div class="form-group col-lg-4">
                        <label>Password</label>
                        {!! Form::input('text','password',null, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Notes</label>
                        {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'gateway_notes','rows'=>10]) !!}
                    </div>
              </div>


              <div id="pbx_div" style="display:none;">
                            <div class="form-group col-lg-4">
                                <label>Manufacture</label>
                                {!! Form::input('text','manufacture',null, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
                            </div>
                             <div class="form-group col-lg-4">
                                <label>OS</label>
                                {!! Form::input('text','os',null, ['placeholder'=>"OS",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Host name</label>
                                {!! Form::input('text','host_name',null, ['placeholder'=>"Host Name",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Admin GUI Address</label>
                                {!! Form::input('text','admin_gui_address',null, ['placeholder'=>"Admin GUI Address",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Ip Address</label>
                                {!! Form::input('text','ip_address',null, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
                            </div>
                             <div class="form-group col-lg-4">
                                <label>User Name</label>
                                {!! Form::input('text','user_name',null, ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Password</label>
                                {!! Form::input('text','password',null, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Hosted/Onsite</label>
                                {!! Form::input('text','hosted',null, ['placeholder'=>"Hosted/Onsite",'class'=>"form-control"]) !!}
                            </div>
              </div>

              <div id="server_div" style="display:none;">
                           <div class="form-group col-lg-4">
                                <label>Type</label>
                                <?php $server_type = ['physical'=>'Physical',
                                                    'virtual' =>'Virtual'];?>
                                {!! Form::select('server_type', $server_type,'',['class'=>'form-control','placeholder' => 'Server Type', 'id'=>'server_type','onChange'=>'change_server_type(this.value)'])!!}
                            </div>

                             <div class="form-group col-lg-4" id="virtual_types" style="display:none">
                                <label>Virtual Type?</label>
                            
                                {!! Form::select('virtual_type', $asset_v_types,'',['class'=>'form-control','placeholder' => 'Virtual Server Type', 'id'=>'virtual_server_type'])!!}
                            </div>


                            <div class="form-group col-lg-4">
                                <label>Ip Address</label>
                                {!! Form::input('text','ip_address',null, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
                            </div>


                            <div class="form-group col-lg-3">
                                <label>Host Name</label>
                                {!! Form::input('text','host_name',null, ['placeholder'=>"Host Name",'class'=>"form-control"]) !!}
                            </div>

                             <div class="form-group col-lg-4">
                                <label>User Name</label>
                                {!! Form::input('text','user_name',null, ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Password</label>
                                {!! Form::input('text','password',null, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
                            </div>

                           <div class="form-group col-lg-11">
                            <label>Roles</label>
                           

                                 {!! Form::select('roles[]', $asset_roles,'',['class'=>'select2','multiple'=>'','style'=>"width: 100%;"])!!}

                            </div>


                            <div class="form-group col-lg-12">
                                <label>Notes</label>
                                {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'server_notes','rows'=>10]) !!}
                            </div>


              </div>


            </div>
        </div>
    </div>
</section>


@endsection
@section('script')

{{--  <script src="/js/bootstrap3-wysihtml5.all.min.js"></script>
  <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script>--}}
   <script src="/vendor/summernote/summernote.js"></script>
<script src="/vendor/summernote/summernote-floats-bs.min.js"></script>
    <script src="/js/select2.full.min.js"></script>


<script type="text/javascript">

$(document).ready(function()
    {

      

        $('.datepicker').datepicker();

    <?php if ((session('cust_id')!='') && (session('customer_name')!='')) {?>

     load_service_items(<?php echo session('cust_id');?>);

    <?php } ?>



    });

 @include('assets::ajax_functions')
function load_service_items(c_id)
{

  $.get('/admin/crm/ticket/ajax_get_service_items/'+c_id,function(response ) {

$('#locations').html('<option value="">Pick a Location</option>');

                 var locations = response.locations;
                 $.each(locations,function(index, location) {
                        //console.log(el);
                    $('#locations').append($("<option></option>")
                             .attr("value",location.id)
                             .text( location.location_name));

                });

                $('#locations').multiselect('rebuild');


                },"json"
              );
}


</script>
@endsection
@section('styles')
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"> --}}
  <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">
 <link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">
<style>
    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
    .top-18px{
        top: 18px;
    }
    .bot_10px{
        margin-bottom: 10px;
    }

    .relative{
        position: relative;
    }
    .left-15px{
        left: 15px;
    }

</style>
@endsection
