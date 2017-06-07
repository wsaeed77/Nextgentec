@extends('admin.main')
@section('content')

@section('content_header')
<h1>Billing Periods</h1>
<ol class="breadcrumb">
    <li>
        <i class="fa fa-dashboard"></i>  <a href="/admin/settings">Settings</a>
    </li>
    <li>CRM</li>
    <li class="active">Billing Periods</li>
</ol>
@endsection

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-billingperiod-create" class="btn btn-primary pull-right">New Period</button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="padding-top: 15px;">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th style="width:250px;">Title</th>
            <th>Description</th>
            <th style="width:150px;">Created</th>
            <th style="width:60px;">Actions</th>
          </tr>
          @foreach ($billingPeriods as $billing_period)
          <tr>
            <td>{{ $billing_period->title }}</td>
            <td>{{ $billing_period->description }}</td>
            <td>{{ date('d/m/Y',strtotime($billing_period->created_at)) }}</td>
            <td><div class="btn-group"><button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-id="{{$billing_period->id}}" id="modaal" data-target="#modal-billingperiod-delete">
          			<i class="fa fa-times-circle"></i></button></div></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

@include('admin.partials.delete_modal', [
  'id'=>'modal-billingperiod-delete',
  'message' => 'Are you sure you\'d like to delete this billing period?',
  'url' => 'admin.setting.crm.billingperiods.delete',
  'refresh' => true
])
@include('crm::settings.billingperiods.create_modal')
@endsection
@section('script')
@endsection
@section('document.ready')

@parent
@endsection

@section('styles')

@endsection
