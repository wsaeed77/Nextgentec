
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
          <div class="alert alert-danger"  id="cntct_msg_div" style="display:none">
              <ul id="cntct_errors">
              </ul>
          </div>

          <form id="cntct_form" class="form-horizontal">
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
                {!! Form::select('location_index', $location_index,'',['class'=>'form-control multiselect','id'=>'cnt_location'])!!}
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

          </form>

      </div>
      <div class="modal-footer">



          <button type="button" class="btn btn-default" id="close_modal_cntct"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary update_ajax_contact">
            Update
          </button>

      </div>

    </div>
  </div>
</div>

@section('styles')
@parent

<style>
.modal-dialog {
  margin: 30px auto;
  /*width: 50%;*/
}
</style>

@endsection

@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function()
    {
      $(".dt_mask").inputmask();

      $('#modal-edit-contact').on('show.bs.modal', function(e)
      {
        var Id = $(e.relatedTarget).data('id');
        var CustId = $(e.relatedTarget).data('custid');

        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.load_contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: 'cntct_id='+Id+'&customer_id='+CustId,
          success: function(response) {
             //console.log(response.locations.length);
         //console.log(response.contact.customer_location_id);
              if(response.locations.length>0)
            {
              $('#cnt_location').html('');
                $.each(response.locations,function(index, location_data) {
                        //console.log(location_data);
                    $('#cnt_location').append($("<option></option>")
                             .attr("value",location_data.id)
                             .text( location_data.location_name));
                });
                $('#cnt_location').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                  dropUp: false,
                  buttonClass: 'form-control',
                  onChange: function(option, checked, select) {
                      //alert($('#multiselect').val());
                  }
                });

                $('#cnt_location').multiselect('rebuild');

                $('option[value="'+response.contact.customer_location_id+'"]', $('#cnt_location')).prop('selected', true);

                $('#cnt_location').multiselect('refresh');


            }

            $(e.currentTarget).find('input[name="cntct_id"]').val(Id);
            $(e.currentTarget).find('input[name="customer_id"]').val(CustId);
            $(e.currentTarget).find('input[name="f_name"]').val(response.contact.f_name);
            $(e.currentTarget).find('input[name="l_name"]').val(response.contact.l_name);
            $(e.currentTarget).find('input[name="title"]').val(response.contact.title);
            $(e.currentTarget).find('input[name="email"]').val(response.contact.email);
            $(e.currentTarget).find('input[name="contact_phone"]').val(response.contact.phone);
            $(e.currentTarget).find('input[name="phone_ext"]').val(response.contact.phone_ext);
            $(e.currentTarget).find('input[name="contact_mobile"]').val(response.contact.mobile);
            $(e.currentTarget).find('input[name="address"]').val(response.contact.address);
            $(e.currentTarget).find('input[name="city"]').val(response.contact.city);
            $(e.currentTarget).find('input[name="zip"]').val(response.contact.zip);
            $(e.currentTarget).find('input[name="state"]').val(response.contact.state);
            $(e.currentTarget).find('input[name="country"]').val(response.contact.country);
            (response.contact.is_poc==1) ? $("#chk_poc").prop('checked',true):$("#chk_poc").prop('checked',false);
            //$(e.currentTarget).find('input[name="loc_main_phone"]').val(response.phone);
          }
        });


      });


         $( ".update_ajax_contact" ).click(function() {
        //alert( "Handler for .click() called." );
         var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.update_contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#cntct_form').serialize() ,
          success: function(response){
            if(response.success){
              setTimeout(function(){
                $(".update_ajax_contact").html('Success');
                $(".update_ajax_contact").toggleClass('btn-success btn-primary');
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
        $('#cntct_errors').html(html_error);
        $('#cntct_msg_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide();
        // Render the errors with js ...
      }
        });
      });

        });

  </script>
@endsection
