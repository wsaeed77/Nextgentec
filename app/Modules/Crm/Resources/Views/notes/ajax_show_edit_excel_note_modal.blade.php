
<div class="modal fade" id="modal-show-edit-excel-note" tabIndex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Show/Edit Note</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="note_msg_div" style="display:none">
              <ul id="show_edit_excel_note_errors">
              </ul>
          </div>
           {{-- <button id="add_col">Add Col</button>  <button id="save_data">Save</button> --}}
          <form id="edit_excel_note_form" class="form-horizontal">
                   
                {!! Form::hidden('customer_id', Session::get('cust_id')) !!}
                {!! Form::hidden('excel_id') !!}
                   
                  </form>

                   <div class="row" style="padding-top: 10px;">
                      <div class="col-md-12">

                       <table class="table" data-paging="true" data-filtering="true"  data-sorting="true" id="excel_archive_table"></table>
                       <div id="edit_excel_htable"></div>
                      </div>
                    </div>
      </div>
      <div class="modal-footer">



          <button type="button" class="btn btn-default btn_close" id="close_modal_edit_excel_note"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_edit_excel_note">
            Update
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


/*var columns =  [{
    data: 'a'
      // 1nd column is simple text, no special options here
  }, {
    data: 'b',
    //type: 'numeric'
 
  }];*/

var
    container_excel ,
    hot_excel;
    var colHeaders = ['A', 'B','c','d','e'];

    $(function() {
 

var Id;
      $('#modal-show-edit-excel-note').on('show.bs.modal', function(e) 
      {
          
//hot_excel.destroy();
        //get data-id attribute of the clicked element
        Id = $(e.relatedTarget).data('id');

          $('input[name="excel_id"]').val(Id);
//document.getElementById('edit_excel_htable')
        container_excel = $(this).find('div#edit_excel_htable');

//console.log(container_excel);

   $.get('/admin/crm/notes/get_excel_note/'+Id,function(res){ 
     //hot_excel.destroy();
    
      setTimeout(function() {
        hot_excel = new Handsontable(container_excel[0], {
            rowHeaders: true,
            colHeaders: true,
            data:res.data,
             stretchH: 'all',
            // fillHandle: true,
            // debug:true,
            minSpareRows: 1,
            contextMenu:["row_above", "row_below", "col_left", "col_right", "remove_row", "remove_col", '--------', "undo", "redo"],
           
        });

    }, 200);
 
  },'json');

  /* $('a.view_edit_ht').on('click', function () {
console.log('herer');
      $('#edit_excel_htable').handsontable('render');
    }); */
        
       // $(this).find('div#edit_excel_htable').handsontable('render');
      });

   
    $(".add_ajax_edit_excel_note").click(function() {

             $.ajax({
                        url: "{{ URL::route('admin.crm.ajax.note.update_excel')}}",
                        //headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        //data: 'htdata='+JSON.stringify(hot.getSourceData())+'headers'+colHeaders,
                        data: $('#edit_excel_note_form').serialize()+'&htdata='+JSON.stringify(hot_excel.getSourceData()),
                        success: function(response){
                           if(response.success=='yes'){

                             
                         $('#excel_active_table').footable({
                          "columns": excel_cols,
                          "rows": $.get('{{URL::route("admin.crm.excel.notes.json","active")}}',function(){},'json')
                        });

                         $('#excel_archive_table').footable({
                          "columns": excel_cols,
                          "rows": $.get('{{URL::route("admin.crm.excel.notes.json","archived")}}',function(){},'json')
                        });
                            $(".add_ajax_edit_excel_note").html('Success');
                            $(".add_ajax_edit_excel_note").toggleClass('btn-success btn-primary');
                            setTimeout(
                              function()
                              {
                                $( "#close_modal_edit_excel_note" ).trigger( "click" );
                              }, 500);
                          }
                                         // console.log(response);
                         
                        }

                      });


        });
      });

</script>
  @endsection

 