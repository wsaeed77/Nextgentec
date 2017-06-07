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
            <div class="alert alert-danger"  id="msg_div" style="display:none">
                <ul id="msgs">
                </ul>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Leaves Listing</h3>
                
                </div>

                <div class=" box-body box-body ">

                   
                  <table class="display table-hover table-bordered table responsive nowrap" cellspacing="0" width="100%"  " style="cursor:pointer" id="dt_leaves_table">
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

{{-- @include('employee::employee_dashboard.ajax_add_for_employee') --}}
@endsection
@section('script')
@parent
 <script src="/DataTables/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function()  {
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
              
              ajax: '{!! route('admin.leave.list_all_leaves') !!}',
              columns: [{
                            data: 'applicant',
                            name: 'users.f_name',

                        },
                        {
                            data: 'posted_by',
                            name: 'users.f_name'
                        },
                        {
                          data: 'type',
                          name: 'leaves.type'
                        }, {
                            data: 'start_date',
                            name: 'leaves.start_date'
                        }, {
                            data: 'end_date',
                            name: 'leaves.end_date'
                        }, {
                            data: 'days',
                            name: 'leaves.duration'
                           
                        }, {
                            data: 'hours',
                            name: 'leaves.duration'
                        },{
                            data: 'created_at',
                            name: 'leaves.created_at'
                        },{
                            data: 'category',
                            name: 'leaves.category'
                        },{
                            data: 'status',
                            name: 'leaves.status'
                        }
                        ,{
                            data: 'action',
                            name: 'action',
                            searchable:false,
                            sortable:false
                        }  

              ],
              order:[[2,'desc']]
          });

       
  /**************************************end leaves data table*********************/

    });
function approve(leave_id)
{
    var objId = $(this).attr('id'); 
    //e.preventDefault();
    $('#load_img').show();
    $.ajax({
        url: "{{ URL::route('admin.leave.posttocalendar')}}",
        type: 'POST',
        dataType: 'json',
        data: 'leave_id='+leave_id,
        success: function(response){
            $('#load_img').hide();
            //consol.log(response);

            $('#msgs').html(response.success);
            $('#msg_div').removeClass('alert-danger').addClass('alert-success').show(); 
            //$('#'+objId).parents('tr').hide();
            var  table = $('#dt_leaves_table').DataTable( {
                            retrieve: true

                        } );

                        table.draw();

        
        },
        error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#msgs').html(html_error);
        $('#msg_div').removeClass('alert-success').addClass('alert-danger').show();
        
        // Render the errors with js ...
      }
    });
}

$(".reject_ajax").click(function(e){
    var objId = $(this).attr('id'); 
       // alert('fff');
      $('#load_img').show();
      $.ajax({
        url: "{{ URL::route('admin.leave.reject_leave')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#reject_form').serialize(),
        success: function(response){
            //alert('fff');
            //$(this).modal('hide');
            $('#load_img').hide();
            $('#msgs').html(response.success);
            $('#msg_div').removeClass('alert-danger').addClass('alert-success').show();
            //$('#modaal-hide').parents('tr').hide();
            //console.log($(this).parent().parent());
            //$('#'+objId).parents('tr').hide(); 
       location.reload(); 
      }
    });
    e.preventDefault();
  });
</script>
@endsection
@section('styles')
  <link rel="stylesheet" href="/DataTables/datatables.min.css">
@endsection
