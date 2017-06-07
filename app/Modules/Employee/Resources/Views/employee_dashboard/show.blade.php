@extends('admin.main')
@section('content')


@section('content_header')
          <h1>
            User Profile
          </h1>
          <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="{{URL::route('admin.dashboard')}}"> Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-table"></i> <a href="{{URL::route('admin.employee.index')}}"> Employees</a>
            </li>
          </ol>
       @endsection

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('img/avatar.png')}}" alt="User profile picture">
                  <h3 class="profile-username text-center">{{$employee->f_name.' '.$employee->l_name}}</h3>
                  <p class="text-muted text-center">{{$employee->roles[0]->display_name}}</p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Email</b> <a class="pull-right">{{$employee->email}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Mobile</b> <a class="pull-right">{{$employee->mobile}}</a>
                    </li>
                    
                  </ul>

                  {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">About</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 {{--  <strong><i class="fa fa-book margin-r-5"></i>  Education</strong>
                  <p class="text-muted">
                    B.S. in Computer Science from the University of Tennessee at Knoxville
                  </p>

                  <hr> --}}

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
                  <p class="text-muted">{{$employee->employee->home_address}}</p>

                  <hr>

                  <strong><i class="fa fa-clock-o margin-r-5"></i> Time Zone</strong>
                  <p>
                  {{$employee->employee->time_zone}}
                   {{--  <span class="label label-danger">UI Design</span>
                    <span class="label label-success">Coding</span>
                    <span class="label label-info">Javascript</span>
                    <span class="label label-warning">PHP</span>
                    <span class="label label-primary">Node.js</span> --}}
                  </p>

                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#hr_info" data-toggle="tab"><b>HR Info</b></a></li>
                  <li><a href="#raises" data-toggle="tab"><b>Raises</b></a></li>
                  {{-- <li><a href="#settings" data-toggle="tab">Settings</a></li> --}}
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="hr_info">
                    <!-- Post -->
                    <div class="row">
                        <div class="col-md-6">

                            <table class="table table-striped">
                                    <tbody>
                                       {{--  <tr>
                                         
                                          <th>Task</th>
                                          <th>Progress</th>
                                          <th style="width: 40px">Label</th>
                                        </tr> --}}
                                    <tr>
                                     
                                      <th>Phone</th>
                                       <td>{{$employee->phone}}</td>
                                      
                                    </tr>
                                    <tr>
                                      
                                      <th>Fax</th>
                                      
                                      <td>{{$employee->employee->fax}}</td>
                                    </tr>
                                    <tr>
                                     
                                      <th>Birth Date</th>
                                     
                                       <td>{{date($global_date,strtotime($employee->employee->birth_date))}}</td>
                                    </tr>
                                    <tr>
                                      
                                      <th>Hire Date</th>
                                     
                                       <td>{{date($global_date,strtotime($employee->employee->hire_date))}}</td>
                                    </tr>
                                   
                                    <tr>
                                      
                                      <th>Emergency Contact Name</th>
                                     
                                       <td>{{$employee->employee->emergency_contact_name}}</td>
                                    </tr>
                                     <tr>
                                      
                                      <th>Emergency Contact Phone</th>
                                     
                                       <td>{{$employee->employee->emergency_contact_phone}}</td>
                                    </tr>
                                  </tbody>
                            </table>
                        </div><!-- /.post -->
                          <div class="col-md-6">
                              <table class="table table-striped">
                                      <tbody>
                                        <tr>
                                       
                                        <th>Billable Rate</th>
                                         <td><span class="badge bg-blue"><i class="fa fa-dollar "></i>{{$employee->employee->billable_rate}}</span></td>
                                      </tr>
                                      <tr>
                                        
                                        <th>Cost Rate</th>
                                        
                                         <td><span class="badge bg-blue"><i class="fa fa-dollar "></i>{{$employee->employee->cost_rate}}</span></td>
                                      </tr>
                                      <tr>
                                       
                                        <th>Pay Type</th>
                                       
                                         <td>{{$employee->employee->pay_type}}</td>
                                      </tr>
                                      <tr>
                                        
                                        <th>Pay Rate</th>
                                       
                                         <td><span class="badge bg-blue"><i class="fa fa-dollar "></i>{{$employee->employee->pay_rate}}</span></td>
                                      </tr>
                                      <tr>
                                        
                                        <th>Withholding Tax %</th>
                                       
                                         <td><span class="badge bg-blue">{{$employee->employee->withholding_tax_rate}}</span></td>
                                      </tr>
                                    </tbody>
                              </table>
                          </div>
                    
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                          <strong> Health Insurance</strong>
                          <p class="text-muted">{{$employee->employee->health_insurance}}</p>
                        </div>

                        <div class="col-md-6">
                           <strong>Life Insurance</strong>
                          <p>
                          {{$employee->employee->life_insurance}}
                          
                          </p>
                        </div>
                    </div>
                     <hr/>
                    <div class="row">
                      <div class="col-md-6">
                       <strong>Retirement</strong>
                      <p>
                      {{$employee->employee->retirement}}
                      
                      </p>
                      </div>
                    </div>
                 
                    <!-- Post -->
                   
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="raises">
                    @include('employee::admin.raise_listing')
                  </div><!-- /.tab-pane -->

                
                </div><!-- /.tab-content -->
                <div style="clear:both"></div>
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->


              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Leaves</h3>
                  @ability('', 'post_leave_for_employee')
                   <button type="button" class="btn  btn-primary pull-right" data-id="{{$employee->id}}" data-target="#modal-create-admin-leave"   data-toggle="modal">Apply Leave</button>
                   @endability
                   

                </div>

                <div class=" box-body box-body table-responsive">

                 {{--    --}}
              <div class="col-md-12">
               <div class="col-md-2">
                  <canvas id="myChart" width="200" height="200"></canvas>
                </div>
                <div class="col-md-5 top-10px">
                <table class="table table-striped table-bordered">
                        <tbody>
                          <tr>
                         
                        <th>Availed Annual Leaves</th>
                           <td><span class="badge bg-green">{{$availed_annual_leaves}}</span></td>
                        </tr>
                         <tr>
                         
                        <th>Availed Sick Leaves</th>
                           <td><span class="badge bg-green">{{$availed_sick_leaves}}</span></td>
                        </tr>
                        <tr>
                          
                          <th>Remaining Sick Leaves</th>
                          
                           <td><span class="badge bg-blue">{{($employee->employee->sick_days_yearly) - ($availed_sick_leaves)}}</span></td>
                        </tr>
                        <tr>
                          
                          <th>Remaining Annual Leaves</th>
                          
                           <td><span class="badge bg-blue">{{($employee->employee->vacation_yearly) - ($availed_annual_leaves)}}</span></td>
                        </tr>
                      </tbody>
                </table>
                   
                </div>
                <div class="col-md-5 top-10px">
                   <table class="table table-striped table-bordered">
                        <tbody>
                          <tr>
                         
                          <th>Annual Leaves</th>
                           <td><span class="badge bg-blue">{{$employee->employee->vacation_yearly}}</span></td>
                        </tr>
                        <tr>
                          
                          <th>Sick Leaves(Yearly)</th>
                          
                           <td><span class="badge bg-blue">{{$employee->employee->sick_days_yearly}}</span></td>
                        </tr>
                        {{-- <tr>
                         
                          <th>Pending Leaves</th>
                           <td><span class="badge bg-yellow">{{$pending_leaves}}</span></td>
                        </tr>
                        <tr>
                          
                          <th>Rejected Leaves</th>
                          
                           <td><span class="badge bg-red">{{$rejected_leaves}}</span></td>
                        </tr> --}}
                      </tbody>
                </table>
                </div>

              </div>
               
                <div class="col-md-12 top-10px">
                <hr>
                    <table class="table table-hover table-bordered" style="cursor:pointer" id="dt_leaves_table">
                        <thead>
                            <tr>
                                <th>Posted By</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Days</th>
                                <th>Hours</th>
                                <th>Created at</th>
                                <th>Duration</th>
                                
                                <th>Status</th>
                              
                            </tr>
                        </thead>
                      
                    </table>
                </div>
                </div>
            </div>
        </section>


@include('employee::employee_dashboard.ajax_add_for_employee')
@endsection
 

@section('script')

<script type="text/javascript" src="{{URL::asset('js/Chart.bundle.js')}}"></script>
 <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>

<script type="text/javascript" src="{{URL::asset('daterangepicker/moment.min.js')}}"></script>
 <script type="text/javascript" src="{{URL::asset('daterangepicker/daterangepicker.js')}}"></script>


<script type="text/javascript">
$(document).ready(function() {

  $('#duration_full').daterangepicker();

   

  
    $('#date_short_leave').datepicker();


    /****************************** leaves pie chart *********************/
    var data = {
        labels: ['Availed Leaves', 'Remaining leaves'],
        datasets: [{
            backgroundColor: [
                'green',
                'blue'
            ],
            data: [
                    {{$availed_annual_leaves + $availed_sick_leaves}}, 
                    {{($employee->employee->vacation_yearly + $employee->employee->sick_days_yearly) - ($availed_annual_leaves + $availed_sick_leaves)}}
                  ],
        }]
    };
    var config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,

        }
    };
   var ctx = $("#myChart").get(0).getContext("2d");
    ctx.canvas.width = 300;
   ctx.canvas.height = 300;
    new Chart(ctx, config);
    /******************************* end leaves pie chart************************/


    /******************************leaves data table************/
   var table = $('#dt_leaves_table').DataTable({
              processing: true,
              serverSide: true,
              "bAutoWidth": false,
              ajax: '{!! route('admin.leave.list_leaves',$employee->id) !!}',
              columns: [{data: 'posted_by',name: 'users.f_name'},
                        {data: 'type',name: 'leaves.type'},
                        {data: 'start_date',name: 'leaves.start_date'},
                        {data: 'end_date',name: 'leaves.end_date'},
                        {data: 'days',name: 'leaves.duration'},
                        {data: 'hours',name: 'leaves.duration'},
                        {data: 'created_at',name: 'leaves.created_at'},
                        {data: 'category',name: 'leaves.category'},
                        {data: 'status',name: 'leaves.status'}
                        
                      ],
              order:[[6,'desc']]
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
  <link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
  <link href="{{URL::asset('css/datepicker.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('daterangepicker/daterangepicker-bs3.css')}}">
<style>
    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
.datepicker{z-index:9999 !important}

</style>
<link href="{{URL::asset('css/datepicker.css')}}" rel="stylesheet" />
@endsection
