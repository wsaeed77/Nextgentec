@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
            Passwords
    </h1>
        {{-- <small>preview of simple tables</small> --}}

    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Knowledge
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Passwords
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
      <div class="tab-pane active table-responsive" id="passwords">
        <table  class="table-hover display table responsive nowrap" cellspacing="0" width="100%" id="knowledge_pass_dt_table">
          <thead>
            <tr>
            <th>Login</th>
            <th>Tags</th>
             <th>Device</th>
            @if((Session::get('cust_id')=='') && (Session::get('customer_name')==''))
            <th>Customer</th>
            @endif
            <th>action</th>
            </tr>
          </thead>
        </table>
      </div><!-- /.tab-pane -->

    </div>
    @if((session('cust_id')!='') && (session('customer_name')!=''))
    <div class="col-sm-5" id="password-details">
    </div>
    @endif
  </div>

</section>



@include('assets::knowledge.ajax_create_knowledge_password')
@include('assets::knowledge.edit_pass')
 @include('assets::show')
 @include('admin.partials.delete_modal', [
   'id'=>'modal_password_delete',
   'message' => 'Are you sure you\'d like to delete this password?',
   'url' => 'admin.knowledge.delete.password',
   'refresh' => true
 ])

@include('assets::knowledge.ajax_create_tag_password')
@include('assets::show')

@include('assets::knowledge.show')

@include('assets::knowledge.show_vendor')
{{--@include('crm::ticketstatus.delete_modal_ticket_status')
@include('crm::ticketstatus.ajax_create_ticket_status') --}}

@endsection
@section('script')

<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
{{--  <script src="/colorpicker/bootstrap-colorpicker.min.js"></script> --}}
<script src="{{URL::asset('js/select2.full.min.js')}}"></script>
@endsection

@section('document.ready')
@parent

{{-- <script> --}}
$(".select2").select2({
          tags: true
        });



   $('#knowledge_pass_dt_table').DataTable({
           processing: true,
           serverSide: true,
           bAutoWidth: false,
           pageLength: 25,
           order: [[ 0, "asc" ]],
           @if((session('cust_id')!='') && (session('customer_name')!=''))
           dom: '<"col-sm-3 lr-p0"l>Brt<"col-sm-3 lr-p0 controls"i><"col-sm-6 text-center"><"col-sm-3 pull-right lr-p0"p><"clear">',
           ajax: '{!! route('admin.knowledge.passwords_by_cust',session('cust_id')) !!}',
           @else
           dom: '<"col-sm-3 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-5 text-center"i><"col-sm-3 pull-right lr-p0"p><"clear">',
           ajax: '{!! route('admin.knowledge.passwords') !!}',
           @endif
            buttons: [
                {
                    text: 'New Password',
                    className: 'btn-sm',
                    action: function ( e, dt, node, config ) {
                      $('#modal-create-knowledge-password').modal('toggle');
                    }
                }
            ],

           columns: [
             { data: 'login', name: 'login', className: "clickable"},
             { data: 'hashtags', name: 'hashtags',orderable: false, searchable: false,className: "clickable"},
             { data: 'device', name: 'device',orderable: false, searchable: false},
             @if((Session::get('cust_id')=='') && (Session::get('customer_name')==''))
             {data: 'customer', name: 'customer', orderable: false, searchable: false, className: "clickable"},
             @endif
             {data: 'action', name: 'action', orderable: false, searchable: false, width: "50px", className: "my_class" }
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

       @if((session('cust_id')=='') && (session('customer_name')==''))

       @else
         $('#knowledge_pass_dt_table tbody ').on( 'click', 'tr>td.clickable', function (e) {
           console.log($(this).parent().attr('id'));

           $('#knowledge_pass_dt_table tr').removeClass('selected');
           $(this).parent().addClass('selected');

           // Load Vendor Details
           // table.row( this ).data().id
           $.get("/admin/knowledge/ajax_detail/"+$(this).parent().attr('id'),function(data) {
             $('#password-details').html(data);
           },"html");

         });
       @endif



@endsection
@section('styles')
@parent
<!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"/> -->
<link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
 <link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/> --}}
  <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">

<style>
hr {
  border-style: inset none none;
}

@if((session('cust_id')!='') && (session('customer_name')!=''))
.btn-group {
  float: right;
}
@endif

.selected {
  background-color: #f7f7f7;
}

.lr-p0 {
  padding-left: 0;
  padding-right: 0;
}

.table-responsive .controls div {
  text-align: left !important;
}

.nav-tabs-custom {

    box-shadow: 0 1px 1px 1px rgba(0, 0, 0, 0.1) !important;

}
.bottom-border {
    border-bottom: 1px solid #f4f4f4;
}
.padding-bottom-8{
    padding-bottom: 8px;
}
.padding-top-10{
  padding-top: 10px;
}
.padding-top-40{
  padding-top: 40px;
}




    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
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

   .border-top {
    border-top: 1px solid #f4f4f4;
}
a{
  cursor: pointer;
}
</style>
@endsection
