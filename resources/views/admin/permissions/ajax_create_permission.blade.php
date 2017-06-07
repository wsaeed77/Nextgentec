<div class="modal fade" id="modal-create-permission" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create Permission</h4>
      </div>
      <div class="modal-body">               
          <div id="err_permission">
          </div>    
        <form id="create_permission">                 
            <div class="form-group">
                <label>Name</label>
                {!! Form::input('text','name',null, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
                <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                
            </div>
              
            <div class="form-group">
                <label>Display Name</label>
                {!! Form::input('text','display_name',null, ['placeholder'=>"Display Name",'class'=>"form-control"]) !!}
                <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
            </div>
            <div class="form-group">
                <label>Description</label>
                 {!! Form::input('text','description',null, ['placeholder'=>"Discription",'class'=>"form-control"]) !!}
                <!-- <input placeholder="Password" name="password" type="password" class="form-control"> -->
            </div>
                            
        </form>
        
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_permission">Close</button>
          <button  class="btn btn-primary new_permission">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
      
      $('#modal-create-permission').on('show.bs.modal', function(e) 
      {
          $('#err_permission').html('');
           $(this).find(':input').val('');
       });
       $( ".new_permission" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.permissions.store')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_permission').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_permission" ).trigger( "click" );
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
                            },"html" 
                        );
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
                $('#err_permission').html(html_error);
               
              }
            });
      
          });

@endsection
