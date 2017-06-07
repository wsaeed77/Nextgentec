
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
          <div class="alert alert-danger"  id="loc_msg_div_new" style="display:none">
              <ul id="cust_errors_new">
              </ul>
          </div>
         <form id="edit_cust_form">
         
         
         <div class="form-group col-lg-3">
                        <label>Customer</label>
                        {!! Form::select('customer_id', $customers, '',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'cust_edit_cust_id','required'=>''])!!}
                        <input type="hidden" name="edit_cust_id">
                    </div>
                     <div class="form-group col-lg-3">
                        <label>Location</label>
                        <?php $locations = [];?>
                        {!! Form::select('customer_location_id', $locations,null ,['class'=>'form-control multiselect','placeholder' => 'Pick a location','id'=>'edit_location','required'=>''])!!}
                       
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Authorized Contact Name</label>
                       {!! Form::input('text','auth_contact_name',null, ['placeholder'=>"Authorized Contact Name",'class'=>"form-control",'id'=>'cust_edit_auth_name','required'=>'']) !!} 
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
            Update
          </button>
         
      </div>

    </div>
  </div>
</div>


<style>
  
  .modal-dialog {
    margin: 30px auto;
    width: 75%;
}
</style>
@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {
      $(".dt_mask").inputmask();
      
        $('#modal-edit-customer').on('show.bs.modal', function () {

          $('#cust_edit_cust_id').multiselect('disable');

          
         /* if(CKEDITOR.instances.edit_cust_notes)
          CKEDITOR.instances.edit_cust_notes.destroy();
          //CKEDITOR.remove('edit_cust_notes');
          CKEDITOR.replace( 'edit_cust_notes', {
                  filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                  filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                  height :500
              } );*/

});

     
      $('#modal-edit-customer').on('hidden.bs.modal', function () {
    // do something…
           $(this).find("input,textarea,select").val('').end();


      });

      $( ".edit_ajax_customer" ).click(function() {
      
       if($('#edit_cust_form').valid())
       {
        //console.log($('#modal-add-edit-contact').find('#edit_loc_form').serialize());
        var flag_ = save_customer($('#modal-edit-customer').find($('input[name="edit_cust_id"]')).val());
        //add_contact();
        if(flag_)
        {
        $('#modal-edit-customer').find("input,textarea,select").val('').end();
     
          $( "#edit_cust_close_modal" ).trigger( "click" );
        }
      }
       
       // console.log(cntct_arr);
        return false;
 
      });

      
    });
  </script>
@endsection