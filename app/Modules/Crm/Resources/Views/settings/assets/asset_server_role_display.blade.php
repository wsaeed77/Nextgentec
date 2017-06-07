@extends('admin.main')


@section('content')

@section('content_header')
<h1>Assets Server Role</h1>
<ol class="breadcrumb">
	<li>
		<i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
	</li>
	<li>Assets</li>
	<li class="active">Assets Server Role</li>
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

	<div class="box-body table-responsive">

		<button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-asset-role" class="btn btn-primary pull-right"> Create New Server Role</button>
		<table class="display table-striped table responsive nowrap" cellspacing="0" width="100%" id="dt_table_server_roles">
			<thead>
				<tr>
					{{-- <th>ID</th> --}}
					<th>Title</th>

					<th>Created on</th>
					<th>Actions</th>
				</tr>
			</thead>


		</table>

	</div><!-- /.box-body -->


</section>


{{-- @include('crm::settings.assets.delete_modal') --}}

@include('admin.partials.delete_modal', [
  'id'=>'modal-delete-asset-server-role',
  'message' => 'Are you sure you\'d like to delete this status?',
  'url' => 'admin.setting.crm.assets.delete_server_role',
  'refresh' => true
])

@include('crm::settings.assets.ajax_create_asset_role')

@endsection
@section('script')
<script src="/DataTables/datatables.min.js"></script>
@endsection

@section('document.ready')
@parent

 $('#dt_table_server_roles').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.setting.crm.assets.list_server_roles') !!}',
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
          $("#dt_table_server_roles").css("width","100%");
          $('#dt_table_server_roles_wrapper').addClass('padding-top-40');


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
