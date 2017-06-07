
<div class="modal fade" id="modal-edit-htable" tabIndex="-1">
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
            <div class="col-xs-12">
              <div id="msg"></div>
                   <div  id="tab_handson_tables">
                      <a  class="btn btn-default" id="add_col">Add Col</a>  <a  class="btn btn-default" id="save_data">Save</a>
                      <div id="htable"></div>
                  </div>
            </div><!-- /.box-body -->
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

 
 

@section('script') 
    <script  src="{{URL::asset('handsontable/handsontable.full.js')}}"></script>
  {{-- <script  src="{{URL::asset('handsontable/handsontable.full.js')}}"></script>
 --}}
 
 

  <script>

   function getCarData() {
      return [{
        car: "Mercedes A 160",
        year: 2011,
        price_usd: 7000,
        price_eur: 7000
      }, {
        car: "Citroen C4 Coupe",
        year: 2012,
        price_usd: 8330,
        price_eur: 8330
      }, {
        car: "Audi A4 Avant",
        year: 2013,
        price_usd: 33900,
        price_eur: 33900
      }, {
        car: "Opel Astra",
        year: 2014,
        price_usd: 5000,
        price_eur: 5000
      }, {
        car: "BMW 320i Coupe",
        year: 2015,
        price_usd: 30500,
        price_eur: 30500
      }];
  }


var
    container = document.getElementById('htable'),
    hot;
  var cols = [{
    data: 'car'
      // 1nd column is simple text, no special options here
  }, {
    data: 'year',
    type: 'numeric'
  }, {
    data: 'price_usd',
    type: 'numeric',
    format: '$0,0.00',
    language: 'en-US' // this is the default locale, set up for USD
  }, {
    data: 'price_eur',
    type: 'numeric',
    format: '0,0.00 $',
    language: 'en-US' // i18n: use this for EUR (German)
      // more locales available on http://numbrojs.com/languages.html
  }];



      var colHeaders = ['Car', 'Year', 'Price ($)', 'Price (€)'];
        /*function addACol() {
          cols.push({})
          hot.updateSettings({
            columns: cols
          })
        }*/
  
$(function() {

    hot = new Handsontable(container, {
    data: getCarData(),
    colHeaders: colHeaders,
    columnSorting: true,
    columns: cols
  });

 /* hot.updateSettings({
    afterChange: function(changes, source) {
      if (hot.propToCol(changes[0][1]) === hot.countCols() - 1) {
        addACol();
      }
    }
  });*/

          $('#add_col').on('click',function(){
             // if (hot.propToCol(changes[0][1]) === hot.countCols() - 1) {
              var person = prompt("Please enter title", "abc");
                //cols.push({});
                colHeaders.push(person);
                cols.push({});
                 hot.updateSettings({
                  //data: getCarData(),
                  colHeaders: colHeaders,
                  columnSorting: true,
                  columns: cols
                });
   // }
         });

    $('#save_data').on('click',function(){

      

        $.ajax({
                        url: "{{ URL::route('admin.crm.note.handsontable_save')}}",
                        //headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: 'htdata='+JSON.stringify(hot.getSourceData())+'headers'+colHeaders,
                        success: function(response){
                         // console.log(response);
                         
                        }

                      });
    });

  
     
    });


  </script>
@endsection
 @section('styles')

  
    <link  rel="stylesheet"  href="{{URL::asset('handsontable/handsontable.full.css')}}">
   
 @endsection
 

