
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
          <div class="alert alert-danger"  id="vendor_cntct_msg_div_new" style="display:none">
              <ul id="vendor_contact_new_ul">
              </ul>
          </div>

          <form id="new_cntct_form">
           <input type="text" name="vendor_id" value="{{ $vendor->id }}" style="display: none;" />
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




      $('#modal-add-new-contact').on('hidden.bs.modal', function () {
          // do something…
          $(this).find("input,textarea,select").val('').end();

      });

      $( ".add_ajax_contact" ).click(function() {

        $.ajax({
          url: "{{ URL::route('admin.vendor.create_contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#new_cntct_form').serialize() ,
          success: function(response){
            if(response.success){

              $( "#add_close_modal" ).trigger( "click" );
              $('#tbody_contacts').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

              //refresh location contacts
             $.get("{{ URL::route('admin.vendor.ajax.refresh_contacts',$vendor->id)}}",function( data_response ) {
                                  $('#tbody_contacts').html(data_response);

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
        $('#vendor_contact_new_ul').html(html_error);
        $('#vendor_cntct_msg_div_new').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide();
        // Render the errors with js ...
      }
        });


      });


    });


  </script>
@endsection
