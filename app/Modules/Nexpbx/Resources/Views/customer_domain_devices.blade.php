@extends('admin.main')
@section('content')

@section('content_header')
<h1>
 Devices for {{$domain_name}}
 {{-- <small>preview of simple tables</small> --}}
</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
  </li>
  <li >
    <i class="fa fa-table"></i> Domains
  </li>
  <li class="active">
    <i class="fa fa-table"></i> Devices
  </li>
</ol>
@endsection
<div id="msg">@if(Session::has('status'))
  <p class="alert alert-success">{{ Session::get('status') }}</p>
  @endif</div>
  <section class="content">
    <div class="row">
      @if((session('cust_id')=='') && (session('customer_name')==''))
      <div class="col-xs-12">
        @else
        <div class="col-sm-7">
          @endif
          <div id="msg"></div>
          <div class="tab-pane active table-responsive" >
            <table class="table table-hover" id="devices_dt_table">
              <thead>
                <tr>
                  <th>Label</th>
                  <th>Mac Address</th>
                  <th>Vendor</th>
                  <th>Locaton</th>
                  <th>Device Type</th>

                </tr>
              </thead>
            </table>
          </div><!-- /.tab-pane -->
        </div>
        @if((session('cust_id')!='') && (session('customer_name')!=''))
        <div class="col-sm-5" id="device-details">
        </div>
        @endif
      </div>
      <input type="hidden" value="{{$id}}" name="device_uuid">
    </section>

    @include('admin.partials.delete_modal', [
      'id'=>'modal_device_remove',
      'message' => 'Are you sure you\'d like to remove this device?',
      'url' => 'admin.nexpbx.remove.device',
      'refresh' => false,
      'callBackFunction'=>"reload_data_table()"
      ])

      @include('assets::edit')
      @endsection
      @section('script')
      @parent
      <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
      <script>

        @include('assets::ajax_functions')

        var device_type = ["BYOD", "Leased"];
        $(function() {

          var btn_url = '';

          btn_url = "{{URL::route('admin.add.vendors.for.customer')}}";


          var table = $('#devices_dt_table').DataTable({
            processing: true,
            serverSide: true,
        //responsive: true,
        bAutoWidth: false,
        "columnDefs": [
        { "visible": true, "targets": 0 }
        ],
        pageLength: 25,
        order: [[ 0, "desc" ]],
        ajax: '/admin/nexpbx/nexpbx_cust_device_list/{{$id}}',
        dom: '<"col-sm-5 lr-p0"l>Brt<"col-sm-4 lr-p0 controls"i><"col-sm-2 text-center"><"col-sm-5 pull-right lr-p0"p><"clear">',
        buttons: [

        ],

        columns: [
        { data: 'device_label', name: 'device_label', orderable: true, searchable: true, className: "clickable"},
        { data: 'device_mac_address', name: 'device_mac_address', orderable: false, searchable: false, className: "clickable"},
        { data: 'device_vendor', name: 'device_vendor' , orderable: false, searchable: false },
        { data: 'location', name: 'location', orderable: false, searchable: false, },
        { data: 'device_type', name: 'device_type', orderable: false, searchable: false, },

        ],

        "drawCallback": function ( settings ) {
          $('.dataTables_paginate > .pagination').addClass('pagination-sm');
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;
          var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
          var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
          //console.log(pageCount);
          if (pageCount > 1) {
            $('.dataTables_paginate').css("display", "block");
          } else {
            $('.dataTables_paginate').css("display", "none");
          }
        }
      });



          $('#vendor_dt_table tbody ').on( 'click', 'tr', function (e) {

           var route = '/admin/nexpbx/nexpbx_domain_devices/'+$(this).attr('id');
           window.location.href= route;
         });

        });








/**
* Chnage Device Type
*/
function change_type(id,value){
 $.ajax({
  url: "/admin/nexpbx/change_type/"+id+"/"+value,
  type: 'get',
  dataType: 'json',
  success: function(response){
    console.log(response);
    if(response.success) {
      $.notify({
        // options
        message: 'Device type updated.'
      },{
        // settings
        type: 'ng',
        delay: 250,
        animate: {
          enter: 'animated fadeInDown',
          exit: 'animated fadeOutUp'
        }
      });
    }
  },
  error: function(data){
            //in case of error
          }
        });
}


/**
* Chnage Device Type
*/
function change_location(id,value){
 $.ajax({
  url: "/admin/nexpbx/change_location/"+id+"/"+value,
  type: 'get',
  dataType: 'json',
  success: function(response){
    if(response.success) {
      $.notify({
      	// options
      	message: 'Location updated.'
      },{
      	// settings
      	type: 'ng',
        delay: 250,
        animate: {
      		enter: 'animated fadeInDown',
      		exit: 'animated fadeOutUp'
      	}
      });

      //$('#msg').html('<div  class="alert alert-success">Device Location changed successfully</div>');
      //alert_hide();

    }
  },
  error: function(data){
            //in case of error
          }
        });
}

/**
* Call back function that reloads assigned devices datatable and shows removed message.
*/
function reload_data_table(){
  $('#vendor_dt_table').DataTable().ajax.reload();
  $('#msg').html('<div  class="alert alert-danger">Device successfully removed.</div>');
  alert_hide();
}

 function update_notes(){
  $.ajax({
  url: "/admin/nexpbx/update_notes",
  type: 'post',
  dataType: 'json',
  data:$('#update_notes_form').serialize(),
  success: function(response){
    if(response.success) {
      // $('#devices_dt_table').DataTable().ajax.reload();
      $('#msg').html('<div  class="alert alert-success">Device Notes Updated successfully</div>');
      alert_hide();

    }
  },
  error: function(data){
            //in case of error
          }
        });
 }
</script>

@endsection


@section('document.ready')
@parent


       $('#devices_dt_table').on( 'click', 'tr>td.clickable', function (e) {
       console.log('waqas')
         console.log($(this).parent().attr('id'));

         $('#devices_dt_table tr').removeClass('selected');
         $(this).parent().addClass('selected');

         // Load Vendor Details
         // table.row( this ).data().id
         $.get("/admin/nexpbx/ajax_device_detail/"+$(this).parent().attr('id'),function(data) {
           $('#device-details').html(data);
         },"html");

       });

@endsection



@section('styles')
<link rel="stylesheet" href="/DataTables/datatables.min.css">
<style>
.bot_10px{
  margin-bottom: 10px;
}
.table-responsive {

  //overflow-x: hidden;
}
.margin-above{
  margin-top: 20px
}
</style>
<style>
  @if((session('cust_id')!='') && (session('customer_name')!=''))
  .btn-group {
    float: right;
  }
  @endif

  .paginate_button {

  }
</style>
@endsection
