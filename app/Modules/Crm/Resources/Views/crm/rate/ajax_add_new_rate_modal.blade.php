
<div class="modal fade" id="modal-add-new-rate" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Add Rate</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="rate_msg_div" style="display:none">
              <ul id="loc_errors">
              </ul>
          </div>
         <form id="rate_form_add">
        
          <input type="hidden" name="servc_item_id_new_rate" value="">
        <div class="form-group col-lg-6">
            <label>Title</label>
            {!! Form::input('text','title',null, ['placeholder'=>"Rate title",'class'=>"form-control",'id'=>'rate_title']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label>Amount</label>
            {!! Form::input('text','amount',null, ['placeholder'=>"0.00",'class'=>"form-control",'id'=>'amount']) !!}
        </div>
        
        <div class="form-group col-lg-6">
                <label class="radio-inline">{!! Form::checkbox('default', 'def_rate',false,['id'=>'default']); !!}</label>
                <label>Default ?</label>
        </div>

         <div class="form-group col-lg-6">
                <label class="radio-inline">{!! Form::checkbox('status', 'active',false,['id'=>'status']); !!}</label>
                <label>Active ?</label>
        </div>
        <div style="clear:both"></div>
        </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default" id="close_modal_service_item_new_rate"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_rate">
            Add
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
       
      $('#modal-add-new-rate').on('show.bs.modal', function(e) 
      {
       
        // $(this).find(':input').val('');
        // $(this).find('input:checkbox').removeAttr('checked');
         //input:checkbox
          //$(this).find(':input[""').attr('checked', true);
         //$(this).find(':radio').val('');
         //$(this).find(':input').val('');
        var service_itm_id = $(e.relatedTarget).data('srvcitemid');

        
            $(e.currentTarget).find('input[name="servc_item_id_new_rate"]').val(service_itm_id);

            
           

      
      });


      $('#odal-add-new-rate').on('hidden.bs.modal', function () {
        $(this).find(':input').val('');
        $(this).find('input:checkbox').removeAttr('checked');
      });


      $( ".add_ajax_rate" ).click(function() {

       /* $('#loc_tbl_'+Id).html('<img id="load_img" src="{{asset('img/loader.gif')}}"  />');*/
        //alert( "Handler for .click() called." );
        
         var servc_item_id= $('input[name="servc_item_id_new_rate"]').val();


        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.add_rate')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#rate_form_add').serialize() ,
          success: function(response){
            if(response.success){
              
              //$('#loc_errors').html(response.success);
             // $('#loc_msg_div').removeClass('alert-danger').addClass('alert-success').show();
              $( "#close_modal_service_item_new_rate" ).trigger( "click" );
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#rates_panel');

              $.get("{{ URL::route('admin.crm.ajax.list_rate',$customer->id)}}",function( data_response ) {
                                  $('#rates_table').html(data_response);
                                  
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
        $('#rate_msg_div').html(html_error);
        $('#rate_msg_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });

      
    });
  </script>
@endsection