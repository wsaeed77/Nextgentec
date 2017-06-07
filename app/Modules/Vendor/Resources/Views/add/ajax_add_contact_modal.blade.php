
<div class="modal fade" id="modal-add-new-contact" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Add Contact</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="loc_msg_div_new" style="display:none">
              <ul id="loc_errors_new">
              </ul>
          </div>
                 
          <form id="new_cntct_form">
              <div class="col-lg-12">
                  <div class="form-group col-lg-4">
                      <label>First Name</label>
                  
                      {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control ",'id'=>'add_f_name','required'=>'']) !!} 
                      
                  </div>

                  <div class="form-group col-lg-4">
                      <label>Last Name</label>
                      {!! Form::input('text','l_name',null, ['placeholder'=>"Last Name",'class'=>"form-control",'id'=>'add_l_name']) !!}
                  </div>
                  <div class="form-group col-lg-4">
                      <label>Title</label>
                      {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control",'id'=>'add_title']) !!}
                  </div>
              </div>
              <div class="col-lg-12">
                  <div class="form-group col-lg-4">
                      <label>Email</label>
                      {!! Form::input('text','email',null, ['placeholder'=>"Email required",'class'=>"form-control",'id'=>'add_email','required'=>'']) !!}
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
       

        <div style="clear:both"></div>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default close_modal" id="add_close_modal"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_contact">
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
      //$("#new_cntct_form").validate();
      $(".dt_mask").inputmask();
      
         $('#modal-add-new-contact').on('show.bs.modal', function () {
            // do something…
            $(this).find("input,textarea,select").val('').end();

        });
     
      $('#modal-add-new-contact').on('hidden.bs.modal', function () {
          // do something…
          $(this).find("input,textarea,select").val('').end();

      });

      $( ".add_ajax_contact" ).click(function() {
       if($("#new_cntct_form").valid())
       {
         var flag_ =  add_contact();
          $('#cntct_div').show();
          if(flag_)
          $( "#add_close_modal" ).trigger( "click" );
      }
        return false;

      });

      
    });

    function sss()
    {
      alert('hi');
    }
  </script>
@endsection