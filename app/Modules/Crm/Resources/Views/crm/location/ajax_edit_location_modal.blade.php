
<div class="modal fade" id="modal-edit-location" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Edit Location</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger"  id="loc_msg_div" style="display:none">
            <ul id="loc_errors">
            </ul>
        </div>

        <form id="loc_form" class="form-horizontal">
          <input type="hidden" name="loc_id" value="">
          <div class="form-group">
            <label for="location_name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              {!! Form::input('text','location_name',null, ['placeholder'=>"Location Name",'class'=>"form-control",'id'=>'location_name']) !!}
            </div>
          </div>
          <div class="col-sm-12 divider"></div>

          <div class="form-group">
            <label for="address" class="col-sm-2 control-label">Address</label>
            <div class="col-sm-10">
              {!! Form::input('text','address',null, ['placeholder'=>"Address",'class'=>"form-control",'id'=>'address']) !!}
            </div>
          </div>
          <div class="form-group">
            <label for="city" class="col-sm-2 control-label">City</label>
            <div class="col-sm-10">
              {!! Form::input('text','city',null, ['placeholder'=>"City",'class'=>"form-control" ,'id'=>'city']) !!}
            </div>
          </div>
          <div class="form-group">
            <label for="state" class="col-sm-2 control-label">State</label>
            <div class="col-sm-10">
              {!! Form::input('text','state',null, ['placeholder'=>"State",'class'=>"form-control",'id'=>'state']) !!}
            </div>
          </div>
          <div class="form-group">
            <label for="zip" class="col-sm-2 control-label">Zip</label>
            <div class="col-sm-10">
              {!! Form::input('text','zip',null, ['placeholder'=>"Zip",'class'=>"form-control" ,'id'=>'zip']) !!}
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
            <label for="loc_main_phone back_line_phone" class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-5">
              {!! Form::input('text','loc_main_phone',null, ['placeholder'=>"",'class'=>"form-control dt_mask",'id'=>'loc_main_phone','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
              <p class="help-block">Primary office phone number</p>
            </div>
            <div class="col-sm-5">
              {!! Form::input('text','back_line_phone',null, ['placeholder'=>"",'class'=>"form-control dt_mask",'id'=>'back_line_phone','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!}
              <p class="help-block">Back line phone number</p>
            </div>
          </div>

          <div class="form-group">
            <label for="primary_fax secondary_fax" class="col-sm-2 control-label">Fax</label>
            <div class="col-sm-5">
              {!! Form::input('text','primary_fax',null, ['placeholder'=>"",'class'=>"form-control dt_mask",'id'=>'primary_fax','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_fax_number_mask.'"']) !!}
              <p class="help-block">Primary fax number</p>
            </div>
            <div class="col-sm-5">
              {!! Form::input('text','secondary_fax',null, ['placeholder'=>"",'class'=>"form-control dt_mask",'id'=>'secondary_fax','data-mask'=>'','data-inputmask'=> '"mask": "'.$global_fax_number_mask.'"']) !!}
              <p class="help-block">Secondary fax number</p>
            </div>
          </div>

          <div class="col-sm-12 divider"></div>

          <div class="form-group">
            <label for="alarm_code door_code" class="col-sm-2 control-label">Codes</label>
            <div class="col-sm-5">
              {!! Form::input('text','alarm_code',null, ['placeholder'=>"",'class'=>"form-control",'id'=>'alarm_code']) !!}
              <p class="help-block">Alarm Code</p>
            </div>
            <div class="col-sm-5">
              {!! Form::input('text','door_code',null, ['placeholder'=>"",'class'=>"form-control",'id'=>'door_code']) !!}
              <p class="help-block">Door Code</p>
            </div>
          </div>

          <div class="form-group">
            <label for="notes" class="col-sm-2 control-label">Notes</label>
            <div class="col-sm-10">
              {!! Form::textarea('notes',null, ['placeholder'=>"Enter any location specific instructions here, e.g. Alaram panel is located down the hall on the right.",'class'=>"form-control textarea",'id'=>'notes','rows'=>3]) !!}
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  {!! Form::checkbox('default', 1,'',['id'=>'default']); !!} Primary Location
                </label>
              </div>
            </div>
          </div>

        </form>

      </div>
      <div class="modal-footer">



          <button type="button" class="btn btn-default" id="close_modal_edit_loc"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary update_ajax_location">
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
      $('#modal-edit-location').on('show.bs.modal', function(e)
      {
        var Id = $(e.relatedTarget).data('id');

        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.load_location')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: 'id='+Id,
          success: function(response){
              //console.log(response);
              //alert(response.location_name);
            $(e.currentTarget).find('input[name="loc_id"]').val(Id);
            $(e.currentTarget).find('input[name="location_name"]').val(response.location_name);
            $(e.currentTarget).find('input[name="address"]').val(response.address);
            $('option[value="'+response.country+'"]', $('#cntry_edit')).prop('selected', true);

                 $('#cntry_edit').multiselect('refresh');
            //$(e.currentTarget).find('input[name="country"]').val(response.country);
            $(e.currentTarget).find('input[name="city"]').val(response.city);
            $(e.currentTarget).find('input[name="zip"]').val(response.zip);
            $(e.currentTarget).find('input[name="state"]').val(response.state);
            $(e.currentTarget).find('input[name="loc_main_phone"]').val(response.phone);
            $(e.currentTarget).find('input[name="back_line_phone"]').val(response.back_line_phone);
            $(e.currentTarget).find('input[name="primary_fax"]').val(response.primary_fax);
            $(e.currentTarget).find('input[name="secondary_fax"]').val(response.secondary_fax);
            $(e.currentTarget).find('input[name="alarm_code"]').val(response.alarm_code);
            $(e.currentTarget).find('input[name="door_code"]').val(response.door_code);
            $(e.currentTarget).find('textarea[name="notes"]').val(response.notes);
            (response.default==1) ? $(e.currentTarget).find('input[name="default"]').prop('checked',true):$(e.currentTarget).find('input[name="default"]').prop('checked',false);
            //$(e.currentTarget).find('input[name="loc_main_phone"]').val(response.phone);
          }
        });


      });

      $( ".update_ajax_location" ).click(function() {

        $('#loc_tbl_'+Id).html('<img id="load_img" src="{{asset('img/loader.gif')}}"  />');
        //alert( "Handler for .click() called." );
         var Id = $('input[name="loc_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.update_location')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#loc_form').serialize() ,
          success: function(response){
            if(response.success){
              location.reload();
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
        $('#loc_errors').html(html_error);
        $('#loc_msg_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide();
        // Render the errors with js ...
      }
        });
      });


    });
  </script>
@endsection
