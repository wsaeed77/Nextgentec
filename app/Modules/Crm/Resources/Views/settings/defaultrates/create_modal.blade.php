<div class="modal fade" id="modal-create-rate" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create New Rate</h4>
      </div>
      <div class="modal-body">
          <div id="err_rate">
          </div>
        <form id="create_rate">
         <div class="form-group col-lg-6">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
          </div>




          <div class="form-group col-lg-6">
              <label>Amount</label>
               <div class="input-group">
                    <span class="input-group-addon">$</span>
              {!! Form::input('text','amount',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
              </div>
          </div>

        </form>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_rate">Close</button>
          <button  class="btn btn-primary new_rate">Save</button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
{{--<script type="text/javascript">--}}
$('#modal-create-rate').on('show.bs.modal', function(e) {
  $('#err_rate').html('');
  $(this).find(':input').val('');
});

$( ".new_rate" ).click(function() {
  $.ajax({
    url: "{{ URL::route('admin.setting.crm.defaultrates.create')}}",
    //headers: {'X-CSRF-TOKEN': token},
    type: 'POST',
    dataType: 'json',
    data: $('#create_rate').serialize(),
    success: function(response){
      if(response.success) {
        $('#modal-create-rate').modal('hide');
        setTimeout(location.reload.bind(location), 500);
      }
    }
  });
});


@endsection
