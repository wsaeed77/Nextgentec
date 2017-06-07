
<div class="modal fade" id="modal-add-excel-note" tabIndex="-1">
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
              <ul id="add_excel_note_errors">
              </ul>
          </div>
           {{-- <button id="add_col">Add Col</button>  <button id="save_data">Save</button> --}}
          <form id="excel_note_form" class="form-horizontal">
                   
                {!! Form::hidden('customer_id', Session::get('cust_id')) !!}
                   
                  </form>

                   <div class="row" style="padding-top: 10px;">
                      <div class="col-md-12">
                       <div id="htable"></div>
                      </div>
                    </div>
      </div>
      <div class="modal-footer">



          <button type="button" class="btn btn-default btn_close" id="close_modal_excel_note"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_excel_note">
            Add
          </button>

      </div>

    </div>
  </div>
</div>
 

    <style>

.handsontable{
    width: 500px;
    height: 210px;
    overflow: hidden;
}


.datepicker{z-index:1151 !important;}
</style>
@section('script')
@parent
<script>
var data = [
  [,,],
  [],
  
];

/*var columns =  [{
    data: 'a'
      // 1nd column is simple text, no special options here
  }, {
    data: 'b',
    //type: 'numeric'
 
  }];*/

var
    container = document.getElementById('htable'),
    hot;
    var colHeaders = ['A', 'B'];

    $(function() {

    $('#modal-add-excel-note').on('show.bs.modal', function(e) 
      {
        setTimeout(function() {
        hot = new Handsontable(container, {
            rowHeaders: true,
            colHeaders: colHeaders,
            dropdownMenu: true,
            allowInsertRow:true,
            allowInsertColumn:true,
            contextMenu:["row_above", "row_below", "col_left", "col_right", "remove_row", "remove_col", '--------', "undo", "redo"]
          });
         }, 300);
      });

     /*$('#add_col').on('click',function(){
             // if (hot.propToCol(changes[0][1]) === hot.countCols() - 1) {
              var person = prompt("Please enter title", "abc");
                //cols.push({});
                colHeaders.push(person);
                columns.push({});
                 hot.updateSettings({
                  //data: getCarData(),
                  //colHeaders: colHeaders,
                  columnSorting: true,
                  columns: columns
                });
   // }
         });
*/

$('#modal-add-excel-note').on('hidden.bs.modal', function(e) 
      {

        hot.destroy();
      }); 
    $(".add_ajax_excel_note").click(function() {

             $.ajax({
                        url: "{{ URL::route('admin.crm.ajax.note.save_excel')}}",
                        //headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        //data: 'htdata='+JSON.stringify(hot.getSourceData())+'headers'+colHeaders,
                        data: $('#excel_note_form').serialize()+'&htdata='+JSON.stringify(hot.getSourceData()),
                        success: function(response){
                           if(response.success=='yes'){

                              $('#active_table').footable({
                              "columns": cols,
                              "rows": $.get('{{URL::route("admin.crm.notes.json","active")}}',function(){},'json')
                            });
                         $('#archived_table').footable({
                              "columns": cols,
                              "rows": $.get('{{URL::route("admin.crm.notes.json","archived")}}',function(){},'json')
                            });

                          $('#excel_active_table').footable({
                          "columns": excel_cols,
                          "rows": $.get('{{URL::route("admin.crm.excel.notes.json","active")}}',function(){},'json')
                        });

                          $('#excel_archive_table').footable({
              "columns": excel_cols,
              "rows": $.get('{{URL::route("admin.crm.excel.notes.json","archived")}}',function(){},'json')
            });
                            $(".add_ajax_excel_note").html('Success');
                            $(".add_ajax_excel_note").toggleClass('btn-success btn-primary');
                            setTimeout(
                              function()
                              {
                                $( "#close_modal_excel_note" ).trigger( "click" );
                              }, 500);
                          }
                                         // console.log(response);
                         
                        }

                      });


        });
      });
</script>
  @endsection

 