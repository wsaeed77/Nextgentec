
<div class="modal fade" id="modal-edit-note" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Edit Note</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="note_msg_div" style="display:none">
              <ul id="edit_note_errors">
              </ul>
          </div>
          <form id="note_form" class="form-horizontal">
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="subject" class="col-sm-2 control-label">Subject</label>
                          <div class="col-sm-10">
                            {!! Form::hidden('customer_id', session('cust_id')) !!}
                            <input class="form-control" type="text" placeholder="" id="note_subject" name="subject" style="margin-bottom: 4px;">
                            <input type="hidden" name="note_id" value="" id="note_id">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="note_status" class="col-sm-3 control-label">Source</label>
                          <div class="col-sm-9">
                            {!! Form::select('source', array(),'',['class'=>'form-control select2','id'=>'note_source', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-12">
                        <textarea placeholder="Email Body" class="form-control textarea" id="create_note_body" rows="15" name="note" cols="50"></textarea>
                      </div>
                    </div>
                  </form>
      </div>
      <div class="modal-footer">



          <button type="button" class="btn btn-default btn_close" id="close_modal_note"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary update_ajax_note">
            Update
          </button>

      </div>

    </div>
  </div>
</div>

<style>
.datepicker{z-index:1151 !important;}
</style>
