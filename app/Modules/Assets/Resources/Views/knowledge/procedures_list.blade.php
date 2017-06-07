@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
            Procedures
    </h1>

    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Knowledge
        </li>
         <li class="active">
            <i class="fa fa-gears"></i> Procedures
        </li>
    </ol>
@endsection

<section class="content">
    <div class="row">
      <div class="col-xs-12">

      <div class="table-responsive" id="procedures">
          <table class="display table-hover table responsive nowrap" cellspacing="0" width="100%" id="knowledge_procedure_dt_table">
            <thead>
              <tr>
                <th>Title</th>
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

@include('assets::knowledge.ajax_create_knowledge_procedure')
@include('assets::knowledge.edit_procedure')

@include('admin.partials.delete_modal', [
  'id'=>'modal_procedure_delete',
  'message' => 'Are you sure you\'d like to delete this procedure?',
  'url' => 'admin.knowledge.delete.procedure',
  'refresh' => true
])

@include('assets::knowledge.show')
{{--@include('crm::ticketstatus.delete_modal_ticket_status')
@include('crm::ticketstatus.ajax_create_ticket_status') --}}

@endsection
@section('script')
<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>

@endsection

@section('document.ready')
@parent

{{-- <script type="text/javascript"> --}}

var showall = false;
var procedures_tbl = $('#knowledge_procedure_dt_table').DataTable({
  processing: true,
  serverSide: true,
  "bAutoWidth": false,
  @if((session('cust_id')!='') && (session('customer_name')!=''))
     ajax: '{!! route('admin.knowledge.procedures_by_cust',session('cust_id')) !!}',
  @else
     ajax: '{!! route('admin.knowledge.procedures') !!}',
  @endif
  dom: '<"col-sm-3 lr-p0"B><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-5 text-center"i><"col-sm-3 pull-right lr-p0"p><"clear">',
  buttons: [
    {
        text: 'New Procedure',
        className: 'btn-sm',
        action: function ( e, dt, node, config ) {
            $('#modal-create-knowledge-procedure').modal('show');
        }
    },
    {
        text: 'Show All',
        className: 'btn-sm showall',
        action: function ( e, dt, node, config ) {
          if(showall == true) {
            procedures_tbl.ajax.url( '{!! route('admin.knowledge.procedures_by_cust',session('cust_id')) !!}' ).load(function() {
              procedures_tbl.buttons('.showall').text('Show All');
              showall = false;
            });
          } else {
            procedures_tbl.ajax.url( '{!! route('admin.knowledge.procedures_by_cust'),0 !!}' ).load(function() {
              procedures_tbl.buttons('.showall').text('<b>Back</b');
              showall = true;
            });
          }

        }
    }
  ],
  columns: [
     { data: 'title', name: 'title' },
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
  {{-- <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/> --}}


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
