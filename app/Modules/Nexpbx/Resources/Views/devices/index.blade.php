@extends('admin.main')


@section('styles')
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
@endsection
@section('content')


<!-- Content Header (Page header) -->
@section('content_header')
<h1>
  NexPBX Devices

</h1>
<ol class="breadcrumb">
  <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">NexPBX</li>
</ol>
@endsection
<div id="msg">@if(Session::has('status'))
  <p class="alert alert-success">{{ Session::get('status') }}</p>
  @endif</div>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <table class="table table-hover" style="cursor:pointer" id="dt_table">
          <thead>
            <tr>
              <th></th>
              <th>Domain Name</th>
              <th>Domain Description</th>
              <th>Domain UUID</th>

            </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>

  <div class="modal fade" id="assign-customer-modal" tabIndex="-1">
    <div class="modal-dialog  modal-md" >
      <div class="modal-content" >
        <div class="modal-header">

          <h4 class="modal-title">Assign To Customer</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div id="alert_modal"></div>
            <form id="assign_customer_form">

              <div class="col-lg-8">
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <div class="form-group">
                  <label>Customers</label>
                  {!! Form::select('customer_id', $enabled_customers,null ,['class'=>'form-control','id'=>'assigning_custumers','name'=>'assigning_custumers','placeholder' => 'Pick a location','required'=>''])!!}

                </div>
                <div class="form-group" style="display:none" >
                  <label>Customer Locations</label>
                  {!! Form::select('customer_location_id', $current_customer_locations,null ,['class'=>'form-control multiselect','id'=>'cust_location','name'=>'cust_location','placeholder' => 'Pick a location'])!!}
                </div>
                <input type="hidden" name="selected_domains" id="selected_domains">
              </div>
            </form>
            <div class="clearfix"></div>
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <div class="col-lg-8">
              <input type="hidden" name="status_id" value="">
              <button id="usrupdate" class="btn btn-primary assign_customer">Assign</button>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_user">Close</button>

          </div>

        </div>

      </div>
    </div>
  </div>

  @endsection
  @section('script')

  <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
  <script src="{{URL::asset('js/jquery.checkboxes-1.2.0.js')}}"></script>
  <script type="text/javascript">

   $(function() {
    alert_hide();
    $( ".assign_customer" ).click(function()
    {
      console.log($('#assign_customer_form').serialize());
      customer = $('#assigning_custumers').val();


      if(customer == ''){
        $('#alert_modal').html('<div  class="alert alert-danger">Please select a customer.</div>');
        alert_hide();

      }else{


        $.ajax({
          url: "{{ URL::route('admin.nexpbx.assign.customer')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#assign_customer_form').serialize(),
        success: function(response){
          if(response.success) {
            location.reload();


          }
        },
        error: function(data){
        //in case of error
      }
    });
      }
    });



    $('#assigning_custumers').multiselect({
      enableFiltering: true,
      includeSelectAllOption: false,
      maxHeight: 400,
      buttonWidth: '100%',
      dropUp: false,
      buttonClass: 'form-control',
      enableCaseInsensitiveFiltering: true,
      onChange: function(element, checked) {
       //  if(element.val() !=''){

       //    $.get('/admin/nexpbx/locations_list_json/'+element.val(),function(response) {

       //      $('#cust_location').html('');
       //      $('#cust_location').multiselect('enable');
       //      $('#cust_location').append($("<option></option>")
       //       .attr("value",'')
       //       .text('Select location'));
       //      $.each(response.locations,function(index, location_data) {
       //                              //console.log(location_data);
       //                              $('#cust_location').append($("<option></option>")
       //                               .attr("value",location_data.id)
       //                               .text( location_data.location_name));

       //                            });

       //      $('#cust_location').multiselect('rebuild');
       //      $('#cust_location').multiselect('refresh');

       //    },'json');
       //  }else{
       //   $('#cust_location').html('');
       //   $('#cust_location').multiselect('enable');
       //   $('#cust_location').append($("<option></option>")
       //    .attr("value",'')
       //    .text('Select location'));
       //   $('#cust_location').multiselect('rebuild');
       //   $('#cust_location').multiselect('refresh');
       // }
     }

   });





    $('#dt_table').checkboxes('range', true);

    var table = $('#dt_table').DataTable({
     processing: true,
     serverSide: true,
     pageLength: 25,
     searching: false,
     bAutoWidth: false,
     ajax: '{!! route('admin.nexpbx.dt_devices') !!}',
     columnDefs: [ {
       searchable: false,
       orderable: false,
       width: '1%',
       targets:   0,
       className: 'dt-body-center',
       render: function (data, type, full, meta){

         return '<input type="checkbox" name="device_item" id="device_item" class="chk device_item" value="'+full.id+'">';
       }
     } ],
     order: [[ 1, 'asc' ]],
     columns: [ null,

     {data: 'domain_name', name:'domain_name'},
     {data: 'domain_description', name:'domain_description'},
     {data: 'domain_uuid', name:'domain_uuid'},
     ],
     dom: '<"col-sm-5 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-2 lr-p0"l><"col-sm-5 text-center"i><"col-sm-5 lr-p0"p><"clear">',
     buttons: [
     {
      text: 'Select All',
      className: 'btn-sm select btn',
      action: function ( e, dt, node, config ) {
                         //assets_tbl.ajax.url( '{!! route('admin.assets.all') !!}' ).load(function() {
                          $('.chk').prop('checked', true);
                       //window.location = "{{ URL::route('admin.assets.create')}}";

                       $.each(dt_zoho.buttons('.btn'),function(ind,txt){
                        $(txt.node).addClass('unbold');
                      });

                       $(dt_zoho.buttons('.select')[0].node).addClass('bold').removeClass('unbold');

                          // $('#top_heading').html('Assests');

                        //});
                      }

                    },
                    {
                      text: 'UnSelect',
                      className: 'btn-sm unselect btn',
                      action: function ( e, dt, node, config ) {
                         //assets_tbl.ajax.url( '{!! route('admin.assets.all') !!}' ).load(function() {
                          $('.chk').prop('checked', false);
                       //window.location = "{{ URL::route('admin.assets.create')}}";

                       $.each(dt_zoho.buttons('.btn'),function(ind,txt){
                        $(txt.node).addClass('unbold');
                      });

                       $(dt_zoho.buttons('.unselect')[0].node).addClass('bold').removeClass('unbold');

                          // $('#top_heading').html('Assests');

                        //});
                      }

                    },

                    {
                     text: 'New Password',
                     className: 'btn-sm',
                     action: function ( e, dt, node, config ) {
                       $('#modal-create-knowledge-password').modal('toggle');
                     }
                   },
                   {
                     text: 'Assign Customer',
                     className: 'btn-sm',
                     action: function ( e, dt, node, config ) {
                       var open=false;
                       var checkedValues = $('.device_item:checked').map(function() {
                         open=true;
                       }).get();
                       if(open){
                        $('#assign-customer-modal').modal('toggle');
                      }else{
                       $('#msg').html('<div  class="alert alert-danger">Please select a device to assign.</div>');
                       alert_hide();
                     }
                   }
                 }
                 ],
                 "fnDrawCallback": function(){
                   var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
                   var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
                   // console.log(pageCount);
                   if (pageCount > 1) {
                     $('.dataTables_paginate').css("display", "block");
                   } else {
                     $('.dataTables_paginate').css("display", "none");
                   }
                 }
               });


$("#assign-customer-modal").on('shown.bs.modal', function () {

  if($('#assigning_custumers').val()!=''){
    $.get('/admin/nexpbx/locations_list_json/'+$('#assigning_custumers').val(),function(response) {

      $('#cust_location').html('');
      $('#cust_location').multiselect('enable');
      $('#cust_location').append($("<option></option>")
       .attr("value",'')
       .text('Select location'));
      $.each(response.locations,function(index, location_data) {
                                    //console.log(location_data);
                                    $('#cust_location').append($("<option></option>")
                                     .attr("value",location_data.id)
                                     .text( location_data.location_name));

                                  });

      $('#cust_location').multiselect('rebuild');


      $('#cust_location').multiselect('refresh');

    },'json');
  }

  var checkedValues = $('.device_item:checked').map(function() {
   return this.value;
 }).get().join(',');
  $('#selected_domains').val(checkedValues);
});




});
</script>


@endsection
@section('styles')
<style>
  div.dataTables_paginate {
    float: right;
  }

  div.dataTables_paginate ul.pagination {
    margin: 0px;
  }
</style>
@endsection
