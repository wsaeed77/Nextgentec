<div class="modal fade" id="modal-edit-ticket-status" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Ticket Status</h4>
      </div>
      <div class="modal-body">
          <div id="err_status_update">
          </div>
        <form id="edit_ticket_status">
          <div class="form-group">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"title",'class'=>"form-control"]) !!}
              <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
              <input type="hidden" name="status_id" value="">
          </div>

          <div class="form-group">
              <label>Color</label>
              <div class="input-group " id="colorpicker">
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
                  data-dismiss="modal" id="close_edit_ticket_status">Close</button>
          <button  class="btn btn-primary update_ticket_status">
             Update
          </button>

      </div>
    </div>
  </div>
</div>

@section('document.ready')
@parent
{{--<script type="text/javascript">--}}
$('#modal-edit-ticket-status').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var id = $(e.relatedTarget).data('id');

  $(e.currentTarget).find('input[name="status_id"]').val(id);
  $.get('/admin/crm/ticketstatus/edit/'+id,function(response ) {
    $(e.currentTarget).find('input[name="status_id"]').val(id);
    $(e.currentTarget).find('input[name="title"]').val(response.status.title);
    $(e.currentTarget).find('input[name="color_code"]').val(response.status.color_code);

    $("#colorpicker").colorpicker({
          color:response.status.color_code,
          format:'hex',
      });

     // $(".colorpicker").colorpicker('update');
    },"json");
});

$( ".update_ticket_status" ).click(function() {
  $.ajax({
    url: "{{ URL::route('admin.ticket.status.update')}}",
    type: 'POST',
    dataType: 'json',
    data: $('#edit_ticket_status').serialize(),
    success: function(response){
      if(response.success) {
        $('#modal-edit-ticket-status').modal('hide');
        setTimeout(location.reload.bind(location), 500);
      }
    }
  });
});

@endsection
