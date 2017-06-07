@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
         Vendors
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Vendors
        </li>
    </ol>
@endsection

<section class="content">
  <div class="row">
    @if((session('cust_id')=='') && (session('customer_name')==''))
    <div class="col-xs-12">
    @else
    <div class="col-sm-7">
    @endif
      <div id="msg"></div>
      <div class="tab-pane active table-responsive" >
        <table class="table table-hover" id="vendor_dt_table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Created at</th>
               @if((Session::get('cust_id')=='') && (Session::get('customer_name')==''))
              <th>Website</th>
              
              <th>Customers</th>
              @else 
              <th>Location</th>
              <th>action</th>
              @endif 
             
            </tr>
          </thead>
        </table>
      </div><!-- /.tab-pane -->
    </div>
    @if((session('cust_id')!='') && (session('customer_name')!=''))
    <div class="col-sm-5" id="vendor-details">
    </div>
    @endif
  </div>

</section>

@include('admin.partials.delete_modal', [
  'id'=>'modal_vendor_customer_unlink',
  'message' => 'Are you sure you\'d like to remove this vendor association?',
  'url' => 'admin.vendor.customer.unlink',
  'refresh' => true
])

@include('crm::crm.delete_modal_ajax') 
@include('vendor::ajax_edit_customer_modal')
@include('assets::edit')
@endsection
@section('script')
@parent


<script src="{{URL::asset('vendor/summernote/summernote.js')}}"></script>
<script src="{{URL::asset('vendor/summernote/summernote-floats-bs.min.js')}}"></script>
<script src="{{URL::asset('js/select2.full.min.js')}}"></script>

 <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
  <script>

  @include('assets::ajax_functions')
    $(function() {


     

     

      var btn_url = '';
          @if(!empty(Session::get('cust_id')))
               btn_url = "{{URL::route('admin.add.vendors.for.customer')}}";
          @else
               btn_url = "{{ URL::route('admin.vendor.create')}}";
            @endif

    var table = $('#vendor_dt_table').DataTable({
        processing: true,
        serverSide: true,
        //responsive: true,
        bAutoWidth: false,
        pageLength: 25,
        order: [[ 2, "desc" ]],
        ajax: '{!! route('admin.vendors.vendor_index') !!}',
        @if((session('cust_id')!='') && (session('customer_name')!=''))
        dom: '<"col-sm-3 lr-p0"l>Brt<"col-sm-3 lr-p0 controls"i><"col-sm-6 text-center"><"col-sm-3 pull-right lr-p0"p><"clear">',
        @else
        dom: '<"col-sm-3 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-5 text-center"i><"col-sm-3 pull-right lr-p0"p><"clear">',
        @endif
        buttons: [
            {
                text: 'New Vendor',
                className: 'btn-sm',
                action: function ( e, dt, node, config ) {
                    window.location.href = btn_url;
                }
            }
        ],

        columns: [
            { data: 'name', name: 'name',className: "clickable" },
            { data: 'phone_number', name: 'phone_number',className: "clickable" },
            { data: 'created_at', name: 'created_at',className: "clickable" },
            @if((Session::get('cust_id')=='') && (Session::get('customer_name')==''))
            { data: 'website', name: 'website',orderable: false, searchable: false ,className: "clickable"},
            { data: 'customer', name: 'customer',orderable: false, searchable: false, className: "clickable" },
            @else
            {data: 'action', name: 'action', orderable: false, searchable: false, width: "50px", className: "my_class" }
            @endif 


        ],

        "fnDrawCallback": function(){
          var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
          var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
          console.log(pageCount);
          if (pageCount > 1) {
            $('.dataTables_paginate').css("display", "block");
          } else {
            $('.dataTables_paginate').css("display", "none");
          }
        }
    });
          $('#cust_notes').summernote({ 
                   callbacks: {
                            onImageUpload: function(files) {
                            //console.log(files);
                            // console.log($editable);
                          uploadImage(files[0],'vendor','cust_notes');
                          }},
                  lang: 'en-US',
                  dialogsInBody: true,
                  height: 600,                 // set editor height
                  minHeight: null,             // set minimum height of editor
                  maxHeight: null,             // set maximum height of editor
                  focus: true});





    @if((session('cust_id')=='') && (session('customer_name')==''))
      $('#vendor_dt_table tbody').on( 'click', 'tr', function () {
         var route = '{!! route('admin.vendors.index') !!}/show/'+$(this).attr('id');
         window.location.href= route;
      });
    @else
      $('#vendor_dt_table tbody ').on( 'click', 'tr>td.clickable', function (e) {
        //console.log(e);

        if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
        }
        else {
          table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');

          // Load Vendor Details
          // table.row( this ).data().id
          $.get("/admin/vendors/ajax_detail/"+table.row(this).data().id,function(data) {
            $('#vendor-details').html(data);
          },"html");
        }
      });
    @endif


     $('.edit ').on( 'click', function (e) {

        //event.preventDefault();
        console.log('hhhh');
      });
  });


</script>
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
 </style>

  <link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
  
  <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">
  <link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">


<style>
@if((session('cust_id')!='') && (session('customer_name')!=''))
.btn-group {
  float: right;
}
@endif
table.dataTable tr.selected {
  background-color: #f7f7f7;
}
.table-responsive .controls div {
  text-align: left !important;
}
.lr-p0 {
  padding-left: 0;
  padding-right: 0;
}
.bot_10px{
  margin-bottom: 10px;
}
.table-responsive {
  /*overflow-x: hidden;*/
}
.top-border {
  border-top: 1px solid #f4f4f4;
}
.top-10px{
  top: 10px;
}
.top-18px{
  top: 18px;
}
.bot_10px{
  margin-bottom: 10px;
}

.relative{
  position: relative;
}
.left-15px{
  left: 15px;
}

</style>
@endsection
