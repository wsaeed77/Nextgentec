<div class="modal fade" id="modal-show-asset" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title" id="asset_name"></h4>
      </div>
      <div class="modal-body" id="asset_detail">

      </div>
      <div class="modal-footer">


          <button type="button" class="btn btn-default"
                  data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

@section('document.ready')
@parent
$('#modal-show-asset').on('show.bs.modal', function(e)
{
  if($(e.relatedTarget).data('id'))
  {
     $('#modal-show-asset').attr('asset_id',$(e.relatedTarget).data('id'));
  }

setTimeout(function(){
  //get data-id attribute of the clicked element
  //var Id = $(e.relatedTarget).data('id');
  var Id = $('#modal-show-asset').attr('asset_id');
  //populate the textbox
  $.get('/admin/assets/show/'+Id,function(response ) {

      $('#asset_detail').html(response.html_content_asset);
      $('#asset_name').html(response.asset_name);
          },"json"
        );

      },300);
});
@endsection
