<div class="modal fade" id="modal-edit-priority-status" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Change Status/Priority</h4>
      </div>
      <div class="modal-body">
        <form id="priority_status_form">
         

            <input type="hidden" name="id" value="">
            <div class="form-group col-lg-6">
                <label>Change Status</label>
              
                 {!! Form::select('status',$statuses,$ticket->ticket_status_id,['class'=>'form-control multiselect','placeholder' => 'Change Status'])!!}
            </div>
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
                  data-dismiss="modal" id="close_modal_priority_status">Close</button>
          <button type="submit" class="btn btn-danger add_ajax_priority_status">
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
      $('#modal-edit-priority-status').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(Id);
      });


       

       $( ".add_ajax_priority_status" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.ticket_priority_status')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#priority_status_form').serialize() ,
          success: function(response){
            if(response.success){
            
              $( "#close_modal_priority_status" ).trigger( "click" );
              $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
             

              var html_users ='';
              
 //console.log(response.assigned_users); 
                 
                $('#priority').html(response.ticket.priority);


                 $('#status').html(response.ticket.status.title);
                
           
             
               alert_hide(); 
              
            }
          }
         
        });  
      });
    });

  </script>
@endsection
