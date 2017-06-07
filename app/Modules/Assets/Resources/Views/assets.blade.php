@extends('admin.main')

@section('content_header')
<h1 id="top_heading">Assets</h1>

<ol class="breadcrumb">
  <li><i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a></li>
  <li class="active">
    <i class="fa fa-gears"></i> Settings
  </li>
</ol>
@endsection
@section('content')
  <section class="content">
    <div class="col-xs-12">
       <div id="msg"></div>
    </div>

    <div class="box-body">
      <table class="display table responsive nowrap" cellspacing="0" width="100%" id="assets_dt_table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Server type</th>
            <th>Manufacture</th>
            {{-- <th>Customer</th> --}}
            
            <th>Os</th>
            <th>Model</th>
            <th>Host name</th>
            <th>Created at</th>
            <th>Actions</th>
          </tr>
          </thead>
        </table>
    </div>

  </section>
 {{-- @include('assets::delete_modal') --}}
  @include('assets::edit')

@include('admin.partials.delete_modal', [
  'id'=>'modal_assest_delete',
  'message' => 'Are you sure you\'d like to remove this asset?',
  'url' => 'admin.assets.delete',
  'refresh' => false,
  'callBackFunction'=>'reload_assets_after_delete();'
])

@endsection

@section('script')
@parent


    <script src="{{URL::asset('js/select2.full.min.js')}}"></script>

 <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>

   <script>
    @include('assets::ajax_functions')
  </script>
{{-- <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script> --}}


@endsection

@section('document.ready')
@parent

{{-- <script type="text/javascript"> --}}


var assets_tbl = $('#assets_dt_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('admin.assets.all') !!}',
      dom: '<"col-sm-4 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-4 text-center"i><"col-sm-5 pull-right lr-p0"p><"clear">',
      buttons: [
        {
            text: 'All',
            className: 'btn-sm all btn',
            action: function ( e, dt, node, config ) {
                 assets_tbl.ajax.url( '{!! route('admin.assets.all') !!}' ).load(function() {
              
                 $.each(assets_tbl.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(assets_tbl.buttons('.all')[0].node).addClass('bold').removeClass('unbold');

                   $('#top_heading').html('Assests');
                  
                });
            },
             init: function ( dt, node, config ) {
              //console.log(node);
              $(node[0]).addClass('bold');
            } 
        },
        {
            text: 'Network',
            className: 'btn-sm network btn',
            action: function ( e, dt, node, config ) {
                  assets_tbl.ajax.url( '{!! route('admin.assets.network_index') !!}' ).load(function() {

                $.each(assets_tbl.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(assets_tbl.buttons('.network')[0].node).addClass('bold').removeClass('unbold');

               
               
               
                  
                   $('#top_heading').html('Network');
                  
                });
            }
        },
        {
            text: 'Gateway',
            className: 'btn-sm gateway btn',
            action: function ( e, dt, node, config ) {
                 assets_tbl.ajax.url( '{!! route('admin.assets.gateway_index') !!}' ).load(function() {
                  $.each(assets_tbl.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(assets_tbl.buttons('.gateway')[0].node).addClass('bold').removeClass('unbold');

                   $('#top_heading').html('Gateway');
                  
                });
            }
        },
        {
            text: 'Pbx',
            className: 'btn-sm pbx btn',
            action: function ( e, dt, node, config ) {
                 assets_tbl.ajax.url( '{!! route('admin.assets.pbx_index') !!}' ).load(function() {
                   $.each(assets_tbl.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(assets_tbl.buttons('.pbx')[0].node).addClass('bold').removeClass('unbold');

                   $('#top_heading').html('Pbx');
                  
                });
            }
        },
         {
            text: 'Server',
            className: 'btn-sm server btn',
            action: function ( e, dt, node, config ) {
                  assets_tbl.ajax.url( '{!! route('admin.assets.server_index') !!}' ).load(function() {
               $.each(assets_tbl.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(assets_tbl.buttons('.server')[0].node).addClass('bold').removeClass('unbold');

                   $('#top_heading').html('Server');
                  
                });
            }
        },
        {
            text: 'New Asset',
            className: 'btn-sm newrecord',
            action: function ( e, dt, node, config ) {
                window.location = "{{ URL::route('admin.assets.create')}}";
            }
        }
      ],
      drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        },
      columns: [
            { data: 'name', name: 'name',className: "clickable" },
             { data: 'server_type', name: 'server_type',className: "clickable" },
            { data: 'manufacture', name: 'manufacture',className: "clickable" },
            {{-- { data: 'customer', name: 'customer',orderable: false, searchable: false,className: "clickable" }, --}}
            
            { data: 'os', name: 'os',className: "clickable" },
            { data: 'model', name: 'model',className: "clickable"},
            { data: 'host_name', name: 'host_name',className: "clickable" },
            { data: 'created_at', name: 'created_at',className: "clickable" },
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ]
  });


@endsection
@section('styles')
@parent

 <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
 {{--  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"> --}}
  <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">
  
@endsection
