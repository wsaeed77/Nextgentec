
<div class="modal fade" id="modal-add-edit-contact" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Edit Contact</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="loc_msg_div_new" style="display:none">
              <ul id="loc_errors_new">
              </ul>
          </div>
         <form id="edit_cntct_form">
              <div class="col-lg-12">
                  <div class="form-group col-lg-4">
                      <label>First Name</label>
                  
                      {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control ",'id'=>'edit_cntct_f_name','required'=>'']) !!} 
                      <input type="hidden" name="edit_cnt_id">
                  </div>

                  <div class="form-group col-lg-4">
                      <label>Last Name</label>
                      {!! Form::input('text','l_name',null, ['placeholder'=>"Last Name",'class'=>"form-control",'id'=>'edit_cntct_l_name']) !!}
                  </div>
                  <div class="form-group col-lg-4">
                      <label>Title</label>
                      {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control",'id'=>'edit_cntct_title']) !!}
                  </div>
              </div>
              <div class="col-lg-12">
                  <div class="form-group col-lg-4">
                      <label>Email</label>
                      {!! Form::input('text','email',null, ['placeholder'=>"Email required",'class'=>"form-control",'id'=>'edit_cntct_email','required'=>'']) !!}
                  </div>

                  <div class="form-group col-lg-4">
                      <label>Phone</label>
                      {!! Form::input('text','contact_phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                  </div>
                  <div class="form-group col-lg-4">
                      <label>Mobile</label>
                      {!! Form::input('text','contact_mobile',null, ['placeholder'=>"Mobile Phone ",'class'=>"form-control dt_mask", 'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_mobile_number_mask.'"']) !!}
                  </div>
              </div>
                  
         </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default close_modal" id="update_close_modal"
                  data-dismiss="modal">Cancel</button>
              
          <button type="submit" class="btn btn-primary update_ajax_contact">
            Update
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
      $(".dt_mask").inputmask();
     
     
     $('#modal-add-edit-contact').on('show.bs.modal', function () {
     // do something…
      // $(this).find("input,textarea,select").val('').end();

            $('#f_name-error').remove();
            $('#email-error').remove();
       });

      $( ".update_ajax_contact" ).click(function() {
       if($('#edit_cntct_form').valid())
       {
        //console.log($('#modal-add-edit-contact').find('#edit_loc_form').serialize());
        var flag_ = save_contact($('#modal-add-edit-contact').find($('input[name="edit_cnt_id"]')).val());
        //add_contact();
        if(flag_)
        {
        $('#modal-add-edit-contact').find("input,textarea,select").val('').end();
     
          $( "#update_close_modal" ).trigger( "click" );
        }
      }
       // return false;

      });

      
    });
  </script>
@endsection