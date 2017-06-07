
<div class="modal fade" id="modal-delete-permission-ajax" tabIndex="-1">
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
       
         <input type="hidden" name="id_permission" value="">
          <button type="button" class="btn btn-default close_ajax_permission"
                  data-dismiss="modal">Close</button>
          <button  class="btn btn-danger " id="delete_ajax_permission">
            <i class="fa fa-times-circle"></i> Yes
          </button>
      
          
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
      $('#modal-delete-permission-ajax').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        
        
        $(e.currentTarget).find('input[name="id_permission"]').val(Id);
        
      });

$("#delete_ajax_permission").click(function() {
          //alert( "Handler for .click() called." );
          var Id = $('input[name="id_permission"]').val();
         
            //console.log(Id);
            var url = "{{URL::route('admin.permissions.del_ajax')}}";

           $.get('/admin/permission_del_ajax/'+Id,function( response ) {

            //$('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#'+success_id);

             $( ".close_ajax_permission" ).trigger( "click" );
             
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_permissions');

                $.get('/admin/permissions',function(response ) {
                $('#tab_permissions').html(response);
                $('#dt_table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{!! route('admin.permissions.list') !!}',
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'display_name', name: 'display_name' },
                            { data: 'name', name: 'name' },
                            { data: 'description', name: 'description' },
                            { data: 'created_at', name: 'created_at' },
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                             
                        ]
                    });
                $('#dt_table_wrapper').addClass('padding-top-10');
                  $('.pagination').addClass('pull-right');

                    },"html" 
                );
                ///$('#loc_contacts_'+loc_id).html(data_response);
              
                                    
                                  },"json" 
                );
                
                 alert_hide(); 
                
              });
@endsection