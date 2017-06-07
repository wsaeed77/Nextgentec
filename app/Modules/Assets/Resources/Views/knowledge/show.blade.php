<div class="modal fade" id="modal-show-knowledge" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title" id="knowledge_name"></h4>
      </div>
      <div class="modal-body" id="knowledge_detail">

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
$('#modal-show-knowledge').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('id');
  var knowledge_type  = $(e.relatedTarget).data('type');
  //populate the textbox
  $.get('/admin/knowledge/type/'+knowledge_type+'/'+Id,function(response ) {

      $('#knowledge_detail').html(response.html_content);
      if(knowledge_type=='serial_number')
      $('#knowledge_name').html('Serial Number detail');

      if(knowledge_type=='procedure')
      $('#knowledge_name').html('Procedure detail');
          },"json"
        );
});
@endsection
