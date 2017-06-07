<div class="modal fade" id="modal-delete-customer" tabIndex="-1">
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
        {!! Form::open(['method' => 'post','id'=>'customer_del_form']) !!}

         <input type="hidden" name="customer_id" value="">
          <button type="button" class="btn btn-default" id="close_destroy_customer"
                  data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="delete_customer">
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

      var del_cust_id = '';
      $('#modal-delete-customer').on('show.bs.modal', function(e)
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');

        del_cust_id = Id;
        //populate the textbox
        $(e.currentTarget).find('input[name="customer_id"]').val(Id);
      });



       $( "#delete_customer" ).click(function() {
          $.ajax({
          url: "{{ URL::route('admin.vendor.customer.destroy')}}",
          type: 'POST',
          dataType: 'json',
          data:$('#customer_del_form').serialize() ,
          success: function(response){
                  if(response.success){

                      $( "#close_destroy_customer" ).trigger( "click" );
                    $( "#customer_"+del_cust_id).remove();
                    $('#tbody_customers').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
                  }
            }
             });
    });
  });

  </script>
@endsection
