<div class="modal fade" id="modal-servicetype-create" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create service type</h4>
      </div>
      <div class="modal-body">
        <form id="create_service_type">
          <div class="col-lg-12">

              <div class="form-group col-lg-6">
                  <label>Title</label>
                  {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
              </div>


               <div class="form-group col-lg-6">
                  <label>Description</label>
                  {!! Form::input('text','description',null, ['placeholder'=>"Description",'class'=>"form-control"]) !!}
              </div>
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <input type="hidden" name="status_id" value="">

          <button type="button" class="btn btn-default"
                  data-dismiss="modal" >Close</button>
          <button  class="btn btn-primary new_service_type">
             Save
          </button>

      </div>
    </div>
  </div>
</div>
@section('document.ready')
@parent
{{--<script type="text/javascript">--}}
$('#modal-servicetype-create').on('show.bs.modal', function(e) {
  $('#err_status').html('');
  $(this).find(':input').val('');
});

$( ".new_service_type" ).click(function() {
  $.ajax({
    url: "{{ URL::route('admin.service_item.store')}}",
    type: 'POST',
    dataType: 'json',
    data: $('#create_service_type').serialize(),
    success: function(response){
      if(response.success) {
        $('#modal-servicetype-create').modal('hide');
        setTimeout(location.reload.bind(location), 500);
      }
    }
  });
});

@endsection
