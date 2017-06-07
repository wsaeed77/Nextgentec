
<div class="modal fade" id="modal-reset" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Auth Token</h4>
      </div>
      <div class="modal-body" id="bdy">
      
      </div>
      <div class="modal-footer">
     
       Please copy the Token and paste it in Auth token field.
        
       
        
          <button type="button" class="btn btn-default del" id="close_modal_new_service_item_del" 
                  data-dismiss="modal">Close</button>
         
          
        
      </div>
    </div>
  </div>
</div>

@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {
      $('#modal-reset').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        //var Id = $(e.relatedTarget).data('id');
 
        $.get("{{URL::route('admin.crm.zoho_reset_token')}}",function( response ) {
//console.log(response);
          $('#bdy').html(response.msg);

        },"json");
      });
    });
  </script>
@endsection
