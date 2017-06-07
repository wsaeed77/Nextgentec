@extends('admin.main')
@section('content')


@section('content_header')
    <h1>
         Add New Employee
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
            {!! Form::open(['route' => 'admin.employee.store','method'=>'POST']) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Personal Info</h3>
                </div>

                <div class=" box-body">
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
                        {!! Form::input('text','fax',null, ['placeholder'=>"Fax",'class'=>"form-control dt_mask",'data-inputmask'=> '"mask": "'.$global_fax_number_mask.'"']) !!}
                    </div>

                    <div class="form-group col-lg-5">
                        <label>Managed By</label>

                       {!! Form::select('managed_by', $managers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a manager'])!!}
                    </div>
                     <div class="form-group col-lg-5">
                        <label>Select Position/Role</label>
                    {!! Form::select('role', $roles,'',['class'=>'form-control multiselect','placeholder' => 'Pick a role'])!!}



                    </div>
                    <div class="form-group col-lg-5">
                        <label>Billable Rate</label>
                        {!! Form::input('text','billable_rate',null, ['placeholder'=>"Billable Rate",'class'=>"form-control"]) !!}
                     </div>
                     <div class="form-group col-lg-5">
                        <label>Cost Rate</label>
                        {!! Form::input('text','cost_rate',null, ['placeholder'=>"Cost Rate",'class'=>"form-control"]) !!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Birth Date</label>
                        {!! Form::input('text','birth_date',null, ['placeholder'=>"Birth Date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}

                    <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>

                    <div class="form-group col-lg-5">
                        <label>Hire Date</label>
                        {!! Form::input('text','hire_date',null, ['placeholder'=>"Hire Date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Pay Type</label>
                        <?php $pay_type['salary'] = 'Salary';
                                $pay_type['hourly'] = 'Hourly';
                                $pay_type['contract'] = 'Contract';?>

                        {!! Form::select('pay_type', $pay_type,'',['class'=>'form-control multiselect','placeholder' => 'Pick a pay type'])!!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Pay Rate</label>
                        {!! Form::input('text','pay_rate',null, ['placeholder'=>"Pay Rate",'class'=>"form-control"]) !!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Vacation Given Yearly</label>

                        {!! Form::selectRange('vacation_yearly', 0, 50,'',['class'=>'form-control multiselect','placeholder' => 'Select yearly vacations'])!!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Sick Leaves Yearly</label>
                        {!! Form::selectRange('sick_days_yearly', 0, 50,'',['class'=>'form-control multiselect','placeholder' => 'Select sick leaves'])!!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Withholding Tax in percentage(%)</label>
                         {!! Form::selectRange('withholding_tax_rate', 0, 2,'',['class'=>'form-control multiselect','placeholder' => 'Select w/h Tax'])!!}

                    </div>
                    <div class="form-group col-lg-5">
                        <label>Time Zone</label>

                         {!! Form::select('time_zone', $time_zones,'',['class'=>'form-control multiselect','placeholder' => 'Pick a time zone'])!!}

                    </div>
                    <div class="form-group col-lg-5">
                        <label>Emergency Contact Name</label>
                        {!! Form::input('text','emergency_contact_name', null, ['placeholder'=>"Emergency Contact Name",'class'=>"form-control"]) !!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Emergency Contact Number</label>
                        {!! Form::input('text','emergency_contact_phone',null, ['placeholder'=>"Emergency Contact Number",'class'=>"form-control dt_mask",'data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}

                    </div>
                    <div class="form-group col-lg-5">
                        <label>Address</label>
                        {!! Form::textarea('home_address',null, ['placeholder'=>"Home Address",'class'=>"form-control",'rows'=>2]) !!}

                    </div>

                    <div class="form-group col-lg-5">
                        <label>Health Insurance</label>
                         {!! Form::textarea('health_insurance',null, ['placeholder'=>"Health Insurance",'class'=>"form-control",'rows'=>2]) !!}

                    </div>
                    <div class="form-group col-lg-5">
                        <label>Life Insurance</label>
                         {!! Form::textarea('life_insurance',null, ['placeholder'=>"Life Insurance",'class'=>"form-control",'rows'=>2]) !!}

                    </div>
                    <div class="form-group col-lg-5">
                        <label>Retirement</label>
                         {!! Form::textarea('retirement',null, ['placeholder'=>"Retirement",'class'=>"form-control",'rows'=>2]) !!}

                    </div>
                    <div class="form-group col-lg-5">

                      <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>

                     </div>
                </div>

                </div>

            </div>
             {!! Form::close() !!}
        </div>
    </div>
</section>

@endsection


@section('script')

<script type="text/javascript" src="{{URL::asset('js/jquery.inputmask.js')}}"></script>
<script type="text/javascript">
$(document).ready(function()
    {
        

     $('.datepicker').datepicker();

      $(".dt_mask").inputmask();
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
