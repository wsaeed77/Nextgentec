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
              
                 {!! Form::select('status',$statuses,'',['class'=>'form-control multiselect','placeholder' => 'Change Status', 'id'=>'status'])!!}
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

         $.get("/admin/crm/ticket/ajax_ticket/"+Id,function(response ) {
           //console.log(response);
            var data =  $.parseJSON(response);

             
               
                $('option[value="'+data.ticket.ticket_status_id+'"]', $('#status')).prop('selected', true);
                   
           


                $('#status').multiselect('rebuild');

                $('#'+data.ticket.priority).prop('checked', true);
        });
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
             
 var id = $('#priority_status_form').find('input[name="id"]').val();

              $.get("/admin/crm/ticket/ajax_ticket/"+id,function(response ) {

                var data =  $.parseJSON(response);
               var html_status_user ='';
               console.log(data.ticket.assigned_to.length);
               if(data.ticket.assigned_to.length > 0)
               {
                 $.each(data.ticket.assigned_to,function(index,assigned) {  
                    html_status_user +='<div class="ticketInformationItem"><div title="Technician" class="l ticketInformationKeyShort text-center"><span class="fa fa-user"></span></div><a  href="javascript:;" data-target="#modal-edit-assign-users" id="modaal"  data-id="'+data.ticket.id+'" data-toggle="modal"   class="p l ticketInformationVal ellipsis span-black btn-link">'+assigned.f_name+' '+assigned.l_name+'</a></div>';
                     
                  });
               }
               else
               {

                 html_status_user +='<div class="ticketInformationItem"><div title="Technician" class="l ticketInformationKeyShort text-center"><span class="fa fa-user"></span></div><a  href="javascript:;" data-target="#modal-edit-assign-users" id="modaal"  data-id="'+data.ticket.id+'" data-toggle="modal"   class="p l ticketInformationVal ellipsis span-black btn-link">Unassigned</a></div>';
               }
               

              html_status_user +=' <div class="ticketInformationItem"><div title="Status" class="l ticketInformationKeyShort text-center"><span class="fa fa-info"></span></div><a href="javascript:;" data-target="#modal-edit-priority-status" id="modaal"  data-id="'+data.ticket.id+'" data-toggle="modal" class="p l ticketInformationVal ellipsis span-black btn-link">'+data.ticket.status.title+'</a></div>';

              html_status_user +='<div class="ticketInformationItem"><div title="Priority" class="l ticketInformationKeyShort text-center"><span class="fa fa-thumb-tack"></span></div><div href="javascript:;" data-target="#modal-edit-priority-status" id="modaal"  data-id="'+data.ticket.id+'" data-toggle="modal" class="p l ticketInformationVal ellipsis span-black btn-link">'+data.ticket.priority+'</div></div>';


             $("#status_user_"+id).html('<div class="ticketInformation f14">'+html_status_user+'</div>')

             
           });
             
             
               alert_hide(); 
              
            }
          }
         
        });  
      });
    });

  </script>
@endsection
