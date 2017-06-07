<div class="modal fade" id="modal-edit-role" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Edit Role</h4>
      </div>
      <div class="modal-body">               
          <div id="err_role_edit">
          </div>    
        <form id="edit_role">                 
           <div class="form-group">
                <label>Name</label>
                {!! Form::input('text','name',null, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
                <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                <input type="hidden" name="role_id" value="">
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
                
                    <select multiple class="form-control" id="multiselect_role_update" name="permissions[]">
                        
                    </select>
                         
            
            </div>
                            
        </form>
        
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="status_id" value="">
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_edit_role">Close</button>
          <button  class="btn btn-primary update_role">
             Update
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
      

      $('#modal-edit-role').on('show.bs.modal', function(e) 
      {

      //empty the list on new load
      $('#multiselect_role_update').html('');

       $('#multiselect_role_update').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        }); 
        //get data-id attribute of the clicked element
      
       $('#err_role').html('');
       
        var id = $(e.relatedTarget).data('id');
      
        $(e.currentTarget).find('input[name="role_id"]').val(id);

        $.get("/admin/role/"+id+"/edit",function(response ) {
                

                $(e.currentTarget).find('input[name="name"]').val(response.role.name);
                $(e.currentTarget).find('input[name="display_name"]').val(response.role.display_name);
                $(e.currentTarget).find('input[name="description"]').val(response.role.description); 

                //first populate the list with permissions
                $.each(response.permissions,function(index,permission) {  
                  //console.log(permission);
                    $('#multiselect_role_update').append($("<option></option>")
                             .attr("value",permission.id)
                             .text( permission.display_name)); 
                   
                });

                // select the values already selected
                $.each(response.selected_perms,function(index,perm) {  
                  //console.log(permission);
                   
                             $('option[value="'+perm+'"]', $('#multiselect_role_update')).prop('selected', true);
                   
                });


                $('#multiselect_role_update').multiselect('rebuild');

                                                                
                },"json" 
              );
          });
       
      

       $( ".update_role" ).click(function() {

       var id = $('input[name="role_id"]').val();
         $.ajax({
                url: "{{URL :: route('admin.role.update')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data: $('#edit_role').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_edit_role" ).trigger( "click" );
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
                $('#err_role_edit').html(html_error);
                
                
              }
            });
      
          });

@endsection
