<div class="modal fade" id="modal-edit-asset" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title" >Edit Asset</h4>
      </div>

      <div id="err_msgs_asset_edit"></div>
      <div class="modal-body" id="asset_edit">

      </div>
      <div class="modal-footer">
        <div class="col-lg-12">
          <button type="button" class="btn btn-primary"
                   onclick="update_asset()">Update</button>
          <button type="button" class="btn btn-danger"
                  data-dismiss="modal" id="close_edit_asset">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
{{--<script type="text/javascript">--}}

$('#modal-edit-asset').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('id');
  //populate the textbox
  $.get('/admin/assets/edit/'+Id,function(response ) {

      $('#asset_edit').html(response.html_content_asset);

      if(response.asset_type=='network')
		  change_asset_view('network');

		if(response.asset_type=='gateway')
		  change_asset_view('gateway');



		if(response.asset_type=='pbx')
		  change_asset_view('pbx');


		if(response.asset_type=='server')
		  change_asset_view('server');


		  $('#locations').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });


        $('#asset_type').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });

		 $('#customers_select').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });
        $('#server_type').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });
         $('#edit_virtual_server_type').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });


          },"json"
        );
});


@endsection
