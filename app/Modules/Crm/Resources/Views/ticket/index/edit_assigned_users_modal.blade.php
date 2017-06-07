<div class="modal fade" id="modal-edit-assign-users" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Assign Users</h4>
      </div>
      <div class="modal-body">
        <form id="assign_users_form">
         

            <input type="hidden" name="id" value="">
            <div class="form-group col-lg-6">
                <label>Assign Users</label>
                 {!! Form::select('users[]', $users,'',['class'=>'form-control multiselect','placeholder' => 'Assign Users', 'id'=>'users','multiple'=>''])!!}
                        
                
            </div>
            
            </form>
             <div style="clear:both"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
         
       
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_modal_assign_user">Close</button>
          <button type="submit" class="btn btn-danger add_ajax_assign_user">
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
      $('#modal-edit-assign-users').on('show.bs.modal', function(e) 
      {

        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(Id);

        $.get("/admin/crm/ticket/ajax_ticket/"+Id,function(response ) {
           //console.log(response);
            var data =  $.parseJSON(response);
//console.log(data);

              $.each(data.ticket.assigned_to,function(index,assigned) {  
                  //console.log(assigned.id);
                   
                             $('option[value="'+assigned.id+'"]', $('#users')).prop('selected', true);
                   
                });


                $('#users').multiselect('rebuild');
        });
        //get data-id attribute of the clicked element
        
      });


      

       $( ".add_ajax_assign_user" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.ticket_assign_users')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#assign_users_form').serialize() ,
          success: function(response){
            if(response.success){
            
              $( "#close_modal_assign_user" ).trigger( "click" );
              $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

            var id = $('#assign_users_form').find('input[name="id"]').val();

              $.get("/admin/crm/ticket/ajax_ticket/"+id,function(response ) {

                var data =  $.parseJSON(response);
               var html_status_user ='';
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
          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#service_item_new_errors').html(html_error);
        $('#new_service_item_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });
    });

  </script>
@endsection
