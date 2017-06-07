
<div class="modal fade" id="modal-edit-customer-info" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Update Info</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="info_msg_div" style="display:none">
              <ul id="loc_errors">
              </ul>
          </div>
         <form id="info_form">
         <input type="hidden" name="c_id" value="">


            <div class="form-group col-lg-6">
                <label>Cutomer Name</label>
                {!! Form::input('text','customer_name',null, ['placeholder'=>"Cutomer Name",'class'=>"form-control required",'id'=>'customer']) !!}


            </div>
             <div class="form-group col-lg-6">
                <label>Main Phone</label>
                {!! Form::input('text','phone',null, ['placeholder'=>"Main phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"','id'=>'phone']) !!}

            </div>

            <div class="form-group col-lg-6">
                <label>Email domain</label>
                {!! Form::input('text','email_domain',null, ['placeholder'=>"Email Domain",'class'=>"form-control "]) !!}

            </div>
            <div class="form-group col-lg-6">
                <label>Customer since</label>
                 {!! Form::input('text','customer_since',null, ['placeholder'=>"Customer since",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
            </div>

            <div class="form-group col-lg-6">
              <label>Credit Limit</label>
              {!! Form::input('text','credit_limit',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
            </div>

            <div class="col-lg-12">
            <div class="form-group col-lg-6">
                <label>Active? </label>
                <label class="radio-inline">{!! Form::radio('active', 1) !!} Yes</label>
                 <label class="radio-inline">{!! Form::radio('active', 0) !!}No</label>

            </div>
             <div class="form-group col-lg-6">
                <label>Is Taxable</label>
                {!! Form::checkbox('taxable', 1); !!}
            </div>
            </div>

                <div style="clear:both"></div>
        </form>
      </div>
      <div class="modal-footer">



          <button type="button" class="btn btn-default btn_close" id="close_modal"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary update_ajax_info">
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

      $('#modal-edit-customer-info').on('show.bs.modal', function(e)
      {
        var Id = $(e.relatedTarget).data('id');


         $.get('/admin/crm/ajax_load_customer_info/'+Id,function(response) {
                  //$('#location_'+loc_id).html(data_response);
                  $(e.currentTarget).find('input[name="c_id"]').val(Id);
                  $(e.currentTarget).find('input[name="customer_name"]').val(response.customer_name);
                  $(e.currentTarget).find('input[name="phone"]').val(response.phone);
                  $(e.currentTarget).find('input[name="email_domain"]').val(response.email_domain);
                  $(e.currentTarget).find('input[name="customer_since"]').val(response.customer_since);
                  $(e.currentTarget).find('input[name="credit_limit"]').val(response.credit_limit);

                  (response.is_taxable==1) ? $(e.currentTarget).find('input[name="taxable"]').prop('checked',true):$(e.currentTarget).find('input[name="taxable"]').prop('checked',false);

                  (response.is_active==1) ? $(e.currentTarget).find('input[name="active"][value =1]').prop('checked',true):$(e.currentTarget).find('input[name="active"][value =0]').prop('checked',true);

                  //$('#radio_button').attr("checked", "checked");
                  $('.datepicker').datepicker();
                },"json");
     });

      $(".update_ajax_info").click(function() {


        //$('#loc_tbl_'+Id).html('<img id="load_img" src="{{asset('img/loader.gif')}}" />');
        //alert( "Handler for .click() called." );
         var customer_id= $('input[name="c_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.update_customer_info')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#info_form').serialize() ,
          success: function(response){
            if(response.success){
              setTimeout(function(){
                $(".update_ajax_info").html('Success');
                $(".update_ajax_info").toggleClass('btn-success btn-primary');
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
        $('#loc_errors').html(html_error);
        $('#loc_msg_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide();
        // Render the errors with js ...
      }
        });
      });


   $(".dt_mask").inputmask();

    });
  </script>
@endsection

<style>
.datepicker{z-index:1151 !important;}
</style>
