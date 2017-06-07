<div class="modal fade" id="modal-create-asset-role" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create Server Role</h4>
      </div>
      <div class="modal-body">               
          <div id="err_asset_role">
          </div>    
        <form id="create_asset_role">                 
           <div class="form-group">
                <label>Title</label>
                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
              
            </div>
            
           
                            
        </form>
        
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;
        ?>
      
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_asset_create_role">Close</button>
          <button  class="btn btn-primary new_role" id="create_asset_server_role">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
      

      $('#modal-create-asset-role').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
      
       $('#err_asset_role').html('');
        $(this).find(':input').val('');
       
     });
      

       $( "#create_asset_server_role" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.setting.crm.assets.create_server_role')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_asset_role').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_asset_create_role" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#asset_roles');
                     
                   var  table = $('#dt_table_server_roles').DataTable( {
                     retrieve: true

                      } );

                      table.draw();
                    alert_hide(); 
                }
                
                },
                error: function(data){
                    var errors = data.responseJSON;
                    //console.log(errors);
                    var html_error = '<div  class="alert alert-danger"><ul>';
                    $.each(errors, function (key, value) 
                    {
                        html_error +='<li>'+value+'</li>';
                    })
                     html_error += "</ul></div>";
                $('#err_asset_role').html(html_error);
               
              }
            });
      
          });

@endsection
