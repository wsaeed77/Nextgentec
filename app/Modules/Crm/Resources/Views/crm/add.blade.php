@extends('admin.main')
@section('content')


        <!-- Content Header (Page header) -->
       @section('content_header')
          <h1>
          Add New Customer
           
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Customers</li>
          </ol>
        @endsection

        <section class="content">
          <!-- Info boxes -->
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

                <div class="col-xs-12">
                    <div class="box box-primary" >

                        {!! Form::open(['route' => 'admin.crm.store','method'=>'POST','id'=>'form_validate']) !!}
                            
                               <input type="hidden" name="loc_obj" value="" id="loc_obj">
                               <input type="hidden" name="cntct_obj" value="" id="cntct_obj">
                  
                                <h2>Customer details</h2>
                                 <section>
                                       <div class="box-body">
                                            <div class="col-lg-12">
                                                <div class="form-group col-lg-6">
                                                    <label>Cutomer Name</label>
                                                    {!! Form::input('text','customer_name',null, ['placeholder'=>"Cutomer Name",'class'=>"form-control required",'id'=>'customer']) !!}
                                                            
                                                    
                                                </div>
                                                 <div class="form-group col-lg-6">
                                                    <label>Main Phone</label>
                                                    {!! Form::input('text','phone',null, ['placeholder'=>"Main phone",'class'=>"form-control dt_mask",'id'=>'dt_mask', 'data-mask'=>'','data-inputmask'=> '"mask":"'.$global_phone_number_mask.'"']) !!} 
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group col-lg-6">
                                                    <label>Email domain</label>
                                                    {!! Form::input('text','email_domain',null, ['placeholder'=>"Email Domain",'class'=>"form-control "]) !!}
                                                   
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Customer since</label>
                                                     {!! Form::input('text','customer_since',null, ['placeholder'=>"Customer since",'class'=>"form-control",'data-date-format'=>"$date_format->value",'id'=>'customer_since']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group col-lg-6">
                                                    <label>Active? </label>
                                                    <label class="radio-inline">{!! Form::radio('active', 1,true) !!} Yes</label>
                                                     <label class="radio-inline">{!! Form::radio('active', 0) !!}No</label>
                                                   
                                                </div>
                                                 <div class="form-group col-lg-6">
                                                    <label>Is Taxable</label>
                                                    {!! Form::checkbox('taxable', 1); !!}
                                                   
                                                   
                                                </div>
                                            </div>
                                        </div>
                                  </section>  


                                <h2>Add Service Item</h2>
                                <section>

                                    <div class="col-lg-12">
                                       
                                        <div class="form-group col-lg-5">
                                            <label>Service Type</label>
                                            {!! Form::select('service_type_id', $service_types,'',['class'=>'form-control multiselect_crm required','placeholder' => 'Pick a service type','onChange'=>'dynamic_data(this.value);'])!!}
                                            
                                        </div>
                                        <div class="col-lg-2">
                                           
                                                <img id="load_img" src="{{asset('img/loader.gif')}}" style="display:none" />
                                            
                                        </div>
                                    </div>
                                        
                                    <div id="dynamic_data">
                                        
                                    </div>
                                    <div class="col-lg-4" id="rates" style="display:none">

                                        <div class="page-header">
                                            <h3>Rates</h3>
                                        </div>

                                            <div class="alert alert-success" id="rate_alert" style="display:none">
                                               
                                            </div>

                                        <?php $rates = [''=>'Pick a default rate'];?>
                                        <div class="form-group col-lg-12">
                                            <label>Default Rate</label>
                                            {!! Form::select('default_rate', $def_rates,'',['class'=>'form-control multiselect_crm','id'=>'default_rate','placeholder'=>'Pick a default rate'])!!}
                                            
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Additional Rates</label>
                                            <?php $additional_rates = [];?>
                                             {!! Form::select('additional_rates[]', $def_rates,'',['class'=>'form-control multiselect_crm','id'=>'additional_rate','multiple'=>''])!!}

                                            
                                        </div>
                                        <div class="form-group col-lg-8">
                                     
                                          <a href="javascript:;" id="btn_rate_form_show" class="btn btn-lg btn-success btn-block"><i class="fa fa-plus"></i> Add New Rate</a>
                                            
                                        </div> 

                                         <div id="rate_form" class="col-lg-12" style="display:none">
                                         <div class="form-group col-lg-12">
                                            <label>Title</label>
                                            {!! Form::input('text','temp_rate_title', null,['class'=>'form-control','placeholder'=>"Rate title"])!!}
                                            
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Rate</label>
                                            {!! Form::input('text','temp_amount',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
                                        </div>
                                        <div class="form-group col-lg-6">
                                     
                                          <a href="javascript:;" onclick="save_temporary_rate()" class="btn btn-lg btn-success btn-block">Save</a>
                                            
                                        </div> 
                                        <div class="col-lg-2">
                                           
                                                <img id="load_img_rate" src="{{asset('img/loader.gif')}}" style="display:none" />
                                            
                                        </div>
                                         </div>
                                    </div>
                                    <div class="col-lg-12" id="invocing">
                                            <div class="page-header">
                                                <h3>Invoicing</h3>
                                            </div>
                                        
                                            <div class="form-group col-lg-12">
                                                <label>Service item description</label>
                                                {!! Form::textarea('description_invoicing',null, ['placeholder'=>"Service item description",'class'=>"form-control",'rows'=>2]) !!}
                                            </div>
                                        
                                    </div>  
                                </section>
                                 
                       
                                <h2>Add Location</h2>
                                <section>
                                     <div class="form-group col-lg-12" id="location_inputs">
                                        <div class="form-group col-lg-6">
                                            <label>Location name</label>
                                            {!! Form::input('text','location_name',null, ['placeholder'=>"Location Name",'class'=>"form-control",'id'=>'location_name']) !!}
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Address</label>
                                            {!! Form::input('text','address',null, ['placeholder'=>"Address",'class'=>"form-control",'id'=>'address']) !!}
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Country</label>
                                           {{--  {!! Form::input('text','country',null, ['placeholder'=>"Country",'class'=>"form-control",'id'=>'country']) !!} --}}

                                             {!! Form::select('country', $countries,'United States',['class'=>'form-control multiselect_crm','id'=>'cntry','placeholder' => 'Pick a Country'])!!}
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>State</label>
                                            {!! Form::input('text','state',null, ['placeholder'=>"State",'class'=>"form-control",'id'=>'state']) !!}
                                             
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>City</label>
                                            {!! Form::input('text','city',null, ['placeholder'=>"City",'class'=>"form-control" ,'id'=>'city']) !!}
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Zip</label>
                                            {!! Form::input('text','zip',null, ['placeholder'=>"Zip",'class'=>"form-control" ,'id'=>'zip']) !!}
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Main Phone</label>
                                            {!! Form::input('text','loc_main_phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'id'=>'loc_main_phone','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Back Line Number</label>
                                            {!! Form::input('text','back_line_phone',null, ['placeholder'=>"Back line number",'class'=>"form-control dt_mask",'id'=>'back_line_phone','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Primary Fax</label>
                                            {!! Form::input('text','primary_fax',null, ['placeholder'=>"Fax",'class'=>"form-control dt_mask",'id'=>'primary_fax','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_fax_number_mask.'"']) !!}
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Secondary Fax</label>
                                            {!! Form::input('text','secondary_fax',null, ['placeholder'=>"Fax",'class'=>"form-control dt_mask",'id'=>'secondary_fax','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_fax_number_mask.'"']) !!}
                                        </div>


                                     </div>
                                        <div class="form-group col-lg-6">
                                            <label class="radio-inline">{!! Form::checkbox('default', 1,'',['id'=>'default']); !!}</label>
                                            <label>Default Location?</label>
                                     </div>

                                        <div class="form-group col-lg-12">
                                            <div class="form-group col-lg-2" id="add_loc_btn">
                                              <a href="javascript:;" onclick="add_location()"  class="btn btn-lg btn-success btn-block">Add Location</a>
                                                
                                            </div> 

                                        </div> 
                                    <div class="form-group col-lg-12" id="location_labels">
                                    </div>
                                </section>
                           
                                <h2>Add Contacts</h2>
                                <section>
                                     <div class="form-group col-lg-12" id="contact_inputs">
                                        <div class="form-group col-lg-6">
                                            <label>Location</label>

                                                <?php $location_index = [];?>
                                             {!! Form::select('location_index', $location_index,'',['class'=>'form-control multiselect_crm','id'=>'cnt_location'])!!}
                                            
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>First Name</label>
                                            {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control"]) !!}
                                        </div>
                                         <div class="form-group col-lg-6">
                                            <label>Last Name</label>
                                            {!! Form::input('text','l_name',null, ['placeholder'=>"Last Name",'class'=>"form-control"]) !!}
                                        </div>
                                        
                                         <div class="form-group col-lg-6">
                                            <label>Title</label>
                                            {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Email</label>
                                            {!! Form::input('text','email',null, ['placeholder'=>"Email",'class'=>"form-control",'id'=>'cnt_email']) !!}
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Main Phone</label>
                                            {!! Form::input('text','contact_phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Mobile Phone</label>
                                            {!! Form::input('text','contact_mobile',null, ['placeholder'=>"Mobile Phone",'class'=>"form-control dt_mask", 'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_mobile_number_mask.'"']) !!}
                                        </div>

                                        

                                     
                                        <div class="form-group col-lg-6">
                                                <label class="radio-inline">
                                                <input type="checkbox" id="chk_poc" name="primary_poc"> 
                                                </label>
                                                <label>Primary POC?</label>
                                        </div>


                                        <div class="form-group col-lg-12">
                                            <div class="form-group col-lg-2" id="add_cntct_btn">
                                              <a href="javascript:;" onclick="add_contact()"  class="btn btn-lg btn-success btn-block">Add Contact</a>
                                                
                                            </div> 

                                        </div> 

                                        <div class="form-group col-lg-12" id="contact_labels">
                                        </div>
                                    </div>
                                </section>
                           
                        {!! Form::close() !!}
                    </div>   
                </div> 
       

            <hr>
            </div>
        </section>



@endsection
@section('script')
<script type="text/javascript" src="{{URL::asset('js/jquery.validate.js')}}"></script>

<script type="text/javascript" src="{{URL::asset('js/jquery.steps.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/jquery.inputmask.js')}}"></script>
{{-- <script src="{{URL::asset('js/select2.full.min.js')}}"></script> --}}

@include('crm::crm.ajax_functions')

<script type="text/javascript">
$(document).ready(function() 
    {
      
                setTimeout(function() {
                    //debugger;
                $('.multiselect_crm').multiselect({
                            enableFiltering: true,
                            includeSelectAllOption: false,
                            maxHeight: 400,
                            buttonWidth: '100%',
                            dropUp: false,
                            buttonClass: 'form-control',
                             enableFullValueFiltering: true
                          
                        });
                },2000);

                
        
        var form = $("#form_validate");
        form.steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Allways allow previous action even if the current form is not valid!
                   /* if (currentIndex > newIndex)
                    {
                        return true;
                    }*/
                    // Needed in some cases if the user went back (clean up)
                    //form.validate().settings.ignore = ":disabled,:hidden";
                    //alert(currentIndex);
                     //if (currentIndex != 2)
                    return form.valid();
                },    
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    if (currentIndex == 3)
                    {     
                        //populate the location drop down at 4th step(add contacts)
                        populate_loc_contact();                       
                  
                    }
                  
                    if (currentIndex)
                    {
                        $('#form_validate-p-'+currentIndex).css('position', 'relative');
                        $('#form_validate-p-1'+currentIndex).css('height', 'auto');
                    }
                    // Used to skip the "Warning" step if the user is old enough.
                    /*if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
                    {
                        form.steps("next");
                    }
                    // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        form.steps("previous");
                    }*/
                },
                onFinishing: function (event, currentIndex)
                {
                    form.validate().settings.ignore = ":disabled";
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    $('#cntct_obj').val(JSON.stringify(cntct_arr));
                    $('#loc_obj').val(JSON.stringify(loc_arr));
                    //return false;
                    $('#form_validate').submit();
                    alert("Submitted!");
                }
        }).validate({
                errorPlacement: function errorPlacement(error, element) { 
                    //return true;
                    element.after(error); },
        });

        //$('.datepicker').datepicker(); 




        $('#customer_since').datepicker();
       
       
   
        $('#btn_rate_form_show').click(function() {
               $('#rate_form').show('slow');
            });


        $(".dt_mask").inputmask();

         $('div.actions  ul').addClass('col-md-12');
         $('div.actions  ul li:nth-child(1)').addClass('pull-left');
         $('div.actions  ul li:nth-child(2)').addClass('pull-right');
         $('div.actions').css('margin-bottom','12px');
         //$('div.actions > ul').addClass('col-md-12');
        //console.log($('div.actions:first-child').html());


        /*$("#service_type_id").select2({
            allowClear: true
        });*/
});



</script>


@endsection
@section('styles')

<link href="{{URL::asset('css/jquery.steps.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/datepicker.css')}}" rel="stylesheet" />
{{-- <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}"> --}}
<style>
form.cmxform label.error, label.error {
    /* remove the next line when you have trouble in IE6 with labels in list */
    color: red !important;
    font-style: italic
}
div.error { display: none; }
input { border: 1px solid black; }
input.checkbox { border: none }
input:focus { border: 1px dotted black; }
input.error { border: 1px dotted red; }
form.cmxform .gray * { color: gray; }
.page-header {
    border-bottom: 1px solid #000;
}
.no-gutter  {
    padding-right:0;
    padding-left:0;
}
.wizard > .content > .body {
    float: left;
    height: auto !important;
    }
.panel-heading h3 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: normal;
    width: 72%;
    padding-top: 8px;
}

#form_validate.wizard.clearfix {
    padding-top: 10px;
}
.wizard > .content {
    background: none ;
    min-height: 20em;
}

</style>
@endsection