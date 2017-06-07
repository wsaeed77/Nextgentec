<div class="modal fade" id="modal-multi-assign-users" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Assign Users</h4>
      </div>
      <div class="modal-body">
      <div id="multi_ticket_user_msg"></div>
        <form id="multi_assign_users_form">
         

            <input type="hidden" name="ids" value="" id="muti_tickets_id">
            <div class="form-group col-lg-6">
                <label>Assign Users</label>
                 {!! Form::select('users[]', $users,'',['class'=>'form-control multiselect','placeholder' => 'Assign Users', 'id'=>'multi_users','multiple'=>''])!!}
                        
                
            </div>
            
            </form>
             <div style="clear:both"></div>
      </div>
      <div class="modal-footer">
     
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_modal_multi_assign_user">Close</button>
          <button type="submit" class="btn btn-danger add_ajax_multi_assign_user">
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
      $('#modal-multi-assign-users').on('show.bs.modal', function(e) 
      {
          // console.log(ids);
        //var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        //$(e.currentTarget).find('input[name="id"]').val(Id);
          $('option[value=""]', $('#multi_users')).prop('selected', true);
          $('#users').multiselect('rebuild');
    
      });


      

       $( ".add_ajax_multi_assign_user" ).click(function() {
        
        //console.log(ids);

        //return false;
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.multi_ticket_assign_users')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#multi_assign_users_form').serialize() ,
          success: function(response){
            if(response.success){
            
              $( "#close_modal_multi_assign_user" ).trigger( "click" );
              $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

                location.reload();
             
               alert_hide(); 

              
            }
          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '<ul>';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
            html_error += '</ul>';
        
        $('#multi_ticket_user_msg').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });
    });

  </script>
@endsection
