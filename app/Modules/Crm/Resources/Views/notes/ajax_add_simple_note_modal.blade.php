
<div class="modal fade" id="modal-add-simple-note" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Add Note</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="note_msg_div" style="display:none">
              <ul id="add_simple_note_errors">
              </ul>
          </div>
          <form id="simple_note_form" class="form-horizontal">
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="subject" class="col-sm-2 control-label">Subject</label>
                          <div class="col-sm-10">
                            {!! Form::hidden('customer_id', Session::get('cust_id')) !!}
                            <input class="form-control" type="text" placeholder="" id="note_subject" name="subject" style="margin-bottom: 4px;">
                           
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
                        <textarea placeholder="Email Body" class="form-control textarea" id="create_simple_note_body" rows="15" name="note" cols="50"></textarea>
                      </div>
                    </div>
                  </form>
      </div>
      <div class="modal-footer">



          <button type="button" class="btn btn-default btn_close" id="close_modal_simple_note"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_simple_note">
            Add
          </button>

      </div>

    </div>
  </div>
</div>

<style>
.datepicker{z-index:1151 !important;}
</style>

