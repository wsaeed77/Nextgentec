@extends('admin.main')
@section('content')


@section('content_header')
    <h1>
         Leaves
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Leaves
        </li>
    </ol>
@endsection

<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="alert alert-danger"  id="leave_msg_div" style="display:none">
                <ul id="msgs">
                </ul>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Leaves Listing</h3>
                  @ability('', 'post_leave')
                   <button type="button" class="btn  btn-primary pull-right"  data-target="#modal-create-leave"   data-toggle="modal">Apply Leave</button>
                   @endability
                   
                
                </div>

                <div class=" box-body box-body table-responsive">

                   
                  <table class="table table-hover table-bordered" style="cursor:pointer" id="dt_leaves_table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Posted By</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Days</th>
                                <th>Hours</th>
                                <th>Created at</th>
                                <th>Duration</th>
                                
                                <th>Status</th>
                                <th>Action</th>
                              
                            </tr>
                        </thead>
                      
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</section>

@include('employee::delete_modal')
@include('employee::reject_modal_ajax')

@include('employee::leave.ajax_apply_leave')
@endsection
@section('script')
@parent
 <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>

 <script type="text/javascript" src="{{URL::asset('daterangepicker/moment.min.js')}}"></script>
 <script type="text/javascript" src="{{URL::asset('daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript">
$(document).ready(function()  {

  $('#date_short_leave').datepicker();
    $('#duration_full').daterangepicker();
    $('#modal-reject').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(Id);
      });



      /******************************leaves data table************/
   var table = $('#dt_leaves_table').DataTable({
              processing: true,
              serverSide: true,
              "bAutoWidth": false,
              order: [[7,'desc']],
              ajax: '{!! route('admin.leave.list_own_leaves',Auth::user()->id) !!}',
              columns: [{data: 'applicant',name: 'users.f_name'},
                        {data: 'posted_by',name: 'users.f_name'},
                        {data: 'type',name: 'leaves.type'},
                        {data: 'start_date',name: 'leaves.start_date'},
                        {data: 'end_date',name: 'leaves.end_date'},
                        {data: 'days',name: 'leaves.duration'},
                        {data: 'hours',name: 'leaves.duration'},
                        {data: 'created_at',name: 'leaves.created_at'},
                        {data: 'category',name: 'leaves.category'},
                        {data: 'status',name: 'leaves.status'},
                        {data: 'action',name: 'action',searchable:false,sortable:false}
                      ],
              
          });

       
  /**************************************end leaves data table*********************/

    });
function show_duration(val)
{
  if(val=='full')
  {
    $('#date_range_div').show();
    $('#time_div').hide();
    $('#short_date_div').hide()
  }

  if(val=='short')
  {
    $('#time_div').show();
    $('#date_range_div').hide();
    $('#short_date_div').show()
  }

}
</script>
@endsection
@section('styles')
  <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('daterangepicker/daterangepicker-bs3.css')}}">
  <link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/datepicker.css')}}" rel="stylesheet" />
<style>
.datepicker{z-index:9999 !important}
</style>
@endsection
