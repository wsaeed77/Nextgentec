<div class="modal fade" id="modal-multi-status" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Change Status</h4>
      </div>
      <div class="modal-body">
        <form id="multi_status_form">
         

            <input type="hidden" name="multi_status_ids" value="" id="multi_status_ids">
            <div class="form-group col-lg-6">
                <label>Change Status</label>
              
                 {!! Form::select('status',$statuses,'',['class'=>'form-control multiselect','placeholder' => 'Change Status', 'id'=>'multi_status'])!!}
            </div>
             
            
            </form>
             <div style="clear:both"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
         
       
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_multi_modal_status">Close</button>
          <button type="submit" class="btn btn-danger add_multi_ajax_status">
            <i class="fa fa-times-circle"></i> Update
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
      $('#modal-multi-status').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
       
                $('option[value=""]', $('#multi_status')).prop('selected', true);
                   
                $('#multi_status').multiselect('rebuild');

                //$('#low').prop('checked', true);
       
      });


       

       $( ".add_multi_ajax_status" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.multi_ticket_status')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#multi_status_form').serialize() ,
          success: function(response){
            if(response.success){
            
              $( "#close_multi_modal_status" ).trigger( "click" );
              $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
             
                location.reload();
             
               alert_hide(); 
              
            }
          }
         
        });  
      });

    });

  </script>
@endsection
