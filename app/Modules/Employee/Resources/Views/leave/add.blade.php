@extends('admin.main')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
              
                  Post Leave
             
                </h1>
                
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> Leaves
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            
                   {!! Form::open(['route' => 'employee.leave.store','method'=>'POST']) !!}
               
            <div class="col-lg-12">
                <div class="page-header">
                    <h3>Leave Details</h3>
                </div>
            </div>
           
            <div class="col-lg-12">
             
                   <input type="hidden" name="user_id" value="{{ Auth::user()->id}}">
                   <div class="form-group col-lg-5">
                        <label>Title</label>
                        {!! Form::input('text','title',null, ['placeholder'=>"Leave Title",'class'=>"form-control"]) !!}
                    </div>

                     <div class="form-group col-lg-5">
                        <label>Leave Type</label>
                        <?php $categories = ['full'=>'Full',
                                            'short'=>'Short'];
                                            ?>
                       {!! Form::select('category', $categories,'',['class'=>'form-control multiselect','placeholder' => 'Pick leave type','onchange'=>'show_duration(this.value)'])!!}
                      </div>

                        <div class="form-group col-lg-5" id="date_range_div" style="display: none">
                            <label>Leaves duration</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                            {!! Form::input('text','duration',null, ['placeholder'=>"Duration",'id'=>'duration_full','class'=>"form-control"]) !!}
                             {{-- <input value="" name="duration" type="hidden" id="hidden_duration"> --}}
                             </div>
                        </div>

                        <div class="form-group col-lg-5" id="time_div" style="display: none">
                            <label>Duration</label>
                             <?php
                            
                              $duration = [];
                             for($h=1; $h<=4;$h++) {
                            
                               for($m=0; $m<=45;$m=$m+15) {
                                  if($m==0)
                                  {
                                    $m="00";
                                  }
                                 $duration[$h.'.'.(($m*100)/60)] = '0'.$h.':'.$m.' Hours';
                                 
                                 if($h==4)
                                  break;

                               }

                             }
                          ?>
                           {!! Form::select('duration_short', $duration,'',['class'=>'form-control multiselect','placeholder' => 'leave duration'])!!}
                        </div>

                  

                   <div class="form-group col-lg-5" id="short_date_div" style="display: none">
                        <label>Leave date</label>
                          {!! Form::input('text','date',null, ['placeholder'=>"Leave date",'class'=>"form-control",'data-date-format'=>$js_global_date,'id'=>'date_short_leave']) !!}
                        </div>

                           <div class="form-group col-lg-5">
                            <label>Leave Category</label>
                            <?php $types = ['annual'=>'Annual',
                                                'sick'=>'Sick'];
                                                ?>
                           {!! Form::select('type', $types,'',['class'=>'form-control multiselect','placeholder' => 'Pick leave category'])!!}
                          </div>
                     
                    
                    <div class="form-group col-lg-10">
                        <label>Comments</label>
                         {!! Form::textarea('comments',null, ['placeholder'=>"Comments",'class'=>"form-control",'rows'=>2]) !!}
                            
                    </div>
                    <div class="form-group col-lg-5">
                     
                      <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>
                    
                    </div>
                </div>
                
            </div>
             <hr>
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>

@endsection

@section('styles')
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/datepicker.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{URL::asset('daterangepicker/daterangepicker-bs3.css')}}">

@endsection
@section('script')

<script type="text/javascript" src="{{URL::asset('daterangepicker/moment.min.js')}}"></script>
 <script type="text/javascript" src="{{URL::asset('daterangepicker/daterangepicker.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() 
    {
       
        
     $('.datepicker').datepicker();   
    $('#date_short_leave').datepicker();
     $('#duration_full').daterangepicker();
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