<div class="modal fade" id="modal-create-ticket-status" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Ticket Status</h4>
      </div>
      <div class="modal-body">
          <div id="err_status">
          </div>
        <form id="create_ticket_status">
          <div class="form-group">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"title",'class'=>"form-control"]) !!}
              <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
          </div>

          <div class="form-group">
              <label>Color</label>
              <div class="input-group colorpicker" id="colorpicker_create">
                {!! Form::input('text','color_code',null, ['placeholder'=>"color code",'class'=>"form-control"]) !!}
               <div class="input-group-addon"><i></i></div>
              </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="status_id" value="">

          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_ticket_status">Close</button>
          <button  class="btn btn-primary new_ticket_status">Save</button>

      </div>
    </div>
  </div>
</div>

@section('document.ready')
@parent
{{--<script type="text/javascript">--}}
$('#modal-create-ticket-status').on('shown.bs.modal', function(e)
{
  $("#colorpicker_create").colorpicker({
    format:'hex'
  });
});

$( ".new_ticket_status" ).click(function() {
  $.ajax({
        url: "{{ URL::route('admin.ticket.status.store')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#create_ticket_status').serialize(),
        success: function(response){
          if(response.success) {
            $('#modal-create-ticket-status').modal('hide');
            setTimeout(location.reload.bind(location), 500);
          }
        }
    });

  });


@endsection
