<div class="modal fade" id="modal-show-network" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title" id="network_name"></h4>
      </div>
      <div class="modal-body" id="network_detail">

      </div>
      <div class="modal-footer">


          <button type="button" class="btn btn-default"
                  data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

@section('styles')
@parent
<style>
.modal-header {
  border: none;
}
</style>
@endsection

@section('document.ready')
@parent

{{--<script type="text/javascript">--}}

$('#modal-show-network').on('show.bs.modal', function(e)
{

setTimeout(function(){

    var Id = $('#modal-show-network').attr('net_id');
  //get data-id attribute of the clicked element
  //var Id = $(e.relatedTarget).data('id');
  //var knowledge_type  = $(e.relatedTarget).data('type');
  //populate the textbox
  $.get('/admin/knowledge/network/'+Id,function(response ) {
      $('#network_detail').html(response.html_content);
      $('#network_name').html(response.network_name);
  },"json");

  },300);


});
@endsection
