<div class="modal fade" id="modal-vendor-detatil" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Vendor Details</h4>
      </div>
      <div class="modal-body">
          
        <div  id="vendor_detail">
           
           
        </div>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_vendor_detail">Close</button>
          
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-vendor-detatil').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('vendor-id');
  //populate the textbox

  $.get("/admin/vendors/ajax_detail/"+Id,function(data) {
            $('#vendor_detail').html(data);
          },"html");
 
});


@endsection
