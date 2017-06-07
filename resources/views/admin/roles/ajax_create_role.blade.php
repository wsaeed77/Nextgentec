<div class="modal fade" id="modal-create-role" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create Role</h4>
      </div>
      <div class="modal-body">               
          <div id="err_role">
          </div>    
        <form id="create_role">                 
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

            <div class="form-group">
                <label>Select Permissions</label>
                
                    <select multiple class="form-control" id="multiselect_role" name="permissions[]">
                        
                    </select>
                         
            
            </div>
                            
        </form>
        
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="status_id" value="">
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_role">Close</button>
          <button  class="btn btn-primary new_role">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
       $('#multiselect_role').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        }); 


      $('#modal-create-role').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
      
       $('#err_role').html('');
        $(this).find(':input').val('');
       
        $.get("{{ URL::route('admin.role.create')}}",function(response ) {
                
                //$(e.currentTarget).find('input[name="status_id"]').val(id);
                //$(e.currentTarget).find('input[name="title"]').val(response.status.title);
                //$(e.currentTarget).find('input[name="color_code"]').val(response.status.color_code); 

                $.each(response.permissions,function(index,permission) {  
                  //console.log(permission);
                    $('#multiselect_role').append($("<option></option>")
                             .attr("value",permission.id)
                             .text( permission.display_name)); 
                   
                });

                $('#multiselect_role').multiselect('rebuild');

                /*$("#colorpicker").colorpicker({
                      color:response.status.color_code,
                      format:'hex',
                  });  */
                
                 // $(".colorpicker").colorpicker('update');                                                          
                },"json" 
              );
          });
       
      

       $( ".new_role" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.role.store')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_role').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_role" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_role');
                     
                    $.get('/admin/role',function(response ) {
                      $('#tab_role').html(response);
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
                $('#err_role').html(html_error);
                //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();
                
                // Render the errors with js ...
              }
            });
      
          });

@endsection
