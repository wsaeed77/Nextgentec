<div class="modal fade" id="modal-billingperiod-create" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Billing Period</h4>
      </div>
      <div class="modal-body">
          <div id="err_billing">
          </div>
        <form id="create_billing">
         <div class="form-group col-lg-6">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
          </div>
           <div class="form-group col-lg-6">
              <label>Description</label>
              {!! Form::input('text','description',null, ['placeholder'=>"Description",'class'=>"form-control"]) !!}
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->

          <button type="button" class="btn btn-default"
                  data-dismiss="modal">Close</button>
          <button  class="btn btn-primary new_billing">
             Save
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
{{--<script type="text/javascript">--}}

$('#modal-billingperiod-create').on('show.bs.modal', function(e) {
  $('#err_billing').html('');
  $(this).find(':input').val('');
});

$( ".new_billing" ).click(function() {
  $.ajax({
    url: "{{ URL::route('admin.setting.crm.billingperiods.create')}}",
    type: 'POST',
    dataType: 'json',
    data: $('#create_billing').serialize(),
    success: function(response){
      if(response.success) {
        $('#modal-billingperiod-create').modal('hide');
        setTimeout(location.reload.bind(location), 500);
      }
    }
  });
});


@endsection
