@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
            Serial Numbers
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Knowledge
        </li>
         <li class="active">
            <i class="fa fa-gears"></i> Serial Numbers
        </li>
    </ol>
@endsection

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive" id="serial_numbers">

        <table class="display table-hover table responsive nowrap" cellspacing="0" width="100%" id="knowledge_serial_numbers_dt_table">
          <thead>
            <tr>
              <th>Title</th>
            <th>Serial #</th>
              <th>Created at</th>
              <th>Customer</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</section>

@include('assets::knowledge.ajax_create_knowledge_serial_number')
 @include('assets::knowledge.edit_serial_number')

 @include('admin.partials.delete_modal', [
   'id'=>'modal_serial_delete',
   'message' => 'Are you sure you\'d like to delete this serial?',
   'url' => 'admin.knowledge.delete.serial',
   'refresh' => true
 ])

 @include('assets::knowledge.show')
{{--@include('crm::ticketstatus.delete_modal_ticket_status')
@include('crm::ticketstatus.ajax_create_ticket_status') --}}

@endsection
@section('script')

<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
{{--  <script src="/colorpicker/bootstrap-colorpicker.min.js"></script> --}}

@endsection

@section('document.ready')
@parent

$('#knowledge_serial_numbers_dt_table').DataTable({
           processing: true,
           serverSide: true,
           "bAutoWidth": false,
            @if((session('cust_id')!='') && (session('customer_name')!=''))
            ajax: '{!! route('admin.knowledge.serial_numbers_by_cust',session('cust_id')) !!}',
          @else
            ajax: '{!! route('admin.knowledge.serial_numbers') !!}',
          @endif
          dom: '<"col-sm-3 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-5 text-center"i><"col-sm-3 pull-right lr-p0"p><"clear">',
          buttons: [
            {
                text: 'New Serial',
                className: 'btn-sm',
                action: function ( e, dt, node, config ) {
                    $('#modal-create-knowledge-serial-number').modal('show');
                }
            }],
           columns: [
               { data: 'title', name: 'title' },
               { data: 'serial_number', name: 'serial_number' },
               { data: 'created_at', name: 'created_at' },
               {data: 'customer', name: 'customer', orderable: false, searchable: false},
               {data: 'action', name: 'action', orderable: false, searchable: false}

           ]
       });

@endsection
@section('styles')
@parent
<!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"/> -->
<link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
 <link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />


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
