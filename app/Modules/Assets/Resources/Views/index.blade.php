@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
         Assets
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Assets
        </li>
    </ol>
@endsection

<section class="content">
  <div class="row">
            <div class="col-xs-12">
            <div id="msg"></div>
               <a href=" {{ URL::route('admin.assets.create')}}" class="btn btn-primary pull-right"> Create New Asset</a>
<div class="clearfix">&nbsp;</div>
                  <div class="nav-tabs-custom">
                      <ul class="nav nav-pills">
                        <li class="active"><a href="#tab_network" data-toggle="pill">Network</a></li>
                        <li><a href="#tab_gateway" data-toggle="pill">Gateway</a></li>
                        <li><a href="#tab_pbx" data-toggle="pill">PBX</a></li>
                        <li><a href="#tab_server" data-toggle="pill">Server</a></li>

                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane fade in  active table-responsive" id="tab_network">
                          <table class="table table-hover" id="network_dt_table">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Manufacture</th>
                              <th>Customer</th>
                              <th>Created at</th>
                               <th>Os</th>
                              <th>Model</th>
                              <th>Actions</th>
                            </tr>
                          </thead>


                          </table>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane fade in table-responsive" id="tab_gateway">
                          <table class="table table-hover" id="gateway_dt_table">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Manufacture</th>
                              <th>Customer</th>
                              <th>Created at</th>

                              <th>Model</th>
                              <th>Actions</th>
                            </tr>

                            </thead>


                          </table>
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane fade in  table-responsive" id="tab_pbx">
                          <table class="table table-hover" id="pbx_dt_table">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Manufacture</th>
                              <th>Customer</th>
                              <th>OS</th>
                              <th>Created at</th>

                              <th>Hostname</th>
                              <th>Actions</th>
                            </tr>

                            </thead>


                          </table>
                        </div><!-- /.tab-pane fade in  -->

                        <div class="tab-pane fade in  table-responsive" id="tab_server">
                          <table class="table table-hover" id="server_dt_table">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Server type</th>
                             {{--  <th>Serial #</th> --}}
                              <th>Created at</th>
                              <th>Host name</th>
                              <th>Actions</th>
                            </tr>

                            </thead>


                          </table>
                        </div><!-- /.tab-pane fade in  -->
                      </div><!-- /.tab-content -->
                </div>

            </div>
          </div>
</section>

 @include('assets::delete_modal')
 @include('assets::show')
  @include('assets::edit')



@endsection
@section('script')
@parent



  {{-- <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script> --}}

   <script src="{{URL::asset('vendor/summernote/summernote.js')}}"></script>
<script src="{{URL::asset('vendor/summernote/summernote-floats-bs.min.js')}}"></script>
    <script src="{{URL::asset('js/select2.full.min.js')}}"></script>

 <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
  <script>

  @include('assets::ajax_functions')
    $(function() {

    $('#network_dt_table').DataTable({
        processing: true,
        serverSide: true,
        //responsive: true,
        "bAutoWidth": false,
        @if((session('cust_id')!='') && (session('customer_name')!=''))
          ajax: '{!! route('admin.assets.network_index_by_cust',session('cust_id')) !!}',
        @else
           ajax: '{!! route('admin.assets.network_index') !!}',
        @endif

        columns: [
            { data: 'name', name: 'name',className: "clickable" },
            { data: 'manufacture', name: 'manufacture',className: "clickable" },
            { data: 'customer', name: 'customer',orderable: false, searchable: false,className: "clickable" },
            { data: 'created_at', name: 'created_at',className: "clickable" },
            { data: 'os', name: 'os',className: "clickable" },
            { data: 'model', name: 'model',className: "clickable"},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        "fnDrawCallback": function(){
          var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
          var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
         // console.log(pageCount);
          if (pageCount > 1) {
            $('.dataTables_paginate').css("display", "block");
          } else {
            $('.dataTables_paginate').css("display", "none");
          }
        },
    });
     $('#network_dt_table tbody ').on( 'click', 'tr>td.clickable', function (e) {
          // console.log('ddfd'+$(this).parent().attr('id'));

           $("#modal-show-asset").modal('show');
          $("#modal-show-asset").attr('asset_id',$(this).parent().attr('id'));

          // $("#modal-show-network").attr('type',$(this).parent().attr('id'));
        });



    $('#gateway_dt_table').DataTable({
        processing: true,
        serverSide: true,
        "bAutoWidth": false,
        @if((session('cust_id')!='') && (session('customer_name')!=''))
          ajax: '{!! route('admin.assets.gateway_index_by_cust',session('cust_id')) !!}',
        @else
           ajax: '{!! route('admin.assets.gateway_index') !!}',
        @endif

        columns: [
            { data: 'name', name: 'name',className: "clickable" },
            { data: 'manufacture', name: 'manufacture',className: "clickable" },
            { data: 'customer', name: 'customer',orderable: false, searchable: false,className: "clickable" },
            { data: 'created_at', name: 'created_at' ,className: "clickable"},
            { data: 'model', name: 'model',className: "clickable" },
            { data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        "fnDrawCallback": function(){
          var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
          var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
         // console.log(pageCount);
          if (pageCount > 1) {
            $('.dataTables_paginate').css("display", "block");
          } else {
            $('.dataTables_paginate').css("display", "none");
          }
        },
    });


     $('#gateway_dt_table tbody ').on( 'click', 'tr>td.clickable', function (e) {
          // console.log('ddfd'+$(this).parent().attr('id'));

           $("#modal-show-asset").modal('show');
          $("#modal-show-asset").attr('asset_id',$(this).parent().attr('id'));

          // $("#modal-show-network").attr('type',$(this).parent().attr('id'));
        });




    $('#pbx_dt_table').DataTable({
        processing: true,
        serverSide: true,
         "bAutoWidth": false,
         @if((session('cust_id')!='') && (session('customer_name')!=''))
             ajax: '{!! route('admin.assets.pbx_index_by_cust',session('cust_id')) !!}',
        @else
             ajax: '{!! route('admin.assets.pbx_index') !!}',
        @endif

        columns: [
            { data: 'name', name: 'name',className: "clickable" },
            { data: 'manufacture', name: 'manufacture',className: "clickable" },
            { data: 'customer', name: 'customer',orderable: false, searchable: false,className: "clickable" },
            { data: 'os', name: 'os',className: "clickable" },
            { data: 'created_at', name: 'created_at',className: "clickable" },
            { data: 'host_name', name: 'host_name',className: "clickable" },

            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        "fnDrawCallback": function(){
          var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
          var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
          //console.log(pageCount);
          if (pageCount > 1) {
            $('.dataTables_paginate').css("display", "block");
          } else {
            $('.dataTables_paginate').css("display", "none");
          }
        },
    });


     $('#pbx_dt_table tbody ').on( 'click', 'tr>td.clickable', function (e) {
          // console.log('ddfd'+$(this).parent().attr('id'));

           $("#modal-show-asset").modal('show');
          $("#modal-show-asset").attr('asset_id',$(this).parent().attr('id'));

          // $("#modal-show-network").attr('type',$(this).parent().attr('id'));
        });



    $('#server_dt_table').DataTable({
        processing: true,
        serverSide: true,
        "bAutoWidth": false,
        @if((session('cust_id')!='') && (session('customer_name')!=''))
          ajax: '{!! route('admin.assets.server_index_by_cust',session('cust_id')) !!}',
        @else
            ajax: '{!! route('admin.assets.server_index') !!}',
        @endif

        columns: [
            { data: 'name', name: 'name',className: "clickable" },
            /*{ data: 'customer', name: 'customer',orderable: false, searchable: false,className: "clickable" },*/
            { data: 'server_type', name: 'server_type',className: "clickable" },
            /*{ data: 'serial_number', name: 'serial_number' },*/
            { data: 'created_at', name: 'created_at',className: "clickable" },
            { data: 'host_name', name: 'host_name',className: "clickable" },
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        "fnDrawCallback": function(){
          var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
          var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
          //console.log(pageCount);
          if (pageCount > 1) {
            $('.dataTables_paginate').css("display", "block");
          } else {
            $('.dataTables_paginate').css("display", "none");
          }
        },
    });

     $('#server_dt_table tbody ').on( 'click', 'tr>td.clickable', function (e) {
          // console.log('ddfd'+$(this).parent().attr('id'));

           $("#modal-show-asset").modal('show');
          $("#modal-show-asset").attr('asset_id',$(this).parent().attr('id'));

          // $("#modal-show-network").attr('type',$(this).parent().attr('id'));
        });


  });


    $(function () {

      $('.pagination').addClass('pull-right');
    });




  </script>
@endsection
@section('styles')
  <!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"> -->
   <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
 <style>
 .bot_10px{
        margin-bottom: 10px;
    }
    .table-responsive {

        //overflow-x: hidden;
    }
 </style>

 <link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
 {{--  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"> --}}
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
    .modal-dialog {
      margin: 30px auto;
     
    }

</style>
@endsection
