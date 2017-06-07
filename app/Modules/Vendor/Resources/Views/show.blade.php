@extends('admin.main')
@section('content')

@section('content_header')
  <h1>Vendors</h1>
  <ol class="breadcrumb">
      <li>
          <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
      </li>
      <li class="active">
          <i class="fa fa-table"></i>  <a href="/admin/crm">Vendors</a>
      </li>
      <li class="active">
          <i class="fa fa-table"></i> {{$vendor->name}}
      </li>
  </ol>
@endsection

<section class="content">
    <div class="row" >

        <div class="col-md-4" id="vendor_info">
        <div id="info_msg"></div>

        <div class="box box-widget widget-user"  id="info_bdy">
            @include('vendor::show.info.vendor_top_left_info', ['vendor' => $vendor])
        </div>

        </div>


        <div class="col-md-7" id="right_vendor_info">
          @include('vendor::show.info.vendor_top_right_info', ['vendor' => $vendor])


        </div>

         <div class="col-md-12 " id="contacts">
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Contacts</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-block btn-default btn-xs" data-id="{{$vendor->id}}" data-target="#modal-add-new-contact" data-toggle="modal"><i class="fa fa-plus"></i> Add Contact</button>
                  </div>

                </div><!-- /.box-header -->
                <div class="box-body no-padding dashtbl">
                   <table class="table">
                    <tr>
                      <th>Name</th>
                      <th>Title</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Mobile</th>
                      <th>Created</th>
                      <th>Actions</th>
                    </tr>
                        <tbody id="tbody_contacts">
                        @include('vendor::show.contact.ajax_refresh_contacts', ['vendor->contacts' => $vendor->contacts])

                      </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>

              <div class="col-md-12 " id="customers">
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Customers</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-block btn-default btn-xs" data-id="{{$vendor->id}}" data-target="#modal-add-new-customer" data-toggle="modal"><i class="fa fa-plus"></i> Add Customer</button>
                  </div>

                </div><!-- /.box-header -->
                <div class="box-body no-padding dashtbl">

                   <table class="table">
                    <tr>
                      <th>Customer</th>
                      
                      <th>Authorized Name</th>
                      <th>Phone #</th>
                      <th>Account #</th>
                      <th>Portal User Name</th>
                      <th>Portal Password</th>
                      <th>Created</th>
                      <th>Actions</th>
                    </tr>
                        <tbody id="tbody_customers">
                        @include('vendor::show.customer.ajax_refresh_customers', ['vendor->cutomers' => $vendor->customers])

                      </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>

    </div>



</section>


<!-- /#page-wrapper -->
  {{-- @include('vendor::location.ajax_edit_location_modal') --}}

  @include('vendor::show.contact.ajax_add_contact_modal')

  @include('vendor::show.customer.ajax_add_customer_modal')
  @include('vendor::show.contact.ajax_edit_contact_modal')
  @include('vendor::show.customer.ajax_edit_customer_modal')
  @include('vendor::show.delete_modal')

  @include('vendor::show.contact.delete_modal')
  @include('vendor::show.customer.delete_modal')

  @include('vendor::show.info.ajax_edit')
@endsection
@section('styles')


   <link rel="stylesheet" href="{{URL::asset('css/jquery.businessHours.css')}}">
   <link rel="stylesheet" href="{{URL::asset('css/jquery.timepicker.min.css')}}">
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

div.dashtbl {
    margin-left: 5px;
    margin-right: 5px;
}

button.btn-xs {
    padding: 5px;

}

button.btn-xs i {
    padding: 0 4px 0 4px;
    position: relative;
    top: 1px;
}

dl.dlhorizon {
    width: 220px;
}
dl.dlhorizon dt {
  float:left;
  clear: left;
  width: 120px;
}
dl.dlhorizon dd {
    clear: left;
    float: left;
    margin-left: 70px;
}
dl.dlhorizon dt + dd {
    float: left;
    clear: none;
    margin-left: 0;
}

td.nettd {
    text-align: right;
}

}

button.btn-xs i {
    padding: 0 4px 0 4px;
    position: relative;
    top: 1px;
}

</style>

<!-- table.netTbl tr td {
    vertical-align: top;
}

</style> -->
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
@endsection


@section('script')
@parent


{{-- <script type="text/javascript" src="{{URL::asset('js/highcharts.js')}}"></script> --}}
<script type="text/javascript" src="{{URL::asset('js/jquery.inputmask.js')}}"></script>

   <script type="text/javascript" src="{{URL::asset('js/jquery.businessHours.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/jquery.timepicker.min.js')}}"></script>
{{-- <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script> --}}
<script type="text/javascript">
var EditbusinessHoursManager = {};
    $(document).ready(function()
    {



     $("#businessHoursShowDiv").businessHours({
                    operationTime:{!! html_entity_decode($vendor->business_hours) !!},
                    dayTmpl: '<div class="dayContainer" style="width: 80px;">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"/></div>' +
                        '<div class="weekday"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""/></div>' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""/></div>' +
                        '</div></div>'
                });

      var bHoursContainer = $("#editBusinessHoursContainer");
            EditbusinessHoursManager = bHoursContainer.businessHours({
               operationTime:{!! html_entity_decode($vendor->business_hours) !!},
                postInit:function(){
                    bHoursContainer.find('.operationTimeFrom, .operationTimeTill').timepicker({
                        'timeFormat': 'H:i',
                        'step': 15
                    });
                },
                dayTmpl: '<div class="dayContainer" style="width: 80px;">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"/></div>' +
                        '<div class="weekday"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""/></div>' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""/></div>' +
                        '</div></div>'
            });





     
       


$(".dt_mask").inputmask();
       });
      </script>

@endsection
