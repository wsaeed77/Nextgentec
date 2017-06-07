<div class="modal fade" id="modal-create-password-tag" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Password Tag</h4>
      </div>
      <div class="modal-body">
          <div id="err_password_tag">
          </div>
        <form id="create_password_tag">
          


            <div class="form-group col-lg-12">
                <label>Tag</label>
                 {!! Form::input('text','tag',null, ['placeholder'=>"Tag",'class'=>"form-control"]) !!}
            </div>

           

        </form>
      <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_pass_tag">Close</button>
          <button  class="btn btn-primary" id="create_pass_tag">
             Save
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent

      $('#modal-create-password-tag').on('show.bs.modal', function(e)
      {
          $('#err_password_tag').html('');
          
       });

       $( "#create_pass_tag" ).click(function() {
          $.ajax({
                  url: "{{ URL::route('admin.knowledge.store.password.tag')}}",
                  //headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data: $('#create_password_tag').serialize(),
                  success: function(response){
                  if(response.success)
                  {
                    $( "#close_create_pass_tag" ).trigger( "click" );
                    $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#err_password_tag');

                    $.get("{{ URL::route('admin.knowledge.get.tags')}}", function(data) {
                   //var ff = JSON.stringify(data);
                     $("#tags").select2({
                      data: data
                      });
                      
                      $("#tags_edit").select2({
                      data: data
                      });
                    },'json');

                   

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
                  $('#err_password_tag').html(html_error);

                }
          });

          });

@endsection
