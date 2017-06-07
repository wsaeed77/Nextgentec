<div class="modal fade" id="modal-delete-assign-customer" tabIndex="-1">
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
          Are you sure you want to detach the Customer from this ticket?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         
          <input type="hidden" name="tic_id" value="">
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_del_assign_customer">Close</button>
          <button  class="btn btn-danger del_assign_customer">
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
      $('#modal-delete-assign-customer').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
       
        var Tid = $(e.relatedTarget).data('tid');
        //populate the textbox
        //$(e.currentTarget).find('input[name="u_id"]').val(Uid);
        $(e.currentTarget).find('input[name="tic_id"]').val(Tid);
      });

       $( ".del_assign_customer" ).click(function() {

        //var Uid = $('input[name="u_id"]').val();
        var Tid = $('input[name="tic_id"]').val();
        $.get('/admin/crm/ticket/delete_customer_assigned/'+Tid,function(response ) {
                
               $( "#close_del_assign_customer" ).trigger( "click" );
              $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
             
                 var html_customer_info ='';
              
 
                   html_customer_info ='';
                   
               
                $('#customer_info').html(html_customer_info);
                
           
             
               alert_hide(); 
                
           
             
               alert_hide(); 
         
                                                                
                },"json" 
              );
          });

    });

  </script>
@endsection
