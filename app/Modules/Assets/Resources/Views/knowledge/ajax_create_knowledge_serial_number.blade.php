<div class="modal fade" id="modal-create-knowledge-serial-number" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Serial Number</h4>
      </div>
      <div class="modal-body">
          <div id="err_serial_number">
          </div>
        <form id="create_serial_number">
            <div class="form-group col-lg-12">
                <label>Customer</label>
                <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                 {
                    $selected_cust = session('cust_id');?>

                  {!! Form::select('customer', $customers,$selected_cust,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','disabled'=>'','id'=>'customer'])!!}
                     <?php } else{ ?>

                       {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer'])!!}

                      <?php } ?>



            </div>

            <div class="form-group col-lg-12">
                <label>Title</label>
                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}

            </div>
             <div class="form-group col-lg-12">
                <label>Serial Number</label>
                {!! Form::input('text','serial_number',null, ['placeholder'=>"Serial Number",'class'=>"form-control"]) !!}

            </div>

            <div class="form-group col-lg-12">
  	            <label>Notes</label>
  	            {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'serial_notes','rows'=>10]) !!}
  	        </div>
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_knowledge_serial_number">Close</button>
          <button  class="btn btn-primary new_knowledge_serial_number">
             Save
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent

      $('#modal-create-knowledge-serial-number').on('show.bs.modal', function(e)
      {
          $('#err_procedure').html('');
       });

       $( ".new_knowledge_serial_number" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.knowledge.store.serial_number')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_serial_number').serialize()+'&customer='+$('#customer').val(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_knowledge_serial_number" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#serial_numbers');
                    var  table = $('#knowledge_serial_numbers_dt_table').DataTable( {
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
                $('#err_serial_number').html(html_error);

              }
            });

          });

@endsection
