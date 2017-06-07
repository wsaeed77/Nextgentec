
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
      <div class="col-lg-10" id="vendor_select_div">
       <div class="form-group col-lg-5" >
        <label>Select Vendor</label>

        <select class="js-data-example-ajax form-control" id="vendor_select2" >
                         {{--  @foreach($current_selected_vendors as $selected)
                            <option value="{{$selected->id}}" disabled>{{$selected->name}}</option>
                         
                            @endforeach --}}
                          </select>
                        </div> 

                        <div class="form-group col-lg-4">

                         <br/>
                         <button class="btn btn-sm btn-default" onclick="show_vendor_form()">Add Vendor</button>

                         
                       </div> 
                     </div>


                     <div class="clearfix"></div>
                     <div id="vendor_form_div"  style="display: none;">
                      <h3 class="box-title top-bottom-border">Add Vendor</h3> 
                      <form id="vendor_form">
                       <div class="box-body">
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

                        <div class="clearfix"></div>
                      </div>

                      
                      <div class="clearfix"></div>

                    </form>

                    <div class="clearfix"></div>
                  </div>
                  <h3 class="box-title top-bottom-border">Attach Customer</h3> 
                  <form id="new_cust_form">

                    <?php if(!empty(Session::get('cust_id')))
                    $selected_cust = Session::get('cust_id');
                    else
                      $selected_cust ='';
                    ?>
                    <div class="form-group col-lg-3">
                      <label>Customer</label>
                      @if($selected_cust !='') 
                      {!! Form::select('customer_selected_id', $customers,$selected_cust ,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'cust_add_cust_id','required'=>'', 'disabled'=>''])!!}
                      @else
                      {!! Form::select('customer_selected_id', $customers,$selected_cust ,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'cust_add_cust_id','required'=>''])!!}
                      @endif
                      <input type="hidden" name="customer_selected_id" value="{{$selected_cust}}" >
                    </div>

                    <div class="form-group col-lg-3">
                      <label>Location</label>

                      {!! Form::select('customer_location_id', $current_customer_locations,null ,['class'=>'form-control multiselect','id'=>'cust_location','placeholder' => 'Pick a location','required'=>''])!!}

                    </div>
                    <div class="form-group col-lg-3">
                      <label>Authorized Contact Name</label>
                      {!! Form::input('text','auth_contact_name',null, ['placeholder'=>"Authorized Contact Name",'class'=>"form-control",'id'=>'cust_add_auth_name','required'=>'']) !!} 
                    </div>
                    <div class="form-group col-lg-3">
                      <label>Phone Number</label>
                      {!! Form::input('text','cust_phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                    </div>
                    <div class="form-group col-lg-3">
                      <label>Account Number</label>
                      {!! Form::input('text','account_number',null, ['placeholder'=>"Account Number",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-3">
                      <label>Portal URL</label>
                      {!! Form::input('text','portal_url',null, ['placeholder'=>"Portal URL",'class'=>"form-control"]) !!}
                    </div>

                    <div class="form-group col-lg-3">
                      <label>Username</label>
                      {!! Form::input('text','cust_user_name',null, ['placeholder'=>"User name",'class'=>"form-control"]) !!}
                    </div>

                    <div class="form-group col-lg-3">
                      <label>Password</label>
                      {!! Form::input('text','cust_password',null, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-12">
                      <label>Notes</label>
                      {!! Form::textarea('customer_notes',null, ['placeholder'=>"Notes",'id'=>'cust_notes','class'=>"form-control",'rows'=>10]) !!}
                    </div>
                    <div style="clear:both"></div>

                    <div class="form-group col-lg-6 pull-right">

                     <button class="btn btn-lg btn-info pull-right" type="button"  id="btn_submit" onclick="submit_vendor_form()">Save</button>
                   </div>
                   <div class="clearfix"></div>

                 </form>


               </div>
             </div>
           </div>
         </section>

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
          .top-bottom-border{
            border-top: 1px solid #f4f4f4;
            border-bottom: 1px solid #f4f4f4;
            padding-top: 10px;
            padding-bottom: 10px;
            margin-bottom: 10px;
            padding-left: 10px;
          }

        </style>
        @endsection





        @section('script')
        @parent

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
  var businessHoursManager = {};
  var data = '';
  $(document).ready(function() 
  {



    $('.datepicker').datepicker();
    $(".dt_mask").inputmask();

/*      $('#cust_notes').summernote({ 
           callbacks: {
                    onImageUpload: function(files) {
                    //console.log(files);
                    // console.log($editable);
                  uploadImage(files[0],'vendor','cust_notes');
                  }},
          lang: 'en-US',
          dialogsInBody: true,
          height: 400,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: true});*/

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
       templateResult: function (item) { 
         // console.log('kkk');
          return item.text; }, // omitted for brevity, see the source of this page
        templateSelection: function (item) { return item.text; }, // omitted for brevity, see the source of this page

      // matcher: function(term, text) { return text.name.toUpperCase().indexOf(term.toUpperCase()) != -1; },

      tags: "true"
    }).on('select2:select', function (evt) {

       $.get('/admin/vendors/locations_list_json/'+$("#vendor_select2").val(),function(response) {

                    $('#cust_location').html('');
                    $('#cust_location').multiselect('enable');
                     $('#cust_location').append($("<option></option>")
                                         .attr("value",'')
                                         .text('Select location'));
                            $.each(response.locations,function(index, location_data) {
                                    //console.log(location_data);
                                $('#cust_location').append($("<option></option>")
                                         .attr("value",location_data.id)
                                         .text( location_data.location_name));

                            });
                           
                            $('#cust_location').multiselect('rebuild');


                            $('#cust_location').multiselect('refresh');

                  },'json');

    });;




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


     // $(".dt_mask").inputmask();


   /*   $( ".add_ajax_customer" ).click(function() {
        add_customer();
        $('#customer_div').show();
        $( "#add_cust_close_modal" ).trigger( "click" );
       // console.log(cntct_arr);
        return false;
 
      });*/

      
    });

function submit_vendor_form()
{
      //console.log($('#vendor_select').serialize());
      //console.log($('#vendor_select_div').is(":visible"));
      if($('#vendor_select_div').is(":visible")==true)
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

      
      data += '&'+$('#new_cust_form').serialize();

      if($('#vendor_select_div').is(":visible")==false)
      {
        data += '&'+$('#vendor_form').serialize();
        data += '&business_hours='+JSON.stringify(businessHoursManager.serialize());
      }
      
      $.ajax({
        url: "{{ URL::route('admin.vendor.store.cust_selected')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response){
            //alert('fff');
            $("html, body").animate({ scrollTop: 0 }, "slow");
            if(response.success)
             $('#err_msgs').addClass('alert alert-success').html('<ul><li>'+response.success+'</li></ul>').show();
           alert_hide();

            //console.log(response);
            setTimeout(function(){
            //window.location = "{{URL::route('admin.vendors.index')}}";
          },5000);
            


          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '<ul>';
            $.each(errors, function (key, value)
            {
              html_error +='<li>'+value+'</li>';
            });

            html_error += '</ul>';

            $("html, body").animate({ scrollTop: 0 }, "slow");
            $('#err_msgs').addClass('alert alert-danger').html(html_error).show();

         /*alert_hide();
         setTimeout(function(){
            $('#err_msgs').removeClass('alert alert-danger').html('');
          },5000);*/
        // Render the errors with js ...
      }
    });  



    }



    function show_vendor_form()
    {
      $('#vendor_form_div').show();
      $('#vendor_select_div').hide();
    }


  </script>
  @endsection