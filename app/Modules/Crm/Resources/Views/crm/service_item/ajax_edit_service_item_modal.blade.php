
<div class="modal fade" id="modal-edit-service-item" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Update Service Item</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="service_item_div" style="display:none">
              <ul id="service_item_errors">
              </ul>
          </div>
         <form id="service_item_form">

         </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default" id="close_modal_service_item"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary update_ajax_service_item">
            Update
          </button>
         
      </div>

    </div>
  </div>
</div>
@section('script')
@parent
  <script type="text/javascript">

  function show_rate_form()
  {
    //$('#btn_rate_form_show').click(function() {
               $('#rate_form').show('slow');
            //});
    // });
  }
  function dynamic_data(id)
{
    $('#load_img').show();

      $.ajax({
        url: "{{ URL::route('admin.crm.ajax.load_items')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'html',
        data: 'id='+id,
        success: function(response){
            //alert('fff');
            //console.log(response);
            $('#dynamic_data').html(response);
            $('#load_img').hide();
            $('#rates').show();
           /* $('#msgs').html(response.success);
            $('#msg_div').removeClass('alert-danger').addClass('alert-success').show();*/
            
            //
            $('#subview.multiselect').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                maxHeight: 400,
                dropUp: false,
                buttonClass: 'form-control'
            });
            $('.datepicker').datepicker(); 

            
      }
    });  
}  


function save_temporary_rate()
{
   // alert($('input[name="temp_amount"]').val());

    $('#load_img_rate').show();
    $('#default_rate')
         .append($("<option></option>")
         .attr("value",$('input[name="temp_rate_title"]').val()+'|'+$('input[name="temp_amount"]').val())
         .text($('input[name="temp_rate_title"]').val()+' ($'+$('input[name="temp_amount"]').val()+')')); 
        $('#default_rate').multiselect('rebuild'); 


        $('#additional_rate')
         .append($("<option></option>")
         .attr("value",$('input[name="temp_rate_title"]').val()+'|'+$('input[name="temp_amount"]').val())
         .text($('input[name="temp_rate_title"]').val()+' ($'+$('input[name="temp_amount"]').val()+')')); 
          $('#additional_rate').multiselect('rebuild'); 

        $('#load_img_rate').hide();
        $('#rate_form').hide();
        $('#rate_alert').show('slow', function() {
            
          $('#rate_alert').html('Rate added successfully.');
          $('#rate_form').find('input[type="text"]').val('') 
          alert_hide(); 
        });
 }

    $(document).ready(function() 
    {
      //$('.modal-dialog').css('width', '750px');
      
  
      $('#modal-edit-service-item').on('show.bs.modal', function(e) 
      {
       

         var service_type_id = $(e.relatedTarget).data('servicetid');

          //dynamic_data(service_type_id);

        var Id = $(e.relatedTarget).data('id');
        

        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.load_service_item')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: 'srvc_item_id='+Id,
          success: function(response){
            
            $('#service_item_form').html(response.view_srvc_itm);

            $('.multiselect').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                   buttonWidth: '100%',
                  dropUp: false,
                  buttonClass: 'form-control',
                  onChange: function(option, checked, select) {
                      //alert($('#multiselect').val());
                  }
                });
           
            $('#drp_dwn_srvc_type').multiselect('rebuild');
            $('option[value="'+service_type_id+'"]', $('#drp_dwn_srvc_type')).prop('selected', true);
            $('#drp_dwn_srvc_type').multiselect('refresh');
              

            $(e.currentTarget).find('input[name="service_item_id"]').val(Id); 

             $('.datepicker').datepicker(); 

      
          }
        });  

      
      });
         

         $( ".update_ajax_service_item" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.update_service_item')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#service_item_form').serialize() ,
          success: function(response){
            if(response.success){
              
              //var customer_id = $('input[name="customer_id"]').val();
              //$('#cntct_errors').html(response.success);
             // $('#cntct_msg_div').removeClass('alert-danger').addClass('alert-success').show();

              $( "#close_modal_service_item" ).trigger( "click" );
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#service_items_panel');

              
                 //load service items list
                $.get("{{ URL::route('admin.crm.ajax.list_service_item',$customer->id)}}",function( data_response ) {
                                          $('#service_items_table').html(data_response);
                                        },"html" );

                
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
        $('#service_item_errors').html(html_error);
        $('#service_item_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });
  
        });
    
  </script>
@endsection