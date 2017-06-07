<div class="modal fade" id="modal-create-knowledge-password" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Password</h4>
      </div>
      <div class="modal-body">
          <div id="err_passwords">
          </div>
        <form id="create_password">
            <div class="form-group col-lg-12">
                <label>Customer</label>
                 <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                 {
                    $selected_cust = session('cust_id');?>
                    {!! Form::select('customer', $customers, $selected_cust ,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','disabled'=>'','id'=>'customer'])!!}
            <?php } else
                    { ?>
                    {!! Form::select('customer', $customers, '',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer'])!!}
             <?php } ?>
               

            </div>
            
            <div class="form-group col-lg-10">
                <label>Tags</label>
                {{-- {!! Form::input('text','system',null, ['placeholder'=>"System",'class'=>"form-control"]) !!} --}}
                {!! Form::select('tags[]', $tags,'',['class'=>'select2','multiple'=>'','style'=>"width: 100%;",'id'=>'tags'])!!}
                
            </div>
            <div class="col-lg-2">
            <label>&nbsp;&nbsp;</label>
               <button type="button" class="btn btn-primary btn-sm " data-toggle="modal" id="modaal" data-target="#modal-create-password-tag">Add Tag</button>

            </div>
            
            <div class="form-group col-lg-12">
                <label>Login</label>
                 {!! Form::input('text','login',null, ['placeholder'=>"Login",'class'=>"form-control"])!!}
            </div>

            <div class="form-group col-lg-12">
                <label>Password</label>
                 {!! Form::input('text','password',null, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
            </div>

            <div class="form-group col-lg-12">
  	            <label>Notes</label>
  	            {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'password_notes','rows'=>10]) !!}
  	        </div>

        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_knowledge_pass">Close</button>
          <button  class="btn btn-primary new_knowledge_pass">
             Save
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent

      $('#modal-create-knowledge-password').on('show.bs.modal', function(e)
      {
          $('#err_permission').html('');
          var tags = $("#tags").select2({});
          tags.val(null).trigger("change");
          $(this).find('input,textarea').val('');
       });

       $( ".new_knowledge_pass" ).click(function() {
        {{--  for ( instance in CKEDITOR.instances )
                 CKEDITOR.instances[instance].updateElement(); --}}
         $.ajax({
                url: "{{ URL::route('admin.knowledge.store.password')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_password').serialize()+'&customer='+$('#customer').val(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_knowledge_pass" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#passwords');
                    var  table = $('#knowledge_pass_dt_table').DataTable( {
                            retrieve: true

                        } );

                        table.draw();


                   $('#knowledge_pass_dt_table_wrapper').addClass('padding-top-40');
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
                $('#err_passwords').html(html_error);

              }
            });

          });

@endsection
