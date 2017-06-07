<div class="modal fade" id="modal-create-asset-v-type" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create Asset virtual server type</h4>
      </div>
      <div class="modal-body">               
          <div id="err_asset_v_type">
          </div>    
        <form id="create_asset_v_type">                 
           <div class="form-group">
                <label>Title</label>
                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
              
            </div>
            
           
                            
        </form>
        
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_asset_create_v_type">Close</button>
          <button  class="btn btn-primary new_role" id="create_asset_server_v_type">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
      

      $('#modal-create-asset-v-type').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
      
       $('#err_asset_v_type').html('');
        $(this).find(':input').val('');
       
     });
      

       $( "#create_asset_server_v_type" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.assets.create_server_virtual_type')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_asset_v_type').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_asset_create_v_type" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#asset_v_types');
                     
                   var  table = $('#dt_table_v_types').DataTable( {
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
                $('#err_asset_v_type').html(html_error);
               
              }
            });
      
          });

@endsection
