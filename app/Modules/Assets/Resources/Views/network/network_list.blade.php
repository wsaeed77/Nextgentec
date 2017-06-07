@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
            Network
    </h1>



    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Network
        </li>

    </ol>
@endsection

<section class="content">
    <div class="row">

        <div class="col-xs-12">

          <div id="msg"></div>

         <div class="table-s" id="networks">

            <table class="display table-hover table responsive nowrap" cellspacing="0" width="100%" id="network_dt_table">
              <thead>
                <tr>
                  <th>Name</th>
                <th>Subnet</th>
                  <th>Created at</th>
                  <th>Customer</th>
                  <th>Actions</th>
                </tr>
                </thead>


              </table>


          </div>



    </div>
    </div>
    </div>
</section>



@include('assets::network.ajax_create_network')
@include('assets::knowledge.show')
@include('assets::network.edit_network')
@include('assets::network.show')

@include('admin.partials.delete_modal', [
  'id'=>'modal_network_delete',
  'message' => 'Are you sure you\'d like to delete this network?',
  'url' => 'admin.knowledge.delete.network',
  'refresh' => true
])

{{--@include('crm::ticketstatus.delete_modal_ticket_status')
@include('crm::ticketstatus.ajax_create_ticket_status') --}}

@endsection
@section('script')
<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
{{--  <script src="/colorpicker/bootstrap-colorpicker.min.js"></script> --}}
{{-- <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script> --}}

   <script src="{{URL::asset('vendor/summernote/summernote.js')}}"></script>
<script src="{{URL::asset('vendor/summernote/summernote-floats-bs.min.js')}}"></script>
@endsection

@section('styles')
@parent
<link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
<link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">


@endsection

@section('document.ready')
@parent

{{--<script type="text/javascript">--}}

$('#modal-test').modal('show');

$('#network_dt_table').DataTable({
  processing: true,
  serverSide: true,
  "bAutoWidth": false,
  @if((session('cust_id')!='') && (session('customer_name')!=''))
  ajax: '{!! route('admin.knowledge.networks_list_by_cust',session('cust_id')) !!}',
  @else
  ajax: '{!! route('admin.knowledge.networks.list') !!}',
  @endif
  dom: '<"col-sm-3 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-5 text-center"i><"col-sm-3 pull-right lr-p0"p><"clear">',
  buttons: [
    {
        text: 'New Network',
        className: 'btn-sm',
        action: function ( e, dt, node, config ) {
            $('#modal-create-network').modal('show');
        }
    }
  ],
  columns: [
     { data: 'name', name: 'name', className: "clickable" },
     { data: 'lansubnet', name: 'subnet', className: "clickable" },
     { data: 'created_at', name: 'created_at' , className: "clickable"},
     {data: 'customer', name: 'customer', orderable: false, searchable: false, className: "clickable"},
     {data: 'action', name: 'action', orderable: false, searchable: false}

  ],
  "fnDrawCallback": function(){
   var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
   var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
   console.log(pageCount);
   if (pageCount > 1) {
     $('.dataTables_paginate').css("display", "block");
   } else {
     $('.dataTables_paginate').css("display", "none");
   }
  },
 });


        $('#network_dt_table tbody ').on( 'click', 'tr>td.clickable', function (e) {
           //console.log($(this).parent().attr('id'));

           $("#modal-show-network").modal('show');
           $("#modal-show-network").attr('net_id',$(this).parent().attr('id'));

           $("#modal-show-network").attr('type',$(this).parent().attr('id'));
        });
@endsection
