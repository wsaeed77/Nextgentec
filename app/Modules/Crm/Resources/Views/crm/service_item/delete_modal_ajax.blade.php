
<div class="modal fade" id="modal-delete-sitem" tabIndex="-1">
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
         
         <input type="hidden" name="del_id_sitem" value="">
        
       
         <input type="hidden" name="cust_id_sitem_del" value="">
          <button type="button" class="btn btn-default del" id="close_modal_new_service_item_del" 
                  data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" id="del_id_sitem">
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
      $('#modal-delete-sitem').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        
          var cust_id_sitem = $(e.relatedTarget).data('custid');
        //populate the textbox
        $(e.currentTarget).find('input[name="del_id_sitem"]').val(Id);
     
        $(e.currentTarget).find('input[name="cust_id_sitem_del"]').val(cust_id_sitem);
      });




      $("#del_id_sitem").click(function() {
          //alert( "Handler for .click() called." );
          var Id = $('input[name="del_id_sitem"]').val();
        

           //var loc_id = $('input[name="del_id_loc"]').val();
          var customer_id = $('input[name="cust_id_sitem_del"]').val();

           $.get('/admin/crm/ajax_del_sitem/'+Id+'/'+customer_id,function( response ) {

           // $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#'+success_id);

             
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#service_items_panel');

              
                $('#service_items_table').html(response.html_contents);
                ///$('#loc_contacts_'+loc_id).html(data_response);
                                    
                                  },"json" 
                );
                //$( "#del_id_sitem_no" ).trigger( "click" );
                $( "#close_modal_new_service_item_del" ).trigger( "click" );
                 alert_hide(); 
                
              });

    });
  </script>
@endsection
