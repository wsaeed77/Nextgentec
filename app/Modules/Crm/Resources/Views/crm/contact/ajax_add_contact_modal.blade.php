
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
          <div class="alert alert-danger"  id="cntct_msg_div_new" style="display:none">
              <ul id="cntct_errors_new">
              </ul>
          </div>

          <form id="new_cntct_form" class="form-horizontal">
            <input type="hidden" name="cntct_id" value="">
            <input type="hidden" name="customer_id" value="">

            <div class="form-group">
              <label for="f_name l_name" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-5">
                {!! Form::input('text','f_name',null, ['placeholder'=>"First",'class'=>"form-control"]) !!}
              </div>
              <div class="col-sm-5">
                {!! Form::input('text','l_name',null, ['placeholder'=>"Last",'class'=>"form-control"]) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="title" class="col-sm-2 control-label">Title</label>
              <div class="col-sm-5">
                {!! Form::input('text','title',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="location_index" class="col-sm-2 control-label">Location</label>
              <div class="col-sm-5">
                <?php $location_index = [];?>
                {!! Form::select('location_index', $location_index,'',['class'=>'form-control multiselect','id'=>'new_cnt_location'])!!}
              </div>
            </div>

            <div class="col-sm-12 divider"></div>

            <div class="form-group">
              <label for="email" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-5">
                {!! Form::input('text','email',null, ['placeholder'=>"",'class'=>"form-control",'id'=>'cnt_email']) !!}
              </div>
            </div>

            <div class="form-group">
              <label for="contact_phone phone_ext contact_mobile" class="col-sm-2 control-label">Phone</label>
              <div class="col-sm-5">
                {!! Form::input('text','contact_phone',null, ['placeholder'=>"",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
                <p class="help-block">Office phone number</p>
              </div>
              <div class="col-sm-5">
                {!! Form::input('text','phone_ext',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
                <p class="help-block">Desk extension</p>
              </div>
              <div class="col-sm-2"></div>
              <div class="col-sm-5">
                {!! Form::input('text','contact_mobile',null, ['placeholder'=>"",'class'=>"form-control dt_mask", 'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_mobile_number_mask.'"']) !!}
                <p class="help-block" style="margin-bottom: 0;">Mobile phone number</p>
              </div>
            </div>

            <div class="col-sm-12 divider"></div>

            <div class="form-group">
              <label for="address" class="col-sm-2 control-label">Address</label>
              <div class="col-sm-10">
                {!! Form::input('text','address',null, ['placeholder'=>"Personal Address",'class'=>"form-control",'id'=>'address']) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="city" class="col-sm-2 control-label">City</label>
              <div class="col-sm-10">
                {!! Form::input('text','city',null, ['placeholder'=>"",'class'=>"form-control" ,'id'=>'city']) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="state" class="col-sm-2 control-label">State</label>
              <div class="col-sm-10">
                {!! Form::input('text','state',null, ['placeholder'=>"",'class'=>"form-control",'id'=>'state']) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="zip" class="col-sm-2 control-label">Zip</label>
              <div class="col-sm-10">
                {!! Form::input('text','zip',null, ['placeholder'=>"",'class'=>"form-control" ,'id'=>'zip']) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="country" class="col-sm-2 control-label">Country</label>
              <div class="col-sm-5">
                {!! Form::select('country', $countries,'United States',['class'=>'form-control multiselect','id'=>'cntry_edit','placeholder' => 'Pick a Country'])!!}
              </div>
            </div>

            <div class="col-sm-12 divider"></div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    {!! Form::checkbox('primary_poc', 1,'',['id'=>'chk_poc']); !!} Primary Contact
                  </label>
                </div>
              </div>
            </div>

      </div>
      </form>
      <div class="modal-footer">



          <button type="button" class="btn btn-default" id="close_modal_new_cntct"
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
       $('#modal-add-new-contact').on('hidden.bs.modal', function () {
        // do something…
         $(this).find("input,textarea,select").val('').end();

        });

      $(".dt_mask").inputmask();

      $('#modal-add-new-contact').on('show.bs.modal', function(e)
      {

         //$(this).find(':input').val('');
        //var Id = $(e.relatedTarget).data('id');
        var CustId = $(e.relatedTarget).data('id');
$('input[name="new_contct_customer_id"]').val(CustId);
         $.get('/admin/crm/ajax_get_locations_list/'+CustId,function( data_response ) {

                $('#new_cnt_location').html('');
                $.each(data_response.locations,function(index, location_data) {
                        //console.log(location_data);
                    $('#new_cnt_location').append($("<option></option>")
                             .attr("value",location_data.id)
                             .text( location_data.location_name));

                });


                $('#new_cnt_location').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                  dropUp: false,
                  buttonClass: 'form-control',
                  onChange: function(option, checked, select) {
                      //alert($('#multiselect').val());
                  }
                });
                $('#new_cnt_location').multiselect('rebuild');


                $('#new_cnt_location').multiselect('refresh');


                                },"json"
              );



      });

      $( ".add_ajax_contact" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.add_contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'post',
          dataType: 'json',
          data:$('#new_cntct_form').serialize() ,
          success: function(response){
            //console.log(response);
            if(response.success){
              setTimeout(function(){
                $(".add_ajax_contact").html('Success');
                $(".add_ajax_contact").toggleClass('btn-success btn-primary');
                location.reload();
              }, 300);
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
        $('#cntct_errors_new').html(html_error);
        $('#cntct_msg_div_new').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide();
        // Render the errors with js ...
      }
        });
      });


    });
  </script>
@endsection
