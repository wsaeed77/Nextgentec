@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
         Add Vendor
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
         <li >
           <a href="{{ URL::route('admin.vendors.index')}}"> <i class="fa fa-table"></i> Vendors</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Add Vendor
        </li>
    </ol>
@endsection



<section class="content">
    <div class="row">

        <div class="col-xs-12">

             <div id="err_msgs"></div>



           <div class="clearfix"></div>
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title ">Vendor Detail</h3>
                </div>


               
                    <div class="box-body">
                    @if(!empty(Session::get('cust_id')))
                        <div id="vendor_attach" >
                            <div class="form-group col-lg-5" >
                                <label>Select Vendor</label>
                                       
                                  <select class="js-data-example-ajax form-control" id="vendor_select2" onchange="load_customers(this.value)">
                                                            
                                  </select>
                            </div> 
                            <div class="form-group col-lg-4 pull-right">
                        
                               <br/>
                          <button class="btn btn-sm btn-default pull-right" onclick="show_vendor_form()">Add Vendor</button>
                            
                         
                        </div> 

                        </div>
                        @endif
                         <form id="vendor_form">
                        <div id="vendor_add" style="display: @if(empty(Session::get('cust_id'))) {{'block'}} @else {{'none'}} @endif;">
                           <div class="form-group col-lg-4">
                                <label>Name</label>
                                {!! Form::input('text','name',null, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
                                <input type="hidden" name="vendor_flag" value="add">
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Phone</label>
                            
                                {!! Form::input('text','phone',null, ['placeholder'=>"Main phone",'class'=>"form-control dt_mask",'id'=>'dt_mask', 'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!} 
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Website</label>
                                {!! Form::input('text','website',null, ['placeholder'=>"Website",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group col-lg-4">
                                <label>State</label>
                                {!! Form::input('text','state',null, ['placeholder'=>"State",'class'=>"form-control"]) !!}
                            </div>

                            <div class="form-group col-lg-4">
                                <label>City</label>
                            
                                {!! Form::input('text','city',null, ['placeholder'=>"City",'class'=>"form-control"]) !!} 
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Zip</label>
                                {!! Form::input('text','zip',null, ['placeholder'=>"zip",'class'=>"form-control"]) !!}
                            </div>
                             <div class="form-group col-lg-4">
                                <label>Address</label>
                                {!! Form::textarea('address',null, ['placeholder'=>"Address",'class'=>"form-control",'rows'=>'6']) !!}
                            </div>

                             <div class="form-group col-lg-8">
                                <label>Business Hours</label>
                             <div id="businessHoursContainer"></div>   
                            </div>
                              
                            <div class="form-group col-lg-12">
                                <label>Dialing instructions</label>
                                {!! Form::textarea('dialing_instructions',null, ['placeholder'=>"Dialing instructions",'id'=>'instructions','class'=>"form-control",'rows'=>2]) !!}
                            </div>
                        </div>
                    <div class="clearfix"></div>
                   </div>
                   <div id="cntct_div" style="display:none;">
                        <div class="box-header top-border bot_10px">
                        <h3 class="box-title">Vendor Contacts</h3>
                        
                        </div>

                        <div class="box-body no-padding ">
                        
                            <!--<div class="col-lg-12" id="contact_labels"></div>-->
                           
                                <table class="table table-hover">
                                    <tbody id="cntct_tbody"> 
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Title</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Mobile</th>
                                            <th>Action</th>
                                        </tr>
                                    </tbody>
                                </table>
                           
                        
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                      <div id="customer_div" style="display:none;">
                        <div class="box-header top-border bot_10px">
                        <h3 class="box-title">Vendor Contacts</h3>
                        
                        </div>

                        <div class="box-body no-padding ">
                        
                            <!--<div class="col-lg-12" id="contact_labels"></div>-->
                           
                                <table class="table table-hover">
                                    <tbody id="cust_tbody"> 
                                        <tr>
                                            <th>Customer</th>
                                            <th>Location</th>
                                            <th>Authorize name</th>
                                            <th>Account #</th>
                                           
                                            <th>Phone</th>
                                             <th>user name</th>
                                            <th>Password</th>
                                            <th>Action</th>
                                        </tr>
                                    </tbody>
                                </table>
                           
                        
                        </div>
                    </div>
                    

                <div class="form-group col-lg-6 pull-right">
                <button type="button" class="btn btn-primary btn-lg"
                                    data-toggle="modal" data-id="" id="modaal" data-target="#modal-add-new-customer">
                                        <i class="fa fa-plus-circle"></i> Attach Customer
                                    </button>
                 <button type="button" class="btn btn-primary btn-lg"
                                    data-toggle="modal" data-id="" id="modaal" data-target="#modal-add-new-contact">
                                        <i class="fa fa-plus-circle"></i> Add Contact
                                    </button>
                  <button class="btn btn-lg btn-info pull-right" type="button"  id="btn_submit" onclick="submit_vendor_form()">Save</button>
                </div>
                  <div class="clearfix"></div>

				</form>
                   </div>


                


            </div>
        </div>
    </div>
</section>

  @include('vendor::add.ajax_add_contact_modal')

  @include('vendor::add.ajax_add_customer_modal')
   @include('vendor::add.ajax_edit_contact_modal')
   @include('vendor::add.ajax_edit_customer_modal')
  @include('vendor::add.ajax_functions')
@endsection
@section('script')

{{--  <script src="/js/bootstrap3-wysihtml5.all.min.js"></script> --}}
<script type="text/javascript" src="{{URL::asset('js/jquery.validate.js')}}"></script> 
 {{--  <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script> --}}


    <script src="{{URL::asset('js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/jquery.inputmask.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/jquery.businessHours.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/jquery.timepicker.min.js')}}"></script>
    <script src="{{URL::asset('vendor/summernote/summernote.js')}}"></script>
<script src="{{URL::asset('vendor/summernote/summernote-floats-bs.min.js')}}"></script>



<script type="text/javascript">

function show_vendor_form()
    {
      $('#vendor_add').show();
      $('#vendor_attach').hide();
      $.get('{{URL::route('admin.crm.ajax_get_active_customers')}}',function(response) {

          $('#cust_add_cust_id').html('');
       
          $('#cust_add_cust_id').append($("<option></option>")
                             .attr("value",'')
                             .text('Select Customer'));
                $.each(response.customers,function(index, customer) {
                        //console.log(location_data);
                  $('#cust_add_cust_id').append($("<option></option>")
                                                 .attr("value",customer.id)
                                                 .text( customer.name));
                                                 //.attr((customer.disabled==true)?"disable":'');
                });

                $('#cust_add_cust_id').multiselect('rebuild');


                $('#cust_add_cust_id').multiselect('refresh');

        },'json');


    }

var businessHoursManager = {};
$(document).ready(function()
    {

       

        $('.datepicker').datepicker();
         $(".dt_mask").inputmask();
            
  
$('#instructions').summernote({ 
     callbacks: {
              onImageUpload: function(files) {
              //console.log(files);
              // console.log($editable);
            uploadImage(files[0],'vendor','instructions');
            }},
    lang: 'en-US',
    dialogsInBody: true,
    height: 400,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});


          $('#cust_notes').summernote({ 
     callbacks: {
              onImageUpload: function(files) {
              //console.log(files);
              // console.log($editable);
            uploadImage(files[0],'vendor','cust_notes');
            }},
    lang: 'en-US',
    dialogsInBody: true,
    height: 600,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});

    
      var b3 = $("#businessHoursContainer");
            businessHoursManager = b3.businessHours({
                postInit:function(){
                    b3.find('.operationTimeFrom, .operationTimeTill').timepicker({
                        'timeFormat': 'H:i',
                        'step': 15
                    });
                },
                dayTmpl: '<div class="dayContainer" style="width: 80px;">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"/></div>' +
                        '<div class="weekday"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""/></div>' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""/></div>' +
                        '</div></div>'
            });

    $("#vendor_select2").select2({
         ajax: {
          url: "{{URL::route('admin.ajax.vendors.json')}}",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params.term, // search term
            };
          },
          processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // console.log(data);
            // console.log(params);
           // params.page = params.page || 1;
            return {

              results: data.vendors,
            };
          },
          cache: true
        },
       
       
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
       // minimumInputLength: 1,
        placeholder: 'Please select a vendor',
        templateResult: function (item) { return item.text; }, // omitted for brevity, see the source of this page
        templateSelection: function (item) { return item.text; }, // omitted for brevity, see the source of this page

      // matcher: function(term, text) { return text.name.toUpperCase().indexOf(term.toUpperCase()) != -1; },
       
        tags: "true"
      });

    });

function submit_vendor_form()
{
    var data ='';
     if($('#vendor_attach').is(":visible")==true)
      {
        if($('#vendor_select2').val() == null)
        {
          $("html, body").animate({ scrollTop: 0 }, "slow");
           $('#err_msgs').addClass('alert alert-danger').html('<ul><li>Please select vendor</li></ul>');
           alert_hide();
           setTimeout(function(){
            $('#err_msgs').removeClass('alert alert-danger').html('');
           },5000);
           return false;
           
        }
        else
        {
          data += '&vendor_id='+$('#vendor_select2').val();
          data += '&vendor_flag=attach';
        }
      }

      if($('#vendor_add').is(':visible')==true)
        data += $('#vendor_form').serialize();

      data +='&contact_arr='+JSON.stringify(cntct_arr);
      data +='&cust_arr='+JSON.stringify(cust_arr);
      data +='&business_hours='+JSON.stringify(businessHoursManager.serialize());
      //console.log($('#vendor_form').serialize());
	 $.ajax({
        url: "{{ URL::route('admin.vendor.store')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response){
          //console.log(response);
          if(response.success=='yes')
            window.location = "{{URL::route('admin.vendors.index')}}";
            //alert('fff');
            //console.log(response);
           // window.location = "{{URL::route('admin.vendors.index')}}";


      }
    });  
}
 function load_customers(v_id)
    {
      //console.log(v_id);


        $.get('/admin/vendors/custs_not_attached_to_vendor/'+v_id,function(response) {

          $('#cust_add_cust_id').html('');
       
          $('#cust_add_cust_id').append($("<option></option>")
                             .attr("value",'')
                             .text('Select Customer'));
                $.each(response.customers,function(index, customer) {
                        //console.log(location_data);
                  $('#cust_add_cust_id').append($("<option></option>")
                                                 .attr("value",customer.id)
                                                 .text( customer.name));
                                                 //.prop('disabled',customer.disabled));
                                                 //.attr((customer.disabled==true)?"disable":'');
                });

                $('#cust_add_cust_id').multiselect('rebuild');


                $('#cust_add_cust_id').multiselect('refresh');

      },'json');

    }
</script>
@endsection
@section('styles')
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
 {{--  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"> --}}
  <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">
   <link rel="stylesheet" href="{{URL::asset('css/jquery.businessHours.css')}}">
   <link rel="stylesheet" href="{{URL::asset('css/jquery.timepicker.min.css')}}">
    <link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">

<style>
    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
    .top-18px{
        top: 18px;
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

</style>
@endsection
