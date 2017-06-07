
<div class="modal fade" id="modal-edit-customer" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Edit Customer</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="cust_msg_div_edit" style="display:none">
              <ul id="vendor_cust_edit_ul">
              </ul>
          </div>
         <form id="edit_cust_form">
         
         <input type="hidden" name="vendor_id" value=""/>
         <input type="hidden" name="cust_id" value=""/>
          <div class="form-group col-lg-3">
                        <label>Customer</label>
                        {!! Form::select('customer_id', $customers, '',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'cust_edit_cust_id','required'=>'','onChange'=>'edit_load_locations(this.value)'])!!}
                        
                    </div>
                     <div class="form-group col-lg-3">
                        <label>Location</label>
                        <?php $locations = [];?>
                        {!! Form::select('customer_location_id', $locations,null ,['class'=>'form-control multiselect','placeholder' => 'Pick a location','id'=>'edit_location','required'=>''])!!}
                       
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
                        {!! Form::textarea('customer_notes',null, ['placeholder'=>"Notes",'id'=>'edit_cust_notes','class'=>"form-control",'rows'=>2]) !!}
                    </div>
        <div style="clear:both"></div>
        </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default close_modal" id="edit_cust_close_modal"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary edit_ajax_customer">
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
      
       $('#modal-edit-customer').on('show.bs.modal', function (e) {

        var Id = $(e.relatedTarget).data('id');
         $.get('/admin/vendors/edit_customer/'+Id,function(response ) {


         //console.log(response);

         /* if(CKEDITOR.instances.edit_cust_notes)
          CKEDITOR.instances.edit_cust_notes.destroy();*/

          $('option[value="'+response.customer.customer_id+'"]', $('#cust_edit_cust_id')).prop('selected', true);
           $('#cust_edit_cust_id').multiselect('refresh');
       
              $(e.currentTarget).find('input[name="auth_contact_name"]').val(response.customer.auth_contact_name);
              $(e.currentTarget).find('input[name="cust_phone"]').val(response.customer.phone_number);
              $(e.currentTarget).find('input[name="account_number"]').val(response.customer.account_number);
              $(e.currentTarget).find('input[name="portal_url"]').val(response.customer.portal_url);
              
              $(e.currentTarget).find('input[name="cust_user_name"]').val(response.customer.portal_username);

              $(e.currentTarget).find('input[name="cust_password"]').val(response.customer.portal_password);
               $(e.currentTarget).find('textarea[name="customer_notes"]').val(response.customer.notes);
                $(e.currentTarget).find('input[name="cust_id"]').val(Id);  
              $(e.currentTarget).find('input[name="vendor_id"]').val($(e.relatedTarget).data('vendor_id'));  

           /*   CKEDITOR.replace( 'edit_cust_notes', {
               filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
               filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
           });*/
             
                 edit_load_locations(response.customer.customer_id);

                 $('option[value="'+response.customer.location_id+'"]', $('#edit_location')).prop('selected', true);
                  $('#edit_location').multiselect('refresh');

                                    
                                  },"json" 
                );



    });
       
     
      $('#modal-edit-customer').on('hidden.bs.modal', function () {
    // do something…
    // $(this).find("input,textarea,select").val('').end();

    });

            
        $( ".edit_ajax_customer" ).click(function() {
          /*for ( instance in CKEDITOR.instances )
                 CKEDITOR.instances[instance].updateElement();*/
        $.ajax({
          url: "{{ URL::route('admin.vendor.update.customer')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#edit_cust_form').serialize() ,
          success: function(response){
            if(response.success){
              
              $( "#edit_cust_close_modal" ).trigger( "click" );
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
        $('#vendor_cust_edit_ul').html(html_error);
        $('#cust_msg_div_edit').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
       

      });

      
    });

       function edit_load_locations(id)
    {
      //console.log(id);
      if(id=='')
      {
        $('#edit_location').html('');
        $('#edit_location').multiselect('disable');
      }

      if(id!='')
      {
        jQuery.ajaxSetup({async:false});
        $.get('/admin/crm/ajax_get_locations_list/'+id,function(response) {

          $('#edit_location').html('');
          $('#edit_location').multiselect('enable');
           $('#edit_location').append($("<option></option>")
                               .attr("value",'')
                               .text('Select location'));
                  $.each(response.locations,function(index, location_data) {
                          //console.log(location_data);
                      $('#edit_location').append($("<option></option>")
                               .attr("value",location_data.id)
                               .text( location_data.location_name));

                  });

                  $('#edit_location').multiselect('rebuild');


                  $('#edit_location').multiselect('refresh');

        },'json');
      }
    jQuery.ajaxSetup({async:true});
    }
  </script>
@endsection