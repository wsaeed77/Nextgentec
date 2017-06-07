<div class="modal fade" id="modal-delete-contact" tabIndex="-1">
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
          Are you sure you want to delete this Record?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
        {!! Form::open(['route' => 'admin.vendor.destroy', 'method' => 'post','id'=>'contact_del_form']) !!}
         
         <input type="hidden" name="contact_id" value="">
          <button type="button" class="btn btn-default" id="close_destroy_contact"
                  data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="delete_contact">
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
      var del_cntct_id = '';
      $('#modal-delete-contact').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        del_cntct_id = Id;
        //populate the textbox
        $(e.currentTarget).find('input[name="contact_id"]').val(Id);
      });



       $( "#delete_contact" ).click(function() {
          $.ajax({
          url: "{{ URL::route('admin.vendor.contact.destroy')}}",
          type: 'POST',
          dataType: 'json',
          data:$('#contact_del_form').serialize() ,
          success: function(response){
                  if(response.success){

                    $( "#close_destroy_contact" ).trigger( "click" );
                    $( "#contact_"+del_cntct_id).remove();
                    $('#tbody_contacts').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');


                  }
            }
             });
    });
  });

  </script>
@endsection
