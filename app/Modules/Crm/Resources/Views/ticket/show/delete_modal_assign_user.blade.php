<div class="modal fade" id="modal-delete-assign-user" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Please Confirm</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <i class="fa fa-question-circle fa-lg"></i>  
          Are you sure you want to detach the Employee from this ticket?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="u_id" value="">
          <input type="hidden" name="t_id" value="">
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_del_assign_user">Close</button>
          <button  class="btn btn-danger del_assign_usr">
            <i class="fa fa-times-circle"></i> Yes
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
      $('#modal-delete-assign-user').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Uid = $(e.relatedTarget).data('uid');
        var Tid = $(e.relatedTarget).data('tid');
        //populate the textbox
        $(e.currentTarget).find('input[name="u_id"]').val(Uid);
        $(e.currentTarget).find('input[name="t_id"]').val(Tid);
      });

       $( ".del_assign_usr" ).click(function() {

        var Uid = $('input[name="u_id"]').val();
        var Tid = $('input[name="t_id"]').val();
        $.get('/admin/crm/ticket/delete_user_assigned/'+Tid+'/'+Uid,function(response ) {
                
               $( "#close_del_assign_user" ).trigger( "click" );
              $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
             

              var html_users ='';
              
 //console.log(response.assigned_users); 
                 $.each(response.assigned_users,function(index, value) {  
                       //console.log(value); 
                  html_users +=' <p  class="btn bg-gray-active  btn-sm"><i class="fa fa-user"></i><span>'+value+'</span><a class="btn btn-xs" href="javascript:;" data-target="#modal-delete-assign-user" id="modaal" data-uid="'+value+'" data-tid="'+response.ticket_id+'" data-toggle="modal"><i class="fa fa-times"></i></a>  </p>';;
                   
                });
                $('#assigned_users').html(html_users);
                
           
             
               alert_hide(); 
         
                                                                
                },"json" 
              );
          });

    });

  </script>
@endsection
