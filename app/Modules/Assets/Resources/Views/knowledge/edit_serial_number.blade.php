<div class="modal fade" id="modal-edit-serial-number" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Serial Number</h4>
      </div>
      <div class="modal-body">
          <div id="err_edit_serial_number">
          </div>
        <form id="update_serial_number">
            <div class="form-group col-lg-12">
                <label>Customer</label>

                 <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                               {
                                  $selected_cust = session('cust_id');?>
                      {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'edit_serial_number_customer','disabled'=>''])!!}

                   <?php } else{ ?>
                    {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'edit_serial_number_customer'])!!}

                   <?php }?>

                <input type="hidden" name="id" value="" >

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
  	            {!! Form::textarea('notes',null, ['placeholder'=>"",'class'=>"form-control textarea",'id'=>'edit_serial_number','rows'=>10]) !!}
  	        </div>
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_edit_knowledge_serial_number">Close</button>
          <button  class="btn btn-primary update_knowledge_serial_number">
             Update
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-edit-serial-number').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('id');
  //populate the textbox
  $.get('/admin/knowledge/edit/serial_number/'+Id,function(response ) {

  if(response.serial_number.customer)
		$('option[value="'+response.serial_number.customer.id+'"]', $('#edit_serial_number_customer')).prop('selected', true);

        $('#edit_serial_number_customer').multiselect('refresh');

        $(e.currentTarget).find('input[name="title"]').val(response.serial_number.title);
         $(e.currentTarget).find('input[name="serial_number"]').val(response.serial_number.serial_number);

        $(e.currentTarget).find('textarea[name="notes"]').val(response.serial_number.notes);
        $(e.currentTarget).find('input[name="id"]').val(Id);



         },"json"
        );
});

$( ".update_knowledge_serial_number" ).click(function() {

  $.ajax({
         url: "{{ URL::route('admin.knowledge.update.serial_number')}}",
         //headers: {'X-CSRF-TOKEN': token},
         type: 'POST',
         dataType: 'json',
         data: $('#update_serial_number').serialize(),
         success: function(response){
         if(response.success)
         {
               $( "#close_edit_knowledge_serial_number" ).trigger( "click" );
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
         $('#err_edit_serial_number').html(html_error);

       }
     });

   });
@endsection
