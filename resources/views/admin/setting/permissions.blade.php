@extends('admin.main')
@section('content')
@section('content_header')
<h1>Permissions</h1>

<ol class="breadcrumb">
  <li><i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a></li>
  <li class="active">
    <i class="fa fa-gears"></i> Settings
  </li>
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
  <div class="alert alert-success  alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <ul>
      <li>{{ session('success') }}</li>
    </ul>
  </div>
  @endif
</div>

<div class="box-body table-responsive">
<table class="table table-hover" id="rolespermissions">
  <thead>
    <tr>
      <th>Display Name</th>
      <th>Name</th>
      <th>Description</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
    </thead>
  </table>
</div>

</section>

@include('admin.permissions.delete_modal_ajax_permission')
@include('admin.roles.ajax_create_role')
@include('admin.roles.ajax_edit_role')
@include('admin.roles.delete_modal_role')
@include('admin.permissions.ajax_create_permission')
@include('admin.permissions.ajax_edit_permission')

@endsection
@section('script')
<script src="/DataTables/datatables.min.js"></script>
@endsection

@section('document.ready')
@parent

{{-- <script type="text/javascript"> --}}

var roles = false;
var roles_tbl = $('#rolespermissions').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('admin.permissions.list') !!}',
      dom: '<"col-sm-3 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-4 text-center"i><"col-sm-5 pull-right lr-p0"p><"clear">',
      buttons: [
        {
            text: 'New Permission',
            className: 'btn-sm newrecord',
            action: function ( e, dt, node, config ) {
                window.location = "{{ URL::route('admin.permissions.create')}}";
            }
        },
        {
            text: 'Manage Roles',
            className: 'btn-sm roles',
            action: function ( e, dt, node, config ) {
              if(roles == true) {
                roles_tbl.ajax.url( '{!! route('admin.permissions.list') !!}' ).load(function() {
                  roles_tbl.buttons('.roles').text('Manage Roles');
                  roles_tbl.buttons('.newrecord').text('New Permission');
                  roles_tbl.buttons('.newrecord').action(function() {
                    window.location = "{{ URL::route('admin.permissions.create')}}";
                  });
                  roles = false;
                });
              } else {
                roles_tbl.ajax.url( '{{ URL::route('admin.roles.ajax.list')}}' ).load(function() {
                  roles_tbl.buttons('.roles').text('<b>Back</b>');
                  roles_tbl.buttons('.newrecord').text('New Role');
                  roles_tbl.buttons('.newrecord').action(function() {
                    $('#modal-create-role').modal('show');
                  });
                  roles = true;
                });
              }

            }
        }
      ],
      drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        },
      columns: [
          { data: 'display_name', name: 'display_name' },
          { data: 'name', name: 'name' },
          { data: 'description', name: 'description' },
          { data: 'created_at', name: 'created_at' },
          {data: 'action', name: 'action', orderable: false, searchable: false}

      ]
  });


@endsection
@section('styles')
@parent
<link rel="stylesheet" href="/DataTables/datatables.min.css">
<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />

<style>

</style>
@endsection
