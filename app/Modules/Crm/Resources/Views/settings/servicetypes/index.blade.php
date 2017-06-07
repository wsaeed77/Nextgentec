@extends('admin.main')
@section('content')

@section('content_header')
<h1>Service Types</h1>
<ol class="breadcrumb">
    <li>
        <i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
    </li>
    <li>CRM</li>
    <li class="active">Service Types</li>
</ol>
@endsection

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-servicetype-create" class="btn btn-primary pull-right">New Type</button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="padding-top: 15px;">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th style="width:250px;">Title</th>
            <th style="width:150px;">Created</th>
            <th style="width:60px;">Actions</th>
          </tr>
          @foreach ($serviceItems as $service_item)
          <tr>
            <td>{{ $service_item->title }}</td>
            <td>{{ date('d/m/Y',strtotime($service_item->created_at)) }}</td>
            <td><button type="button" class="btn btn-danger btn-xs"
                data-toggle="modal" data-id="{{$service_item->id}}" id="modaal" data-target="#modal-servicetype-delete">
                <i class="fa fa-times-circle"></i></button></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

@include('admin.partials.delete_modal', [
  'id'=>'modal-servicetype-delete',
  'message' => 'Are you sure you\'d like to delete this service item?',
  'url' => 'admin.setting.crm.servicetypes.delete',
  'refresh' => true
])
@include('crm::settings.servicetypes.create_modal')
@endsection
@section('script')
@endsection
@section('document.ready')

@parent
@endsection

@section('styles')

@endsection
