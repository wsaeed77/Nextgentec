@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
            Knowledge
    </h1>
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Knowledge
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-xs-12">



            <div class="box">
              <div class="box-header with-border">
                    <h3 class="box-title"> Knowledge</h3>
                </div>
                <div class="box-body">

                  <div class="col-lg-12">

                        <h4 class="box-title bottom-border padding-bottom-8"><b>Passwords</b></h4>


                      <div class="box-body">

                        <div class="table-responsive" id="passwords">

                            <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" id="modaal" data-target="#modal-create-knowledge-password">Add New Password</button>
                          <table class="table table-hover " id="knowledge_pass_dt_table">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>System</th>
                                <th>Login</th>
                                <th>Password</th>
                                <th>Created at</th>
                                <th>Customer</th>
                                <th>Actions</th>
                              </tr>
                              </thead>
                            </table>
                        </div>
                      </div><!-- /.box-body -->
                      <hr/>
                  </div>


                 <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8"><b>Procedures</b></h4>


                    <div class="box-body">
                      <div class="table-responsive" id="procedures">

                            <button type="button" class="btn btn-primary btn-sm pull-right"
                                                        data-toggle="modal" id="modaal" data-target="#modal-create-knowledge-procedure">
                                                          Add New Procedure
                                                      </button>
                          <table class="table table-hover " id="knowledge_procedure_dt_table">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>Title</th>
                              
                                <th>Created at</th>
                                <th>Customer</th>
                                <th>Actions</th>
                              </tr>
                              </thead>


                            </table>


                        </div>

                    </div><!-- /.box-body -->
                    <hr/>
                </div>


                <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8 "><b>Serial Numbers</b></h4>

                    <div class="box-body">
                       <div class="table-responsive" id="serial_numbers">

                            <button type="button" class="btn btn-primary btn-sm pull-right"
                                                        data-toggle="modal" id="modaal" data-target="#modal-create-knowledge-serial-number">
                                                          Add New Serial Number
                                                      </button>
                          <table class="table table-hover " id="knowledge_serial_numbers_dt_table">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>Title</th>
                              <th>Serial #</th>
                                <th>Created at</th>
                                <th>Customer</th>
                                <th>Actions</th>
                              </tr>
                              </thead>


                            </table>


                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>


    </div>
    </div>
    </div>
</section>

 @include('assets::knowledge.ajax_create_knowledge_password')
 @include('assets::knowledge.edit_pass')
 @include('assets::knowledge.delete_password_modal')


 @include('assets::knowledge.ajax_create_knowledge_procedure')
 @include('assets::knowledge.edit_procedure')
 @include('assets::knowledge.delete_procedure_modal')


@include('assets::knowledge.ajax_create_knowledge_serial_number')
 @include('assets::knowledge.edit_serial_number')
 @include('assets::knowledge.delete_serial_number_modal')


 @include('assets::knowledge.show')
{{--@include('crm::ticketstatus.delete_modal_ticket_status')
@include('crm::ticketstatus.ajax_create_ticket_status') --}}

@endsection
@section('script')

<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="/DataTables/datatables.min.js"></script>
{{--  <script src="/colorpicker/bootstrap-colorpicker.min.js"></script> --}}
<script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script>
@endsection

@section('document.ready')
@parent

CKEDITOR.replace( 'password_notes', {
       filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
       filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
   } );

   CKEDITOR.replace( 'procedure', {
       filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
       filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
   } );
     CKEDITOR.replace( 'serial_notes', {
       filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
       filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
   } );


$('.multiselect').multiselect({
    enableFiltering: true,
    includeSelectAllOption: true,
    maxHeight: 400,
    dropUp: false,
    buttonClass: 'form-control',
    onChange: function(option, checked, select) {
        //alert($('#multiselect').val());
    }
});
   $('#knowledge_pass_dt_table').DataTable({
           processing: true,
           serverSide: true,
           "bAutoWidth": false,
          @if((session('cust_id')!='') && (session('customer_name')!=''))
              ajax: '{!! route('admin.knowledge.passwords_by_cust',session('cust_id')) !!}',
          @else
              ajax: '{!! route('admin.knowledge.passwords') !!}',
          @endif
         
           columns: [
               { data: 'id', name: 'id' },
               { data: 'system', name: 'system' },
               { data: 'login', name: 'login' },
               { data: 'password', name: 'password' },
               { data: 'created_at', name: 'created_at' },
               {data: 'customer', name: 'customer', orderable: false, searchable: false},
               {data: 'action', name: 'action', orderable: false, searchable: false}

           ]
       });
$('#knowledge_pass_dt_table_wrapper').addClass('padding-top-40');



$('#knowledge_procedure_dt_table').DataTable({
           processing: true,
           serverSide: true,
           "bAutoWidth": false,
            @if((session('cust_id')!='') && (session('customer_name')!=''))
               ajax: '{!! route('admin.knowledge.procedures_by_cust',session('cust_id')) !!}',
          @else
               ajax: '{!! route('admin.knowledge.procedures') !!}',
          @endif
          
           columns: [
               { data: 'id', name: 'id' },
               { data: 'title', name: 'title' },
              
               { data: 'created_at', name: 'created_at' },
               {data: 'customer', name: 'customer', orderable: false, searchable: false},
               {data: 'action', name: 'action', orderable: false, searchable: false}

           ]
       });
$('#knowledge_procedure_dt_table_wrapper').addClass('padding-top-40');


$('#knowledge_serial_numbers_dt_table').DataTable({
           processing: true,
           serverSide: true,
           "bAutoWidth": false,
            @if((session('cust_id')!='') && (session('customer_name')!=''))
            ajax: '{!! route('admin.knowledge.serial_numbers_by_cust',session('cust_id')) !!}',
          @else
            ajax: '{!! route('admin.knowledge.serial_numbers') !!}',
          @endif
           
           columns: [
               { data: 'id', name: 'id' },
               { data: 'title', name: 'title' },
               { data: 'serial_number', name: 'serial_number' },
               { data: 'created_at', name: 'created_at' },
               {data: 'customer', name: 'customer', orderable: false, searchable: false},
               {data: 'action', name: 'action', orderable: false, searchable: false}

           ]
       });
$('#knowledge_serial_numbers_dt_table_wrapper').addClass('padding-top-40');


@endsection
@section('styles')
@parent
<!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"/> -->
<link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
 <link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/> --}}
   <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"/>

<style>
hr{
  border-style: inset none none;
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
</style>
@endsection
