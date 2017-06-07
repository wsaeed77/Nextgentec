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
                 {!! Form::select('users[]', $users,$assigned_users,['class'=>'form-control multiselect','placeholder' => 'Assign Users', 'id'=>'users','multiple'=>''])!!}
                        
                
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
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(Id);
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
             

              var html_users ='';
              
 //console.log(response.assigned_users); 
                 $.each(response.assigned_users,function(index, value) {  
                       //console.log(value); 
                   html_users +=' <p  class="btn bg-gray-active  btn-sm"><i class="fa fa-user"></i><span>'+value+'</span><a class="btn btn-xs" href="javascript:;" data-target="#modal-delete-assign-user" id="modaal" data-uid="'+index+'" data-tid="'+response.ticket_id+'" data-toggle="modal"><i class="fa fa-times"></i></a>  </p>';
                   
                });
                $('#assigned_users').html(html_users);
                
           
             
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
