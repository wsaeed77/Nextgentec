<div class="modal fade" id="modal-edit-permission" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Permission</h4>
      </div>
      <div class="modal-body">
          <div id="err_permission_edit">
          </div>
        <form id="edit_permission">
           <div class="form-group">
                <label>Name</label>
                {!! Form::input('text','name',null, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
                <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                <input type="hidden" name="permission_id_edit" value="">
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
                  data-dismiss="modal" id="close_edit_permission">Close</button>
          <button  class="btn btn-primary update_permission">
             Update
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent


      $('#modal-edit-permission').on('show.bs.modal', function(e)
      {



       $('#err_permission_edit').html('');

        var id = $(e.relatedTarget).data('id');

        $(e.currentTarget).find('input[name="permission_id_edit"]').val(id);

        $.get("/admin/permissions/"+id+"/edit",function(response ) {


                $(e.currentTarget).find('input[name="name"]').val(response.permission.name);
                $(e.currentTarget).find('input[name="display_name"]').val(response.permission.display_name);
                $(e.currentTarget).find('input[name="description"]').val(response.permission.description);

                

                },"json"
              );
          });



       $( ".update_permission" ).click(function() {

       var id = $('input[name="permission_id_edit"]').val();
         $.ajax({
                url: "{{URL :: route('admin.permissions.update')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'PUT',
                dataType: 'json',
                data: $('#edit_permission').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_edit_permission" ).trigger( "click" );
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
                $('#err_permission_edit').html(html_error);


              }
            });

          });

@endsection
