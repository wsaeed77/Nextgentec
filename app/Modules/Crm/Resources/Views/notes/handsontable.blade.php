@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
         Notes
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> notes
        </li>
    </ol>
@endsection

<section class="content">
  <div class="row">
            <div class="col-xs-12">
            <div id="msg"></div>

                    
                       <div  id="tab_handson_tables">
                       <button id="add_col">Add Col</button>  <button id="save_data">Save</button>
                         <div id="htable"></div>

                        
                      </div>
                    


                    <div class="col-lg-12">
                      <table class="table" data-paging="true" data-filtering="true"></table>
                    </div>
                  



                </div><!-- /.box-body -->

            </div>
         

</section>




@endsection
@section('script')
 <!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
  <script  src="{{URL::asset('handsontable/handsontable.full.js')}}"></script>

 

  <script type="text/javascript" src="{{URL::asset('footable/js/footable.js')}}"></script>
 

  

   {{--  <script  src="{{URL::asset('handsontable/pikaday.js')}}"></script>
  <script  src="{{URL::asset('handsontable/moment.js')}}"></script>
    <script  src="{{URL::asset('handsontable/numbro.js')}}"></script> --}}
 


  <script>

   function getCarData() 
   {
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
    //var colHeaders = ['Car', 'Year', 'Price ($)', 'Price (€)'];
        



$(function() {


  hot = new Handsontable(container, {
    data: getCarData(),
    colHeaders: colHeaders,
    columnSorting: true,
    rowHeaders: true,
    columns: cols,
    dropdownMenu: true
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
                  //colHeaders: colHeaders,
                  //columnSorting: true,
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

    $('.table').footable({
    "columns": [
      { "name": "id", "title": "ID", "breakpoints": "xs" },
      { "name": "subject", "title": "Subject" },
      { "name": "source", "title": "Source" },
      { "name": "created_by", "title": "Created By", "breakpoints": "xs" },
      { "name": "created_at", "title": "Created At", "breakpoints": "xs sm" },
      { "name": "actions", "title": "Actions", "breakpoints": "xs sm md" }
    ],
    "rows": $.get('{{URL::route("admin.crm.notes.json")}}',function(){},'json')
  });


     
    });


  </script>
@endsection
@section('styles')
  <!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"> -->
  
    <link  rel="stylesheet"  href="{{URL::asset('handsontable/handsontable.full.css')}}">
    <link  rel="stylesheet"  href="{{URL::asset('footable/css/footable.bootstrap.css')}}">


    {{-- <link  rel="stylesheet" media="screen" href="{{URL::asset('handsontable/pikaday.css')}}"> --}}

    <style>

.handsontable{
    width: 500px;
    height: 210px;
    overflow: hidden;
}

    </style>
 @endsection
