
<div class="modal fade" id="modal-edit-contact" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Edit Contact</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="cntct_msg_div_edit" style="display:none">
              <ul id="cntct_errors_edit_ul">
              </ul>
          </div>

          <form id="edit_cntct_form">
              <div class="col-lg-12">
                  <div class="form-group col-lg-4">
                      <label>First Name</label>

                      {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control ",'id'=>'add_f_name','required'=>'']) !!}
                      <input type="hidden" value="" name="cntct_id">
                      <input type="hidden" value="{{$vendor->id}}" name="vendor_id">
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



          <button type="button" class="btn btn-default close_modal" id="cntct_edit_close_modal"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary edit_ajax_contact">
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

       $('#modal-edit-contact').on('show.bs.modal', function (e) {

        var Id = $(e.relatedTarget).data('id');
       // console.log("{{URL::route('admin.vendor.update.info')}}");
        $.get('/admin/vendors/edit_contact/'+Id,function(response ) {

              $(e.currentTarget).find('input[name="f_name"]').val(response.contact.f_name);
              $(e.currentTarget).find('input[name="l_name"]').val(response.contact.l_name);
              $(e.currentTarget).find('input[name="title"]').val(response.contact.title);
              $(e.currentTarget).find('input[name="email"]').val(response.contact.email);
              $(e.currentTarget).find('input[name="contact_phone"]').val(response.contact.phone);
              $(e.currentTarget).find('input[name="contact_mobile"]').val(response.contact.mobile);

              $(e.currentTarget).find('input[name="cntct_id"]').val(Id);
              $(e.currentTarget).find('input[name="vendor_id"]').val({{$vendor->id}});

                                  },"json"
                );

      });


      $('#modal-edit-contact').on('hidden.bs.modal', function () {
          // do something…
          $(this).find("input,textarea,select").val('').end();

      });

        $( ".edit_ajax_contact" ).click(function() {

        $.ajax({
          url: "{{ URL::route('admin.vendor.update.contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#edit_cntct_form').serialize() ,
          success: function(response){
            if(response.success){

              $( "#cntct_edit_close_modal" ).trigger( "click" );
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
        $('#cntct_errors_edit_ul').html(html_error);
        $('#cntct_msg_div_edit').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide();
        // Render the errors with js ...
      }
        });


      });


    });


  </script>
@endsection
