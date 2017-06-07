@extends('admin.main')
@section('content')

@section('content_header')
<h1>
 Nexpbx Domains
 {{-- <small>preview of simple tables</small> --}}
</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
  </li>
  <li class="active">
    <i class="fa fa-table"></i> Nexpbx
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
        <div class="col-sm-12">
          @endif
          <div id="msg"></div>
          <div class="tab-pane active table-responsive" >
            <table class="table table-hover" id="vendor_dt_table">
              <thead>
                <tr>
                  <th>Domain Name</th>
                  <th>Domain Description</th>
                  <th>action</th>
                </tr>
              </thead>
            </table>
          </div><!-- /.tab-pane -->
        </div>
      </div>

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


          var table = $('#vendor_dt_table').DataTable({
            processing: true,
            serverSide: true,
            'createdRow': function( row, data, dataIndex ) {
              $(row).attr('domain-uuid',data.domain_uuid );
            },

        //responsive: true,
        bAutoWidth: false,
        "columnDefs": [
        { "visible": true, "targets": 0 }
        ],
        pageLength: 25,
        order: [[ 2, "desc" ]],
        ajax: '{!! route('admin.nexpbx.customer.json') !!}',
        dom: '<"col-sm-4 lr-p0"l>Brt<"col-sm-4 lr-p0 controls"i><"col-sm-6 text-center"><"col-sm-4 pull-right lr-p0"p><"clear">',
        buttons: [
        {
          text: 'Attact Domain',
          className: 'btn-sm',
          action: function ( e, dt, node, config ) {
            window.location = "{{ URL::route('admin.nexpbx.assign.devices')}}";
          }
        }
        ],

        columns: [

        { data: 'domain_name', name: 'location',className: "clickable"},
        { data: 'domain_description', name: 'domain_description'},
        {data: 'action', name: 'action', orderable: false, searchable: false, width: "50px", className: "my_class","orderable": false   }

        ],

        "drawCallback": function ( settings ) {
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



          $('#vendor_dt_table tbody ').on( 'click', 'tr td:first-child', function (e) {

            var route = '/admin/nexpbx/nexpbx_domain_devices/'+$(this).parent().attr('domain-uuid');
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
    if(response.success) {
      $('#vendor_dt_table').DataTable().ajax.reload();
      $('#msg').html('<div  class="alert alert-danger">Device Type changed successfully</div>');
      alert_hide();

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
alert_hide();
</script>
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
.clickable{
  cursor: pointer;
}
</style>
<style>
  @if((session('cust_id')!='') && (session('customer_name')!=''))
  .btn-group {
    float: right;
  }
  @endif
</style>
@endsection
