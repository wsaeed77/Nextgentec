@extends('admin.main')
@section('content')
@section('content_header')
<h1>
 Nexpbx
</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
  </li>
  <li class="active">
    <i class="fa fa-table"></i> Nexpbx
  </li>
  <li class="active">
    <i class="fa fa-table"></i> Attach Domain
  </li>
</ol>
@endsection
<div id="msg">@if(Session::has('status'))
  <p class="alert alert-success">{{ Session::get('status') }}</p>
  @endif</div>
  <section class="content">
    <div class="row">
     <div class="col-xs-12">
       <div id="err_msgs"></div>
       <div class="clearfix"></div>
       <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title ">Assign Domains</h3>
        </div>
        <div class="box-body">
          <form id="assign_customer_form">
            <div class="row margin-above">
            <div class="col-lg-12 ">
                <div class="form-group">
                  <label>Select Domains from list below</label>
                  <input type="hidden" name="selected_domains" id="selected_domains">
                  <input type="hidden" name="assigning_custumers" id="assigning_custumers" value="{{Session::get('cust_id')}}">
                  <button id="usrupdate" href="" class="btn btn-primary pull-right assign_customer">Assign</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="tab-pane active table-responsive" >
                  <table class="table table-hover"  style="cursor:pointer" id="devices_table">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Domain Name</th>
                        <th>Description</th>
                        <th>Domain uuid</th>
                  
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
@section('styles')
<link rel="stylesheet" href="/DataTables/datatables.min.css">
<style>
 .bot_10px{
  margin-bottom: 10px;
}
.table-responsive {

  //overflow-x: hidden;
}
.margin-above{
  margin-top: 20px
}
</style>

@endsection


@section('script')
@parent
<script src="{{URL::asset('js/select2.full.min.js')}}"></script>
<script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
<script type="text/javascript">
  var table = $('#devices_table').DataTable({
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
   dom: '<"col-sm-12 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-2 lr-p0"l><"col-sm-5 text-center"i><"col-sm-5 lr-p0"p><"clear">',
   buttons: [
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


  $(function() {

    $( ".assign_customer" ).click(function()
    {

      var checkedValues = $('.device_item:checked').map(function() {
       return this.value;
     }).get().join(',');

      $('#selected_domains').val(checkedValues);

      customer = $('#assigning_custumers').val();


      if(checkedValues == ''){
        $('#msg').html('<div  class="alert alert-danger">Please select domain.</div>');
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

            window.location="{{ URL::route('admin.assets.nexpbx')}}";


          }
        },
        error: function(data){
        //in case of error
      }
    });
      }


      return false;
    });
  });

</script>

@endsection