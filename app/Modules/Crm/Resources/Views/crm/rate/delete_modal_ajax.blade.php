
<div class="modal fade" id="modal-delete-rate" tabIndex="-1">
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
         
         <input type="hidden" name="del_id_rate" value="">
        
         <input type="hidden" name="service_item_id_del" value="">
          <button type="button" class="btn btn-default del"
                  data-dismiss="modal" id="close_modal_service_item_del_rate">Close</button>
          <button type="submit" class="btn btn-danger" id="del_rate">
            <i class="fa fa-times-circle"></i> Yes
          </button>
          
            <?php /*{!! Form::close() !!}*/?>
      </div>
    </div>
  </div>
</div>

@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {
      $('#modal-delete-rate').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        
          var service_item_id_del = $(e.relatedTarget).data('sid');
        //populate the textbox
        $(e.currentTarget).find('input[name="del_id_rate"]').val(Id);
        
        $(e.currentTarget).find('input[name="service_item_id_del"]').val(service_item_id_del);
      });




      $("#del_rate").click(function() {
          //alert( "Handler for .click() called." );
          var Id = $('input[name="del_id_rate"]').val();
         
        
          var service_item_id = $('input[name="service_item_id_del"]').val();

           $.get('/admin/crm/ajax_del_rate/'+Id+'/'+service_item_id,function( response ) {

            //$('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#'+success_id);

             $( "#close_modal_service_item_del_rate" ).trigger( "click" );
             
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#rates_panel');

              $('#rates_table').html(response.html_content_rates);
                ///$('#loc_contacts_'+loc_id).html(data_response);
                 alert_hide(); 
                                    
                                  },"json" 
                );
                $( ".del" ).trigger( "click" );
                 alert_hide(); 
                
              });

    });
  </script>
@endsection
