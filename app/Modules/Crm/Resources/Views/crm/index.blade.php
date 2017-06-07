@extends('admin.main')
@section('content')

@section('content_header')
<h1>
 Customers
</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
  </li>
  <li class="active">
    <i class="fa fa-table"></i> Customers
  </li>
</ol>
@endsection

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div id="msg"></div>
      <div class="pull-right col-md-2">
       <label class="pull-left col-md-4 top-10px">Show:</label>
       <div class="col-md-8 pull-right">
        <select name="show_customers" id="show_customers" class="multiselect">
          <option value="all">All</option>
          <option value="active">Active</option>
          <option value="disabled">Disabled</option>
        </select>
      </select>
    </div>

  </div>


  <div class="clearfix"></div>

  <div class="table-responsive">
    <table class="table table-hover" style="cursor:pointer" id="dt_table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Phone</th>

          <th>Created at</th>
          <th>Contact</th>
          <th>Status</th>
          <th>Locations</th>

        </tr>
      </thead>


    </table>
    <div class="col-xs-12">

    </div>

  </div>

</div>
</div>
</section>

{{-- @include('crm::zoho.unimported_contacts_modal') --}}
@endsection
@section('script')
<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>

<script>
  $(function() {
    var table = $('#dt_table').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 25,
      searching: false,
      bAutoWidth: false,
      ajax: '{!! route('admin.crm.data_index') !!}',
      createdRow: function (row, data, index) {
        // console.log(data);
        if(data.is_active==1){
          $(row).addClass('clickable');
        }
        
      },

      columns: [{data: 'name',name: 'name'},
      {data: 'main_phone',name: 'main_phone'},
      {data: 'created_at',name: 'created_at'},
      {data: 'contact',name: 'contact',orderable: false,searchable: false},
      {data: 'status',name: 'is_active'},
      {data: 'locations',name: 'locations',orderable: false,searchable: false}

      ],
      "fnDrawCallback": function(){
        var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
        var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
        console.log(pageCount);
        if (pageCount > 1) {
          $('.dataTables_paginate').css("display", "block");
        } else {
          $('.dataTables_paginate').css("display", "none");
        }
      },
      dom: '<"col-sm-4 lr-p0"B><"img_processing"><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-4 text-center"i><"col-sm-5 pull-right lr-p0"p> <"clear">',
      buttons: [
      {
        text: 'New Customer',
        className: 'btn-sm new-cust btn',
        action: function ( e, dt, node, config ) {
                               //assets_tbl.ajax.url( '{!! route('admin.assets.all') !!}' ).load(function() {
                                $('.chk').prop('checked', true);
                             //window.location = "{{ URL::route('admin.assets.create')}}";

                             $.each(table.buttons('.btn'),function(ind,txt){
                              $(txt.node).addClass('unbold');
                            });

                             $(table.buttons('.new-cust')[0].node).addClass('bold').removeClass('unbold');
                             window.location = "{{ URL::route('admin.crm.create')}}";
                                // $('#top_heading').html('Assests');
                                
                              //});
                            }

                          },
                          @role('admin')
                          {

                            text: 'Import Zoho Customers',
                            className: 'btn-sm import btn',
                            action: function ( e, dt, node, config ) {

                             $.each(table.buttons('.btn'),function(ind,txt){
                              $(txt.node).addClass('unbold');
                            });

                             $(table.buttons('.import')[0].node).addClass('bold').removeClass('unbold');


                             $('.img_processing').html(' <img id="load_img_z" src="{{asset('img/loader.gif')}}"/>');


                                //$.get(APP_URL + '/admin/crm/zoho_get_contacts', function(response) {
                                  $.get("{{URL::route('admin.crm.get_zoho_contacts')}}", function(response) {


                                    if (response.success=='ok') {

                                      //console.log('kkk');
                                      $('.img_processing').html('');
                                      window.location = "{{URL::route('admin.crm.list_unimported')}}";
                                      

                                    }

                                    if (response.error) {
                                      $('#msg').html('<div  class="alert alert-danger"><ul><li>' + response.error_msg + '</li></ul></div>');
                                      $('.img_processing').html('');
                                    }
                                    //$('#service_items_table').html(response.html_contents);
                                  }, "json");

                                  alert_hide();
                                }

                              }
                              @endrole
                              ]
                            });

$('#dt_table tbody').on('click', 'tr', function() {

  if($(this).hasClass('clickable')){
    var route = '{!! route('admin.crm.index') !!}/show/' + $(this).attr('id');
    window.location.href = route;
  }else{
    $.notify({
        // options
        message: 'Customer is disabled.'
      },{
        // settings
        type: 'ng',
        delay: 250,
        animate: {
          enter: 'animated fadeInDown',
          exit: 'animated fadeOutUp'
        }
      });
  }

});



$('#show_customers').on('change', function(e){

  $.ajax({
    url:'{!! route('admin.crm.show_custs') !!}',
    data:'show_custs='+$(this).val(),
    type:'post',
    success:function(data)
    {

      if(data='ok')
        window.location.reload();
    }

  });


});

});


function export_zoho(id) {
        //console.log(id);
        $('#load_img').show();
        $.get(APP_URL + '/admin/crm/ajax_customer_export_zoho/' + id, function(response) {
            //console.log(response);
            if (response.success) {
              $('#msg').html('<div  class="alert alert-success"><ul><li>' + response.success + '</li></ul></div>');
              $('#load_img').hide();
            }

            if (response.error) {
              $('#msg').html('<div  class="alert alert-danger"><ul><li>' + response.error_msg + '</li></ul></div>');
              $('#load_img').hide();
            }
            //$('#service_items_table').html(response.html_contents);
          }, "json");

        alert_hide();
      }




      function import_zoho() {
        //console.log(id);
        $('#load_img_z').show();
        //$.get(APP_URL + '/admin/crm/zoho_get_contacts', function(response) {
          $.get("{{URL::route('admin.crm.get_zoho_contacts')}}", function(response) {

            console.log(response);
            if (response.success=='ok') {

              //console.log('kkk');

              window.location = "{{URL::route('admin.crm.list_unimported')}}";
               // $('#modal-unimported-contacts').modal('show');

               
                  //$('#modal_bdy').html(response.view);
                       // $('#dt_zoho').DataTable();


                //$('#msg').html('<div  class="alert alert-success"><ul><li>' + response.success + '</li></ul></div>');

                
                $('#load_img_z').hide();
              }

              if (response.error) {
                $('#msg').html('<div  class="alert alert-danger"><ul><li>' + response.error_msg + '</li></ul></div>');
                $('#load_img_z').hide();
              }
            //$('#service_items_table').html(response.html_contents);
          }, "json");

          alert_hide();
       // setTimeout("location.reload(true);", 10000);
     }

     $(function() {

      $('.pagination').addClass('pull-right');
    });
  </script>
  @endsection
  @section('styles')
  <!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('css/bootstrap-multiselect.css')}}">

  @endsection
