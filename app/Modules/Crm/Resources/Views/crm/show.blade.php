@extends('admin.main')
@section('content')

@section('content_header')
<h1>Customer Dashboard</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
  </li>
  <li class="active">
    <i class="fa fa-table"></i>  Customer
  </li>
</ol>
@endsection

<section class="content">
  <div class="col-lg-2 col-fixed-left-lg">

    <div class="well oh">
      <a role="button" class="b ellipsis ib dashed_" data-id="{{$customer->id}}" data-trigger="focus" data-target="#modal-edit-customer-info"   data-toggle="modal">{{$customer->name}}</a>
      <div class="bs-callout bs-callout-grey bs-callout-white-fill">
        <div class="b5">
          <label class="block">Domain</label>
          <div class="pull-right"><a href="#" id="email_domain" data-onaftersave="editableSave(customer)" data-type="text" data-placement="right">{{ $customer->email_domain}}</a></div>
        </div>
        <div class="b5">
          <label class="block">Main Number</label>
          <div class="pull-right">
            @foreach($customer->locations as $location)
            @if($location->default)
            <a href="#call" data-dest="{{$location->phone}}" class="ctc-call-trigger">{{$location->phone}}</a>
            @endif
            @endforeach
          </div>
        </div>
        <div class="b5">
          <label class="block">Customer Since</label>
          <div class="pull-right">{{ date('F Y',strtotime($customer->customer_since)) }}</div>
        </div>
        <div class="b5">
          <label class="block">Status</label>
          <div class="pull-right">
            <a href="#" id="is_active" e-ng-true-value="1" e-ng-false-value="0">
              @if(!$customer->is_active)
              {{$customer->is_active = 0}}
              @endif
            </a>
          </div>
        </div>
        <div class="b5">
          <label class="block">Credit Usage</label>
          <div class="pull-right">
            <span id="standing_percent" class="badge bg-green pull-right"></span>
          </div>
        </div>
      </div>

      <div class="f14 titleBeforeBreak" style="clear: both;">Quick Facts</div>
      <div class="breakgreen"></div>
      <div class="bs-callout bs-callout-grey bs-callout-white-fill">
        <div class="b5">
          <label class="block">Locations</label>

          <ul style="list-style-type:none;" class="pull-right">
            @foreach($customer->locations as $location)
            <li>{{$location->location_name}}</li>
            @endforeach
          </ul><div class="clearfix"></div>
          <label class="block">Products</label>
          <a data-trigger="focus" data-target="#modal-product-tag-assign"   data-toggle="modal" class="pull-right"><i class="fa fa-plus"></i></a>
          <div class="clearfix"></div>

          @foreach($customer->products as $product)
          @if(!empty($product->fa_icon))
          <span class="label label-success mt5" title="{{$product->short_desc}}"><i class="fa {{$product->fa_icon}} fw bg-tp" style="padding-right: 3px;"></i> {{$product->name}}</span>
          @else
          <span class="label label-success" title="{{$product->short_desc}}">{{$product->name}}</span>
          @endif
          @endforeach
          <!-- <span class="label label-default">Default Label</span><span class="label label-success">Success Label</span><span class="label label-info">Info Label</span> -->

        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 col-fixed-left-lg-offset">
    @include('crm::crm.dashboard.tabs', ['customer' => $customer])
  </div>

{{-- data for user device extention --}}
 <input type="hidden" value="{{ $device_extention['saved']}}" id="is_saved">
 <input type="hidden" value="{{ $device_extention['extention']}}" id="device_extention">
 <input type="hidden" value="{{$customer->id}}" id="customer_id">

  <div class="row">

    <div class="col-md-3">
      <button type="button" class="btn btn-block btn-default btn-xs" data-id="{{$customer->id}}" data-target="#modal-activity" data-toggle="modal"><i class="fa fa-plus"></i> New Activity</button>
      <div id="info_msg"></div>
      <div class="hidden" id="info-popover-content">
        <div class="box box-widget widget-user">
          @include('crm::crm.info.ajax_refresh_info', ['customer' => $customer])
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

  @include('admin.partials.delete_modal', [
    'id'=>'modal_contact_delete',
    'message' => 'Are you sure you\'d like to remove this contact?',
    'url' => 'admin.crm.ajax.del_contact',
    'refresh' => true
    ])

  @include('admin.partials.delete_modal', [
    'id'=>'modal_location_delete',
    'message' => 'Are you sure you\'d like to remove this location?',
    'url' => 'admin.crm.ajax.del_location',
    'refresh' => true
    ])

    @include('crm::crm.rate.delete_modal_ajax')
    @include('crm::crm.service_item.delete_modal_ajax')
    @include('crm::crm.delete_modal_ajax')

    @include('crm::crm.dashboard.activity_modal')
    @include('crm::crm.dashboard.modals.warning')

    @include('crm::crm.product_tag_assign_modal_ajax')

    @endsection
    @section('styles')
    <link href="{{URL::asset('x-editable/bootstrap-editable.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('css/datepicker.css')}}" rel="stylesheet" />
    <style>

      @media screen and (min-width: 1500px) {
        .ng-col-xl-6 {
          width: 50%;
        }
        .ng-col-xl-4 {
          width: 33.33333%;
        }
      }


      @media screen and (min-width: 800px) {
        .info-box-content {
          margin-left: 75px !important;
        }
        .contactwell {
          min-height: 160px;
        }
      }

      @media (max-width: 767px) {
        .content {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
        .info-box-content {
          margin-left: 0px !important;
        }
      }

      .divider {
        position: relative;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 25px;
        margin-top: 10px;
      }

      .list-form-item {
        background-color: #F8F8F8;
        border-top: 1px solid #DEDEDE;
        border-bottom: 1px solid #DEDEDE;
        padding: 10px;
      }

      .list-form-item-white {
        background-color: White;
      }

      .span-black {
        color: #333 !important;
      }
      .breakgray {
        display: block;
        border-top: 1px solid #000000;
        height: 0px;
        width: 100%;
      }
      .ib {
        display: inline-block !important;
      }
      .f16 {
        font-size: 16px !important;
        line-height: 16px;
      }
      .b {
        font-weight: bold;
      }
      .ellipsis {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
      }
      .breakgreen {
        width: 100%;
        border-top: 1px solid #8FBB23;
        height: 0px;
      }

      .b5 {
        margin-bottom: 5px;
      }

      .titleBeforeBreak {
        margin-bottom: 6px;
      }
      .tp24 {
        padding-top: 24px;
      }
      .f14 {
        font-size: 14px !important;
        line-height: 14px;
      }
      .t24 {
        margin-top: 24px;
      }

      .mt5 {
        margin-top: 5px;
      }
      .mr10 {
        margin-right: 10px;
      }
      .mr5 {
        margin-right: 5px;
      }
      .badge.btn-success {
        background-color: #5cb85c;
      }
      .padding_l_r_20{
        padding: 0 20px;
      }

      h3.panel-title.pull-left {
        width: 65%;
      }

      .info-box {
        min-height: 75px !important;
      }

      .info-box-icon {
        height: 75px !important;
        line-height: 75px !important;
        width: 75px !important;
      }

      .info-box-content {
        margin-left: 75px !important;
      }

      .no-gutter{
        padding-left: 0px;
        padding-right: 0px;
      }
      .no-margin {
        margin: 0;
      }

      div.dashtbl {

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

      table tr.spacer {
        height: 10px;
      }
      table tr.netTbl td {
        padding: 10px !important;
      }

      tbody#loc_networks tr.trb td {
        padding: 10px 10px 0 10px;
        border-top: 1px solid #DEDEDE;
      }

      tbody#loc_networks tr.locnetHead td {
        padding: 10px !important;
        border-top: 1px solid #DEDEDE;
        border-bottom: 1px solid #DEDEDE;
      }

      button.btn-xs i {
        padding: 0 4px 0 4px;
        position: relative;
        top: 1px;
      }
      /* Calendar */
      .fc-toolbar h2 {
        font-size: 1.1em;
        padding-top: 3px;
      }
      .box-body .fc {
        margin-top: 0px !important;
      }
      .fc-button {
        height: auto !important;
      }

      .popover{
        max-width: 100%; /* Max Width of the popover (depending on the container!) */
      }

      .ng-hand {
        cursor: pointer;
      }
      .dashed_{
        border-bottom: 1px dashed;
      }
    </style>

<!-- table.netTbl tr td {
    vertical-align: top;
}

</style> -->
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/jquery-confirm.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{URL::asset('vendor/iCheck/all.css')}}">
@endsection
@section('script')
<script src="{{URL::asset('x-editable/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript" src="{{URL::asset('js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/jquery.inputmask.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/jquery-confirm.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/bootstrap-tabdrop.js')}}"></script>
<script src="{{URL::asset('vendor/iCheck/icheck.min.js')}}"></script>
<script src="{{URL::asset('vendor/summernote/summernote.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function() {
$('.nav-tabs').tabdrop();
    var activetab;

      // go to the latest tab, if it exists:
      var lastTab = localStorage.getItem('lastTab');
      if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
      }

      // Xeditable
      $.fn.editable.defaults.mode = 'popup';
      $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit"><i class="glyphicon glyphicon-ok bg-tp"></i></button>'+
      '<button type="button" class="btn btn-default btn-sm editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';

      $('#email_domain').editable({
        url: '/admin/crm/save_customer/',
        clear: false,
        pk: {{session('cust_id')}}
      });

      $('#is_active').editable({
        type: 'checklist',
        url: '/admin/crm/save_customer/',
        pk: {{session('cust_id')}},
        placement: 'right',
        value: {{$customer->is_active}},
        autotext: 'always',
        source: [{value: 1, text: "Active"}],
        emptytext: 'disabled'
      });

      //iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'icheckbox_square-blue'
      });

      // Info Popover
      $(function(){
        $("#info-popover").popover({
          placement: 'bottom',
          html : true,
          content: function() {
            return $("#info-popover-content").html();
          }
        });
      });

      // Network row show/hide function
      $('.tbltoggle').click(function() {
        $('#netdl-'+$(this).data("id")).slideToggle(200);
        $('#nettd-'+$(this).data("id")).toggleClass("nettd");
        $('#nettr-'+$(this).data("id")).toggleClass("locnetHead");

        var netsn = $('#netsn-'+$(this).data("id"))
        if(netsn.is(":visible"))
          netsn.hide();
        else
          netsn.delay(200).show(0);
        $('#icn-'+$(this).data("id")).toggleClass("fa-plus-square-o fa-minus-square-o");
        return false;
      });

      // Notes show/hide
      $('.notestoggle').click(function() {
        console.log($(this).data("target"));
        $('#'+$(this).data("target")).slideToggle(200);
        $(this).find('i').toggleClass("glyphicon-chevron-down glyphicon-chevron-right");
        return false;
      });

      // Load Account Standing
      $.get("{{ URL::route('admin.crm.api.accountstanding',$customer->id)}}",function(data) {
        var obj_data = JSON.parse(data);
        $('#standing_percent').html(obj_data['credit_limit_used']);
        if(obj_data['credit_limit_standing'] == 'warning') {
          $('#standing_percent').toggleClass("bg-green bg-yellow");
        } else if(obj_data['credit_limit_standing'] == 'overlimit') {
          $('#standing_percent').toggleClass("bg-green bg-red");
          $('#modal-warning').modal('show');

          var items = [];
          $.each(obj_data['overdue'], function(i, item) {
           items.push('<li class="item"><div><a href="javascript:void(0)" class="product-title">' +
            item.subject + '<span class="label label-warning pull-right">'+item.status+'</span></a></li>' +
            '<span class="product-description">'+item.note+'</span></div></li>');
          });  // close each()
          $('.note-list').append( items.join('') );
        }
      },"html");

      // Dashboard TABS, Run on Click
      $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        activetab = $(e.target).attr('href');

          // Save tab incase of refresh
          localStorage.setItem('lastTab', activetab);

          // INVOICES TAB
          if (activetab == "#invoices_tab") {
            $('#recurringspin').removeClass('ng-hide');
            $('#unpaidspin').removeClass('ng-hide');

            // Load Recurring Invoices
            $.get("{{ URL::route('admin.crm.api.recurringinvoices',$customer->id)}}",function(data) {
              var obj_data = JSON.parse(data);

              var items = [];
              $.each(obj_data, function(i, item) {
                var icon = '';
                if (item['autoBill']) {
                  icon = '<i class="fa fa-credit-card fa-fw" title="Credit Card Autopay Enabled" style="padding-right: 5px;"></i>';
                }
                $('#recurringInvoices > tbody:last-child').append('<tr><td>'+icon+' '+item['name']+
                  '</td><td>'+item['status']+'</td><td>'
                  +item['totalAmt']+'</td></tr>');
              });  // close each()
              $('#recurringspin').addClass('ng-hide');
            },"html");

            // Load Unpaid Invoices
            $.get("{{ URL::route('admin.crm.api.invoices', ['id' => $customer->id, 'status' => 'unpaid'])}}",function(data) {
              var obj_data = JSON.parse(data);

              var items = [];
              $.each(obj_data, function(i, item) {
                var icon = '';
                var status = '';
                if (item['status'] == 'overdue') {
                  icon = '<i class="fa fa-exclamation fa-fw text-red" title="'+item['due_days']+'" style="padding-right: 5px;"></i>';
                  status = item['due_days'];
                } else {
                  status = item['status'];
                }
                $('#unpaidInvoices > tbody:last-child').append('<tr><td>'+icon+' <a target="_blank" href="'+item['url']+'" title="View Invoice">'+item['invoice_number']+
                  '</a></td><td>'+status+'</td><td>'
                  +item['balance']+'</td></tr>');
              });  // close each()
              $('#unpaidspin').addClass('ng-hide');
            },"html");

          } else {
            // Clear Invoices
            $('#recurringInvoices tbody > tr').remove();
            $('#unpaidInvoices > tbody > tr').remove();
          }
        });

      // Load Notes
      // $.get("{{ URL::route('admin.crm.note.list',$customer->id)}}",function(data) {
      //
      //   var items = [];
      //   $.each(JSON.parse(data), function(i, item) {
      //          items.push('<li class="item"><div><a href="javascript:void(0)" class="product-title">' +
      //                   item.subject + '<span class="label label-warning pull-right">'+item.status+'</span></a></li>' +
      //                   '<span class="product-description">'+item.note+'</span></div></li>');
      //   });  // close each()
      //   $('.note-list').append( items.join('') );
      //
      //   },"html");

      //load the location list
      // $.get("{{ URL::route('admin.crm.ajax.list_locations',$customer->id)}}",function( data_response ) {
      //   $('#locations_tbl').html(data_response);
      //
      //   // Click to Call Trigger
      //   $('.loc-call-trigger').click(function(e) {
      //     e.preventDefault();
      //     clicktocall($(this).data("dest"));
      //   });
      // },"html");

      // load the contacts list
      // $.get("{{ URL::route('admin.crm.ajax.refresh_contacts',$customer->id)}}",function( data_response ) {
      //   $('#loc_contacts').html(data_response);

        // Click to Call Trigger
        $('.ctc-call-trigger').click(function(e) {
          e.preventDefault();
          clicktocall($(this).data("dest"));
        });

//      },"html");

      // Click to call functionality
      function clicktocall(dataid) {
        var num;
        if(typeof str == 'string') {
          num = dataid.replace(/[^0-9.]/g, "");
        } else {
          num = dataid;
        }
        
        if($('#is_saved').val()==1){
           device_extention_textfield='<input type="text" placeholder="Desk Extention / Mobile Number" id="extention" class="form-control" value="'+$('#device_extention').val()+'" readonly />';
           device_extention_checkbox='<input type="checkbox" id="save" value="1" disabled>';
        }else{
           device_extention_textfield='<input type="text" placeholder="Desk Extention / Mobile Number" id="extention" class="form-control" required />';
           device_extention_checkbox='<input type="checkbox" id="save" value="1" >';
        }
        
        $.confirm({
          title: 'Call Confirmation',
          animation: 'scale',
          animationClose: 'top',
          opacity: 0.5,
          confirmButton: 'Dial',
          cancelButton: 'Cancel',
          icon: 'fa fa-question-circle',
          content: 'Would you like to dial the phone number:<br>'+dataid+'<br>'+
          '<form action="" class="formName">' +
          '<div class="form-group">' +
          '<label>Your Desk Extention/Mobile Number:</label>' +device_extention_textfield+
          '</div>'+
          '<div class="checkbox">'+
          '<label>'+device_extention_checkbox+'Save Extention</label>'+
          '</div>'+
          '<br>'+
          '</form>'
          ,
          buttons: {
            formSubmit: {
              text: 'Dial',
              btnClass: 'btn-blue',
              action: function () {
                var extention = this.$content.find('#extention').val();
                var numberRegx = /^\+?\d+$/;
                if(!numberRegx.test(extention)){
                  $.alert('provide a valid extention');
                  return false;
                }else{
                  /*****populate the hidden fields if save extention is checked****/
                  if($('#save').is(':checked')){
                    $('#is_saved').val(1);
                    $('#device_extention').val($('#extention').val());
                  }
                  $.ajax({
                    url: '{{ url('admin/crm/ajax_click_call')}}/'+num+'/'+$('#extention').val()+'/'+$('#customer_id').val()+'/'+$('#save').is(':checked'),
                    type: 'GET',
                    dataType: 'HTML',
                    success: function(response){
                      console.log('success');
                    }
                  });
                }
              }
            },
            cancel: function(){}
          }
        });
        return;
      }

      //load service items list
      $.get("{{ URL::route('admin.crm.ajax.list_service_item',$customer->id)}}",function( data_response ) {
        $('#service_items_table').html(data_response);

      },"html");

       //load Rates list
       $.get("{{ URL::route('admin.crm.ajax.list_rate',$customer->id)}}",function( data_response ) {
        $('#rates_table').html(data_response);

      },"html");


      // $.get(APP_URL+'/admin/crm/zoho_get_expenses/{{$customer->zohoid}}',function( response ) {
      //   $('#container').highcharts({
      //   chart: {
      //       type: 'column'
      //   },
      //   title: {
      //       text: 'Expenses And Income'
      //   },
      //   subtitle: {
      //       text: 'Source: Zoho Invoice'
      //   },
      //   xAxis: {
      //       categories: [
      //           'Jan',
      //           'Feb',
      //           'Mar',
      //           'Apr',
      //           'May',
      //           'Jun',
      //           'Jul',
      //           'Aug',
      //           'Sep',
      //           'Oct',
      //           'Nov',
      //           'Dec'
      //       ],
      //       crosshair: true
      //   },
      //   yAxis: {
      //       min: 0,
      //       title: {
      //           text: 'Amount'
      //       }
      //   },
      //   tooltip: {
      //       headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      //       pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      //           '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
      //       footerFormat: '</table>',
      //       shared: true,
      //       useHTML: true
      //   },
      //   plotOptions: {
      //       column: {
      //           pointPadding: 0.2,
      //           borderWidth: 0
      //       }
      //   },
      //   series: [{
      //       name: 'Expense',
      //       data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
      //
      //   }, {
      //       name: 'Income',
      //       data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
      //
      //   }]
      //   });
      //
      // });

    });
  </script>

  @endsection