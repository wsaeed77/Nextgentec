<div class="modal fade" id="modal-delete-vendor" tabIndex="-1">
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
          Are you sure you want to delete this Vendor?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
        {!! Form::open(['route' => 'admin.vendor.destroy', 'method' => 'post','id'=>'vendor_del_form']) !!}
         
         <input type="hidden" name="vendor_id" value="">
          <button type="button" class="btn btn-default" id="close_destroy_vendor"
                  data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" id="delete_vendor">
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
      $('#modal-delete-vendor').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="vendor_id"]').val(Id);
      });



       $( "#delete_vendor" ).click(function() {
          $.ajax({
          url: "{{ URL::route('admin.vendor.destroy')}}",
          type: 'POST',
          dataType: 'json',
          data:$('#vendor_del_form').serialize() ,
          success: function(response){
                  if(response.success){
                  }
            }
             });
    });
  });

  </script>
@endsection
