<div class="modal fade" id="modal-multi-priority" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Change Status/Priority</h4>
      </div>
      <div class="modal-body">
        <form id="multi_priority_form">
         

            <input type="hidden" name="multi_priority_ids" value="" id="multi_priority_ids">
          
             <div class="col-lg-12"> 
                  <div class="form-group col-lg-2">
                          <label>Priority</label>
                    </div>
                      <div class="form-group col-lg-2">
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="low" id="low" name="priority">
                              <button type="button" class="btn bg-gray  btn-xs">
                                 
                                    <span>Low</span>
                                    </button>
                            </label>
                          </div>
                      </div>

                      <div class="form-group col-lg-2">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="normal" id="normal" name="priority">
                              <button type="button" class="btn bg-blue  btn-xs">
                                 
                                    <span>Normal</span>
                                    </button>
                            </label>
                          </div>
                      </div>

                      <div class="form-group col-lg-2">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="high" id="high" name="priority">
                              <button type="button" class="btn bg-green  btn-xs">
                                 
                                    <span>High</span>
                                    </button>
                            </label>
                          </div>
                      </div>


                      <div class="form-group col-lg-2">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="urgent" id="urgent" name="priority">
                              <button type="button" class="btn bg-yellow  btn-xs">
                                 
                                    <span>Urgent</span>
                                    </button>
                            </label>
                          </div>
                      </div>


                      <div class="form-group col-lg-2">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="critical" id="critical" name="priority">
                              <button type="button" class="btn bg-red  btn-xs">
                                 
                                    <span>Critical</span>
                                    </button>
                            </label>
                          </div>
                      </div>
                          
                          
                     
                    </div>
            
            </form>
             <div style="clear:both"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
         
       
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_multi_modal_priority">Close</button>
          <button type="submit" class="btn btn-danger add_multi_ajax_priority">
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
      $('#modal-multi-priority').on('show.bs.modal', function(e) 
      {
        
                $(this).find('#low').prop('checked', true);
       
      });


       

       $( ".add_multi_ajax_priority" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.multi_ticket_priority')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#multi_priority_form').serialize() ,
          success: function(response){
            if(response.success){
            
              $( "#close_multi_modal_priority_status" ).trigger( "click" );
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
