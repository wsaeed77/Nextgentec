@extends('admin.main')
@section('content')

@section('content_header')
<h1>Ticket Status</h1>
<ol class="breadcrumb">
    <li>
        <i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
    </li>
    <li class="active">Ticket Statuses</li>
</ol>
@endsection

<section class="content">
  <button type="button" class="btn btn-default btn-xs pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-ticket-status" class="btn btn-primary pull-right"> Create New Status</button>
  <div class="clearfix"></div>

  <table class="table table-hover" id="dt_table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Color</th>
        <th>Created on</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($statuses as $status)
      <tr>
          <td>{{ $status->title }}</td>

          <td>
            <div class="color-palette-set">
              <div class="color-palette" style="background-color:{{ $status->color_code }}"><span>&nbsp;</span></div>
            </div>
          </td>
          <td>{{ date('d/m/Y',strtotime($status->created_at)) }}</td>
          <td>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-id="{{$status->id}}" id="modaal" data-target="#modal-edit-ticket-status">
            <i class="fa fa-pencil"></i>Edit</button>
            <button type="button" class="btn btn-danger btn-sm"
                  data-toggle="modal" data-id="{{$status->id}}" id="modaal" data-target="#modal_ticketstatus_delete">
            <i class="fa fa-times-circle"></i>
            Delete
            </button>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>

</section>

@include('admin.partials.delete_modal', [
  'id'=>'modal_ticketstatus_delete',
  'message' => 'Are you sure you\'d like to delete this status?',
  'url' => 'admin.tickets.status.delete',
  'refresh' => true
])
@include('crm::settings.ticketstatus.edit_modal')
@include('crm::settings.ticketstatus.create_modal')
@endsection
@section('script')
<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
  <script>
    $(function () {
      $('.pagination').addClass('pull-right');
    });
  </script>
<script src="/colorpicker/bootstrap-colorpicker.min.js"></script>
@endsection

@section('document.ready')
@parent



@endsection

@section('styles')
<link rel="stylesheet" href="{{URL::asset('css/jquery.dataTables.min.css')}}">
<style>
.bot_10px{
      margin-bottom: 10px;
  }

</style>
<link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/>
@endsection
