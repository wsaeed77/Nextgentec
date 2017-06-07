
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
          Are you sure you want to delete this Record?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = 'admin.'.$controller.'.destroy';?>
        <?php /* {!! Form::open(array('route' => array($route), 'method' => 'delete')) !!} */?>
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
          {!! Form::open(array('route' => 'admin.crm.destroy', 'method' => 'delete')) !!}
         <input type="hidden" name="customer_del_id" value="">
        
          <button type="button" class="btn btn-default"
                  data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger delete_ajax">
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
      $('#modal-delete-customer').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        
        //populate the textbox
        $(e.currentTarget).find('input[name="customer_del_id"]').val(Id);
       
      });



/*
      $(".delete_ajax").click(function() {
          //alert( "Handler for .click() called." );
          var Id = $('input[name="customer_del_id"]').val();
          
             $.ajax({
                  url: "{{ URL::route('admin.crm.destroy')}}",
                  //headers: {'X-CSRF-TOKEN': token},
                  type: 'POST',
                  dataType: 'json',
                  data: 'id='+Id,
                  success: function(response){
                     

                      
                }
              }); 

             
                
              });
*/
    });
  </script>
@endsection
