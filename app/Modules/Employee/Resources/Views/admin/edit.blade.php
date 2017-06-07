@extends('admin.main')
@section('content')


@section('content_header')
    <h1>
        Edit Employee
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Employees
        </li>
    </ol>
@endsection


<section class="content">
      <div class="row">

        <div class="col-xs-12">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="clearfix"></div>
            
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Personal Info</h3>
                    </div>

                    <div class=" box-body">
                        {!! Form::model($employee, ['route' => ['admin.employee.update', $employee->id], 'method'=>'PUT']) !!}
                            <div class="col-lg-12">
                     
                               <input type="hidden" name="type" value="employee">
                                <div class="form-group col-lg-5">
                                    <label>First Name</label>
                                    {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control"]) !!}
                                    
                                </div>
                                 <div class="form-group col-lg-5">
                                    <label>Last Name</label>
                                    {!! Form::input('text','l_name',null, ['placeholder'=>"Last Name",'class'=>"form-control"]) !!}
                                    
                                </div>
                                
                                <div class="form-group col-lg-5">
                                    <label>Email</label>
                                    {!! Form::email('email',null, ['placeholder'=>"Email",'class'=>"form-control"]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Password</label>
                                     {!! Form::password('password', ['placeholder'=>"Password",'class'=>"form-control"]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Confirm Password</label>
                                    {!! Form::password('password_confirmation', ['placeholder'=>"Confirm Password",'class'=>"form-control"]) !!}
                                    
                                </div>
                                 <div class="form-group col-lg-5">
                                    <label>Mobile</label>
                                    {!! Form::input('text','mobile',null, ['placeholder'=>"Mobile",'class'=>"form-control dt_mask",'data-inputmask'=> '"mask": "'.$global_mobile_number_mask.'"']) !!}
                                    
                                </div>
                            </div>


                            <div class="clearfix"></div>
                   
                            <div class="box-header with-border top-border ">
                              <h3 class="box-title">HR Info</h3>
                            </div>
                            <div class="col-lg-12 top-10px">
                                <div class="form-group col-lg-5">
                                    <label>Phone</label>
                                    {!! Form::input('text','phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask", 'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Fax</label>
                                    {!! Form::input('text','fax',$employee->employee->fax, ['placeholder'=>"Fax",'class'=>"form-control"]) !!}
                                    
                                </div>

                                <div class="form-group col-lg-5">
                                    <label>Managed By</label>
                                     {!! Form::select('managed_by', $managers,$employee->employee->managed_by,['class'=>'form-control multiselect','placeholder' => 'Pick a manager'])!!}
                                
                                </div>

                                <div class="form-group col-lg-5">
                                    <label>Select Position/Role</label>
                                     {!! Form::select('role', $roles,$user_role,['class'=>'form-control multiselect','placeholder' => 'Pick a role'])!!}
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Billable Rate</label>
                                    {!! Form::input('text','billable_rate',$employee->employee->billable_rate, ['placeholder'=>"Billable Rate",'class'=>"form-control"]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Cost Rate</label>
                                    {!! Form::input('text','cost_rate',$employee->employee->cost_rate, ['placeholder'=>"Cost Rate",'class'=>"form-control"]) !!}
                                    
                                </div>

                                <div class="form-group col-lg-5">
                                    <label>Birth Date</label>
                                    {!! Form::input('text','birth_date',date('d/m/Y',strtotime($employee->employee->birth_date)), ['placeholder'=>"Birth Date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Hire Date</label>
                                    {!! Form::input('text','hire_date',date('d/m/Y',strtotime($employee->employee->hire_date)), ['placeholder'=>"Hire Date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Pay Type</label>

                                     <?php $pay_type['salary'] = 'Salary';
                                            $pay_type['hourly'] = 'Hourly';
                                            $pay_type['contract'] = 'Contract';?>

                                    {!! Form::select('pay_type', $pay_type,$employee->employee->pay_type,['class'=>'form-control multiselect','placeholder' => 'Pick a pay type'])!!}
                                   
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Pay Rate</label>
                                    {!! Form::input('text','pay_rate',$employee->employee->pay_rate, ['placeholder'=>"Pay Rate",'class'=>"form-control"]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Vacation Given Yearly</label>
                                     {!! Form::selectRange('vacation_yearly', 0, 50,$employee->employee->vacation_yearly,['class'=>'form-control multiselect','placeholder' => 'Select yearly vacations'])!!}
                                   
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Sick Leaves Yearly</label>
                                    {!! Form::selectRange('sick_days_yearly', 0, 50,$employee->employee->sick_days_yearly,['class'=>'form-control multiselect','placeholder' => 'Select sick leaves'])!!}
                                   
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Withholding Tax in percentage(%)</label>
                                    {!! Form::selectRange('withholding_tax_rate', 0, 2,$employee->employee->withholding_tax_rate,['class'=>'form-control multiselect','placeholder' => 'Select w/h Tax'])!!}
                                   
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Time Zone</label>

                                     {!! Form::select('time_zone', $time_zones,$employee->employee->time_zone,['class'=>'form-control multiselect','placeholder' => 'Pick a time zone'])!!}
                                  
                                </div>

                                <div class="form-group col-lg-5">
                                    <label>Emergency Contact Name</label>
                                    {!! Form::input('text','emergency_contact_name', $employee->employee->emergency_contact_name , ['placeholder'=>"Emergency Contact Name",'class'=>"form-control"]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Emergency Contact Number</label>
                                    {!! Form::input('text','emergency_contact_phone',$employee->employee->emergency_contact_phone, ['placeholder'=>"Emergency Contact Number",'class'=>"form-control dt_mask",'data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Address</label>

                                    {!! Form::textarea('home_address',$employee->employee->home_address, ['placeholder'=>"Home Address",'class'=>"form-control",'rows'=>2]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Health Insurance</label>
                                     {!! Form::textarea('health_insurance',$employee->employee->health_insurance, ['placeholder'=>"Health Insurance",'class'=>"form-control",'rows'=>2]) !!}
                                   
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Life Insurance</label>
                                    {!! Form::textarea('life_insurance',$employee->employee->life_insurance, ['placeholder'=>"Life Insurance",'class'=>"form-control",'rows'=>2]) !!}
                                    
                                </div>
                                <div class="form-group col-lg-5">
                                    <label>Retirement</label>
                                    {!! Form::textarea('retirement',$employee->employee->retirement, ['placeholder'=>"Retirement",'class'=>"form-control",'rows'=>2]) !!}
                                   
                                </div>
                                <div class="form-group col-lg-5">
                                    
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Update</button>
                                    
                                </div>
                            </div>  
                        {!! Form::close() !!}

                    <hr>

       
            <div class="col-lg-12">
                <div class="alert alert-danger"  id="raise_msg_div" style="display:none">
                    <ul id="raise_errors">
                    </ul>
                </div>
                <div class="page-header">
                    <h3>Raises</h3>
                </div>
                @include('employee::admin.raise_listing')
                <hr>
                @include('employee::admin.raise_form')
            </div>
       
            </div>
            </div>
          
      
       
</section>    
<!-- /#page-wrapper -->
@include('employee::delete_modal_ajax')
@endsection

@section('script')

<script type="text/javascript" src="{{URL::asset('js/jquery.inputmask.js')}}"></script>
<script type="text/javascript">
$(document).ready(function()  {
    $('#modal-delete').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(Id);
      });
    
   
       
        
      $('.datepicker').datepicker();  

      $(".dt_mask").inputmask();   
    });

$("#raise_submit").click(function(e){
    e.preventDefault();
    
    $.ajax({
        url: "{{ URL::route('admin.raise.store')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#raises').serialize(),
        success: function(response){
        if(response)
        $('#raise_errors').html(response.success);
        $('#raise_msg_div').removeClass('alert-danger').addClass('alert-success').show(); 
        location.reload(); 
        },
        error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#raise_errors').html(html_error);
        $('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();
        
        // Render the errors with js ...
      }
    });
});

    $(".delete_ajax").click(function(e){
      e.preventDefault();
      $.ajax({
        url: "{{ URL::route('admin.raise.destroy')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        dataType: 'json',
        data: $('#delete_form').serialize(),
        success: function(response){
         $('#raise_errors').html(response.success);
        $('#raise_msg_div').removeClass('alert-danger').addClass('alert-success').show(); 
        location.reload(); 
      }
    });
  });

</script>
@endsection
@section('styles')
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/datepicker.css')}}" rel="stylesheet" />
<style>
    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }

</style>
@endsection