<div class="modal fade" id="modal-delete-asset-server-role" tabIndex="-1">
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
          Are you sure you want to delete this Record?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
        
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_delete_server_role">Close</button>
          <button type="submit" class="btn btn-danger" id="del_server_role">
            <i class="fa fa-times-circle"></i> Yes
          </button>
      
      </div>
    </div>
  </div>
</div>
@section('document.ready')
@parent
var role_server_id = '';
      $('#modal-delete-asset-server-role').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
       role_server_id = $(e.relatedTarget).data('id');
        //populate the textbox
        
      });

       $( "#del_server_role" ).click(function() {
              
           $.get('/admin/assets/delete_server_role/'+role_server_id,function(response ) {
           if(response.success){
               $( "#close_delete_server_role" ).trigger( "click" );
               //console.log(response.success);
                $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#asset_roles');
                     
                     var  table = $('#dt_table_server_roles').DataTable( {
                     retrieve: true

                      } );

                      table.draw();
                    alert_hide(); 
              }
           },'json');
         });

@endsection
