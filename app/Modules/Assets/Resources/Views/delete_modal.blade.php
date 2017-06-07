<div class="modal fade" id="modal-delete-asset" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Please Confirm</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <i class="fa fa-question-circle fa-lg"></i>  
          Are you sure you want to delete this record?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
        {!! Form::open(['method' => 'post','id'=>'asset_del_form']) !!}
         
         <input type="hidden" name="del_asset_id" value="">
          <button type="button" class="btn btn-default" id="close_destroy_asset"
                  data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="delete_asset">
            <i class="fa fa-times-circle"></i> Yes
          </button>
         {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {

      var del_asset_id = '';
      var del_type = '';
      $('#modal-delete-asset').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');

        del_asset_id = Id;
        del_type = $(e.relatedTarget).data('type');
        //populate the textbox
        $(e.currentTarget).find('input[name="del_asset_id"]').val(Id);
      });



       $( "#delete_asset" ).click(function() {
          $.ajax({
          url: "{{ URL::route('admin.assets.delete')}}",
          type: 'POST',
          dataType: 'json',
          data:$('#asset_del_form').serialize() ,
          success: function(response){
                  if(response.success){

                      $( "#close_destroy_asset" ).trigger( "click" );
                    //$( "#"+del_type+"_dt_table").find('tr#'+del_asset_id).remove();
                    $("#"+del_type+"_dt_table").parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

                     var  table = $('#'+del_type+'_dt_table').DataTable( {
                     retrieve: true

                      } );

                      table.draw();
                  }
            }
             });
    });
  });

  </script>
@endsection
