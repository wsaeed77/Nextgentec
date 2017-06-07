
<div class="modal fade" id="modal-add-new-customer" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Add Customer</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="vdr_msg_div_new" style="display:none">
              <ul id="vendor_cust_new_ul">
              </ul>
          </div>
         <form id="new_cust_form">
         
         <input type="text" name="vendor_id" value="{{ $vendor->id }}" style="display: none;" />
          <div class="form-group col-lg-3">
                <label>Customer</label>
                {!! Form::select('customer_id', $customers, '',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'cust_add_cust_id','required'=>'','onChange'=>'load_locations(this.value)'])!!}
            </div>
            <div class="form-group col-lg-3">
                <label>Location</label>
                <?php $locations = [];?>
                {!! Form::select('customer_location_id', $locations,null ,['class'=>'form-control multiselect','placeholder' => 'Pick a location','id'=>'location','required'=>'','disabled'=>''])!!}
               
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
                        {!! Form::textarea('customer_notes',null, ['placeholder'=>"Notes",'id'=>'cust_notes','class'=>"form-control",'rows'=>2]) !!}
                    </div>
        <div style="clear:both"></div>
        </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default close_modal" id="add_cust_close_modal"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_customer">
            Save
          </button>
         
      </div>

    </div>
  </div>
</div>


@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {
      
      
       
     
      $('#modal-add-new-customer').on('hidden.bs.modal', function () {
    // do something…
     //$(this).find("input,textarea,select").val('').end();

    });

            
        $( ".add_ajax_customer" ).click(function() {
          /*for ( instance in CKEDITOR.instances )
                 CKEDITOR.instances[instance].updateElement();*/
        $.ajax({
          url: "{{ URL::route('admin.vendor.create_customer')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#new_cust_form').serialize() ,
          success: function(response){
            if(response.success){
              
              $( "#add_cust_close_modal" ).trigger( "click" );
              $('#tbody_customers').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

              //refresh location contacts
             $.get("{{ URL::route('admin.vendor.ajax.refresh_customers',$vendor->id)}}",function( data_response ) {
                                  $('#tbody_customers').html(data_response);
                                  
                                },"html" 
              );
              
               alert_hide(); 
              
            }
          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#vendor_cust_new_ul').html(html_error);
        $('#vdr_msg_div_new').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
       

      });

      
    });

     function load_locations(id)
    {
      //console.log(id);
      if(id=='')
      {
        $('#location').html('');
        $('#location').multiselect('disable');
      }

      if(id!='')
      {
        $.get('/admin/crm/ajax_get_locations_list/'+id,function(response) {

          $('#location').html('');
          $('#location').multiselect('enable');
           $('#location').append($("<option></option>")
                               .attr("value",'')
                               .text('Select location'));
                  $.each(response.locations,function(index, location_data) {
                          //console.log(location_data);
                      $('#location').append($("<option></option>")
                               .attr("value",location_data.id)
                               .text( location_data.location_name));

                  });

                  $('#location').multiselect('rebuild');


                  $('#location').multiselect('refresh');

        },'json');
      }
   
    }
  </script>
@endsection