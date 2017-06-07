@extends('admin.main')
@section('content')

<section class="content-header">
    <h1 id="h1_title" >
           {{$customer->name}}
        {{-- <small>preview of simple tables</small> --}}

    </h1>
    
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i>  <a href="/admin/crm">Customers</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> {{$customer->name}}
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
            
        <div class="col-md-4">
        <div id="info_msg"></div>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title pull-left">Info</h3>
              
              <button type="button" class="btn btn-danger btn-sm pull-right"
                                  data-toggle="modal" data-id="{{$customer->id}}" id="modaal" data-target="#modal-delete-customer">
                                    <i class="fa fa-times-circle"></i>
                                    Delete Customer
                                </button>&nbsp;&nbsp;

                                <a  class="btn btn-default  pull-right" data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-edit-customer-info"   data-toggle="modal"><i class="fa fa-pencil"></i></a>
            </div><!-- /.box-header -->
            <div class="box-body" id="info_bdy">
                
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
        <div class="col-md-2 no-gutter">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Tickets</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                 <h3 class="profile-username text-center">Open Tickets</h3>
                <p class="text-muted text-center"><b>0</b></p>

                  <h3 class="profile-username text-center">Open Tickets</h3>
                <p class="text-muted text-center"><b>0</b></p>

                  <h3 class="profile-username text-center">Open Tickets</h3>
                <p class="text-muted text-center"><b>0</b></p>


            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>


        <div class="col-md-6">
            <div class="col-md-12 no-gutter">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Locations</h3>
                   <a  class="btn btn-default btn-sm pull-right" data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-add-new-location"   data-toggle="modal"><i class="fa fa-plus"></i> Add Location</a>
                </div><!-- /.box-header -->
                <div class="box-body" >
                    <table class="table tbl_font">
                        <tbody id="locations_tbl">
                        
                      </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>

            <div class="col-md-12 no-gutter" id="contacts">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Contacts</h3>

                   <a  class="btn btn-default btn-sm pull-right" data-custid="{{$customer->id}}" href="javascript:;" data-target="#modal-add-new-contact"   data-toggle="modal"><i class="fa fa-plus"></i> Add Contact</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table class="table tbl_font">
                        <tbody id="loc_contacts">
                    
                      </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12" >
            <div class="box" id="service_items_panel">
            <div class="box-header">
              <h3 class="box-title">Service Items</h3>
              <div class="box-tools">
               <div style="width: 150px;" class="input-group">
               <a  class="btn btn-default btn-sm pull-right" data-custid="{{$customer->id}}" href="javascript:;" data-target="#modal-add-new-service-item"   data-toggle="modal"><i class="fa fa-plus"></i> Add New Service Item</a>
               
                  
                </div>
              </div>
            </div><!-- /.box-header -->

            <div class="box-body table-responsive ">
              <table class="table table-hover">
                <tr>
                  <th>Title</th>
                  <th>Type</th>
                  <th>Start Date</th>
                   
                  <th>End Date</th>
                  <th>Action</th>
                </tr>
                 <tbody id="service_items_table">
                 
                  </tbody>
              </table>
            </div><!-- /.box-body -->
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" >
            <div class="box" id="rates_panel">
            <div class="box-header">
              <h3 class="box-title">Rates</h3>
            
            </div><!-- /.box-header -->

            <div class="box-body table-responsive ">
              <table class="table table-hover">
               <tr>
                    <th>Title</th>

                    <th>Active?</th>
                    <th>Service item</th>
                    <th>Amount</th>

                    <th>Is Default?</th>
                    <th>Action</th>
                </tr>
                 <tbody id="rates_table">

                 </tbody>
              </table>
            </div><!-- /.box-body -->
          </div>
        </div>
    </div>

<div class="row">
  <div class="col-lg-12" >
    <div class="box" id="rates_panel">
      <div class="box-header">
        <h3 class="box-title">Expenses And Income</h3>
      
      </div><!-- /.box-header -->

      <div class="box-body table-responsive " >
        <div id="container" style="width:100%;margin: 0 auto">
        </div>
      </div>
    </div>
  </div>
</div>


</section>




<!-- /#page-wrapper -->
  @include('crm::crm.location.ajax_edit_location_modal')
  @include('crm::crm.contact.ajax_edit_contact_modal')
  @include('crm::crm.info.ajax_edit_customer_info_modal')

  @include('crm::crm.location.ajax_add_location_modal')
  @include('crm::crm.contact.ajax_add_contact_modal')

  @include('crm::crm.service_item.ajax_edit_service_item_modal')
  @include('crm::crm.rate.ajax_edit_rate_modal')

  @include('crm::crm.rate.ajax_add_new_rate_modal')

  @include('crm::crm.service_item.ajax_add_new_service_item_modal')

  @include('crm::crm.contact.delete_modal_ajax')

  @include('crm::crm.location.delete_modal_ajax')

  @include('crm::crm.rate.delete_modal_ajax')
  @include('crm::crm.service_item.delete_modal_ajax')


  @include('crm::crm.delete_modal_ajax')

@endsection
@section('styles')

<link href="/css/datepicker.css" rel="stylesheet" />
<style>
  .badge.btn-success {
      background-color: #5cb85c;
  }
  .padding_l_r_20{
  padding: 0 20px;
  }

  h3.panel-title.pull-left {
      width: 65%;
  }

  @media (min-width: 992px) {
    .modal-dialog {
      width: 930px !important;
      }
  }
  .no-gutter{
      padding-left: 0px;
      padding-right: 0px;
  }

  .tbl_font {
      font-size: 14px;
      font-weight: 100;
  }

</style>
<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
@endsection
@section('script')

<script type="text/javascript" src="/js/highcharts.js"></script>
<script type="text/javascript" src="{{URL::asset('js/jquery.inputmask.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() 
    {
         //load Customer info
        $.get("{{ URL::route('admin.crm.ajax.refresh_info',$customer->id)}}",function( data_response ) {
          var obj_json = $.parseJSON(data_response);
                                 $('#info_bdy').html(obj_json.html_content);
                                $('#h1_title').html(obj_json.h1_title);
                              },"html");

        //load the location list
        $.get("{{ URL::route('admin.crm.ajax.list_locations',$customer->id)}}",function( data_response ) {
                                  $('#locations_tbl').html(data_response);
                              },"html");

        //load the contacts list
        $.get("{{ URL::route('admin.crm.ajax.refresh_contacts',$customer->id)}}",function( data_response ) {
                                  $('#loc_contacts').html(data_response);
                                  
                                },"html");

        //load service items list
        $.get("{{ URL::route('admin.crm.ajax.list_service_item',$customer->id)}}",function( data_response ) {
                                  $('#service_items_table').html(data_response);
                                  
                                },"html");

         //load Rates list
        $.get("{{ URL::route('admin.crm.ajax.list_rate',$customer->id)}}",function( data_response ) {
                                  $('#rates_table').html(data_response);
                                  
                                },"html");


      $('.multiselect').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                  dropUp: false,
                  buttonClass: 'form-control',
                  enableCaseInsensitiveFiltering: true
                 
                });


      $.get(APP_URL+'/admin/crm/zoho_get_expenses/{{$customer->zohoid}}',function( response ) {


        //console.log(response);

        $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Expenses And Income'
        },
        subtitle: {
            text: 'Source: Zoho Invoice'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Amount'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Expense',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'Income',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }]
        });

      });


       
       });
      </script>

@endsection