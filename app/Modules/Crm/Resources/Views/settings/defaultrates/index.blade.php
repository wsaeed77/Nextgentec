@extends('admin.main')
@section('content')

@section('content_header')
<h1>Default Rates</h1>
<ol class="breadcrumb">
    <li>
        <i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
    </li>
    <li>CRM</li>
    <li class="active">Default Rates</li>
</ol>
@endsection

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-rate" class="btn btn-primary pull-right">New Rate</button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="padding-top: 15px;">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th style="width:250px;">Title</th>
            <th>Amount</th>
            <th>Created</th>
            <th style="width:60px;">Actions</th>
          </tr>
          @foreach ($defaultRates as $rate)
          <tr>
            <td>{{ $rate->title}}</td>
            <td>${{ $rate->amount }}</td>
            <td>{{ date($global_date,strtotime($rate->created_at)) }}</td>
            <td><div class="btn-group"><button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-id="{{$rate->id}}" id="modaal" data-target="#modal_rate_delete">
          			<i class="fa fa-times-circle"></i></button></div></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

@include('admin.partials.delete_modal', [
  'id'=>'modal_rate_delete',
  'message' => 'Are you sure you\'d like to delete this rate?',
  'url' => 'admin.setting.crm.defaultrates.delete',
  'refresh' => true
])
@include('crm::settings.defaultrates.create_modal')
@endsection
@section('script')
@endsection
@section('document.ready')

@parent
@endsection

@section('styles')
<style>
.tablepad {
  padding: 0 0 0 5px;
}
</style>
@endsection
