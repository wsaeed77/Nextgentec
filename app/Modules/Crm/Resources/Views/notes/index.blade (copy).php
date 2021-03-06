@extends('admin.main')
@section('content')

 <section class="content-header">
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
</section>

<section class="content">
  <div class="row">
            <div class="col-xs-12">
            <div id="msg"></div>

                  <div class="nav-tabs-custom ">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_active_note" data-toggle="tab">Active</a></li>
                      <li><a href="#tab_acvhived_note" data-toggle="tab">Archived</a></li>
                     {{--  <li><a href="#tab_handson_tables" data-toggle="tab">HandsonTables</a></li> --}}

                    </ul>
                    <div class="tab-content ">
                      <div class="tab-pane active table-responsive" id="tab_active_note">
                          <table class="table table-hover" style="cursor:pointer" id="dt_active_notes_table">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>Subject</th>
                                  <th>Source</th>
                                  <th>Created By</th>
                                  <th>Created at</th>
                                  <th>Actions</th>
                                </tr>
                                </thead>
                          </table>

                                <script id="details-template-active" type="text/x-handlebars-template">

                                <div class="attachment">

                                 <label>ID: @{{id}}</label>
                                   <br/>
                                             <label>Detail:</label>
                                                  <p class="filename">
                                                    @{{note}}
                                                  </p>
                                                  
                                                </div>
                              

                                 {{--  <label>Detail:</label>
                                  <p class="filename">
                                    @{{note}}
                                  </p>
 --}}
                                </div>

                            </script>
                      </div><!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_acvhived_note">
                          <table class="table table-hover" style="cursor:pointer" id="dt_archived_notes_table">
                              <thead>
                                <tr>
                                <th></th>
                                   <th>Subject</th>
                                  <th>Source</th>

                                   <th>Created By</th>
                                  <th>Created at</th>
                                  <th>Actions</th>

                                </tr>
                                </thead>
                          </table>

                                <script id="details-template-archived" type="text/x-handlebars-template">

                                <div class="attachment">
                                 <label>ID: @{{id}}</label>
                                   <br/>
                                             <label>Detail:</label>
                                                  <p class="filename">
                                                    @{{note}}
                                                  </p>

                                                </div>

                              {{--   <table class="table">
                                    <tr>
                                        <td>Detail:</td>
                                        <td>@{{note}}</td>
                                    </tr>

                                </table> --}}

                            </script>
                      </div><!-- /.tab-pane -->

                       {{-- <div class="tab-pane" id="tab_handson_tables">
                         <div id="htable"></div>
                      </div> --}}
                    </div><!-- /.tab-content -->
                  </div>



                </div><!-- /.box-body -->

            </div>
          </div>

</section>


 @include('crm::notes.ajax_edit_note_modal')
  {{-- @include('crm::notes.handsontable_modal')  --}}



@endsection
@section('script')
@parent
 <!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
 
  <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
  
  <script type="text/javascript" src="{{URL::asset('js/handlebars.js')}}"></script>
  <script src="{{URL::asset('js/bootstrap-dialog.min.js')}}"></script>
  <script src="{{URL::asset('js/bootstrap-editable.min.js')}}"></script>
  <script src="{{URL::asset('js/select2.full.min.js')}}"></script>
  <script src="{{URL::asset('vendor/summernote/summernote.js')}}"></script>
  <script src="{{URL::asset('vendor/summernote/summernote-floats-bs.min.js')}}"></script>

  
 


  <script>
  var table_active ='';
   var table_archive ='';
    $(function() {



      var template_active = Handlebars.compile($("#details-template-active").html());
      var template_archived = Handlebars.compile($("#details-template-archived").html());

           table_active = $('#dt_active_notes_table').DataTable({
              processing: true,
              serverSide: true,
              bAutoWidth: false,
              ajax: '{!! route('admin.crm.notes.data_index_active') !!}',
              "order": [[ 4, "desc" ]],
              columns: [{
                          "className":      'details-control',
                          "orderable":      false,
                          "data":           null,
                          "defaultContent": '<i class="glyphicon p glyphicon-chevron-right"></i>',
                           "searchable": false
                        },
                        {data: 'subject',name: 'subject'},
                        {data: 'source',name: 'source'},

                        {data: 'created_by',name: 'created_by',orderable: false,searchable: false},
                        {data: 'created_at',name: 'created_at'},
                        {data: 'actions',name: 'actions',orderable: false,searchable: false}



                        ],
              "fnDrawCallback": function(){
                var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
                var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
                //console.log(pageCount);
                if (pageCount > 1) {
                  $('.dataTables_paginate').css("display", "block");
                } else {
                  $('.dataTables_paginate').css("display", "none");
                }
              },
              "initComplete": function( settings, json ) {
                  init_editable();
                }
          });




           $('#dt_active_notes_table tbody').on('click', 'td.details-control', function () {
              var tr = $(this).closest('tr');
              var row = table_active.row( tr );

              if ( row.child.isShown() ) {
                  // This row is already open - close it
                  row.child.hide();
                  tr.find('i.glyphicon').removeClass('glyphicon-chevron-down');
                  tr.find('i.glyphicon').addClass('glyphicon-chevron-right');
              }
              else {
                  // Open this row
                  row.child( template_active(row.data()) ).show();
                  tr.find('i.glyphicon').addClass('glyphicon-chevron-down');
                  tr.find('i.glyphicon').removeClass('glyphicon-chevron-right');
              }

          });



           table_archive = $('#dt_archived_notes_table').DataTable({
              processing: true,
              serverSide: true,
              bAutoWidth: false,
              ajax: '{!! route('admin.crm.notes.data_index_archived') !!}',
              "order": [[ 4, "desc" ]],
              columns: [{
                          "className":      'details-control',
                          "orderable":      false,
                          "data":           null,
                          "defaultContent": '<i class="glyphicon p glyphicon-chevron-right"></i>',
                          "searchable": false
                        },
                        {data: 'subject',name: 'subject'},
                        {data: 'source',name: 'source'},

                        {data: 'created_by',name: 'created_by',orderable: false,searchable: false},
                        {data: 'created_at',name: 'created_at'},
                        {data: 'actions',name: 'actions',orderable: false,searchable: false}



                        ],
                "fnDrawCallback": function(){
                  var paginateRow = $(this).parent().prev().children('div.dataTables_paginate');
                  var pageCount = Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength);
                  //console.log(pageCount);
                  if (pageCount > 1) {
                    $('.dataTables_paginate').css("display", "block");
                  } else {
                    $('.dataTables_paginate').css("display", "none");
                  }
                },
              "initComplete": function( settings, json ) {
                  init_editable();
                }
          });

           $('#dt_archived_notes_table tbody').on('click', 'td.details-control', function () {
              var tr = $(this).closest('tr');
              var row = table_archive.row( tr );

              if ( row.child.isShown() ) {
                  // This row is already open - close it
                  row.child.hide();
                  tr.find('i.glyphicon').removeClass('glyphicon-chevron-down');
                  tr.find('i.glyphicon').addClass('glyphicon-chevron-right');
              }
              else {
                  // Open this row
                  row.child( template_archived(row.data()) ).show();
                  tr.find('i.glyphicon').addClass('glyphicon-chevron-down');
                  tr.find('i.glyphicon').removeClass('glyphicon-chevron-right');
              }
          });

         $('.multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            buttonWidth: '100%'

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



      $('#modal-edit-note').on('show.bs.modal', function(e)
       {

        $("#note_source").select2({
            data: [
              { id: 'Call', text: 'Call' },
              { id: 'Email', text: 'Email' },
              { id: 'Visit', text: 'Visit' },
              { id: 'Other', text: 'Other' }
            ],
            minimumResultsForSearch: Infinity,
            placeholder: "",
            allowClear: true
          });
        




        var Id = $(e.relatedTarget).data('id');
         $(e.currentTarget).find('#note_id').val(Id);

         $.get('/admin/crm/notes/single/'+Id,function(response) {
                  //$('#location_'+loc_id).html(data_response);
                  $(e.currentTarget).find('#note_subject').val(response.subject);

                  $("#note_source").val(response.source).change();
                  $('#create_note_body').val(response.note);
                  $('#create_note_body').summernote({ 
                   callbacks: {
                            onImageUpload: function(files) {
                            //console.log(files);
                            // console.log($editable);
                          uploadImage(files[0],'note','create_note_body');
                          }},
                  lang: 'en-US',
                  dialogsInBody: true,
                  height: 200,                 // set editor height
                  minHeight: null,             // set minimum height of editor
                  maxHeight: null,             // set maximum height of editor
                  focus: true});

                 
                },"json");
     });  

     $(".update_ajax_note").click(function() {


        //$('#loc_tbl_'+Id).html('<img id="load_img" src="{{asset('img/loader.gif')}}" />');
        //alert( "Handler for .click() called." );
         
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.note.update')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#note_form').serialize() ,
          success: function(response){
            if(response.success){
            /*  table_active.ajax.reload();
            table_archive.ajax.reload();
              init_editable();*/
            $( "#close_modal_note" ).trigger( "click" );
            $('<div  class="alert alert-success"><ul><li>'+response.msg+'</li></ul></div>').insertBefore('#msg');

            location.reload();
            //alert_hide();
            }
          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value)
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#edit_note_errors').html(html_error);
        $('#note_msg_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide();
        // Render the errors with js ...
      }
        });
      }); 





     
    });

function init_editable()
{
  $('.subject_editable').editable({
                      inputclass:'col-md-12',
                      name:'subject',
                      mode:'inline',
                      url: '{{URL::route('admin.crm.ajax.note.update_editable')}}'
                    });


   

   var source_data = [{ id: 'Call', text: 'Call' },
                        { id: 'Email', text: 'Email' },
                        { id: 'Visit', text: 'Visit' },
                        { id: 'Other', text: 'Other' }];

       $('.source').editable({
          inputclass:'col-md-12',
          mode:'inline',
          url: '{{URL::route('admin.crm.ajax.note.update_editable')}}',
          source: source_data,
            select2: {
               multiple: false
            }
        });

      
     

}

function change_pin_note(id,value)
{
  $.ajax({
          url: "{{ URL::route('admin.crm.note.pin_status_change')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: 'id='+id+'&pin_status='+value,
          success: function(response){
          if(response.success=='ok')
          {
            table_active.ajax.reload();
            table_archive.ajax.reload();

                $('<div  class="alert alert-success"><ul><li>'+response.msg+'</li></ul></div>').insertBefore('#msg');

             alert_hide();
          }

          }
      });
}

function change_archive_note(id,value)
{
  $.ajax({
          url: "{{ URL::route('admin.crm.note.archive_status_change')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: 'id='+id+'&archive_status='+value,
          success: function(response){
          if(response.success=='ok')
          {
            table_archive.ajax.reload();
            table_active.ajax.reload();

                init_editable();



                $('<div  class="alert alert-success"><ul><li>'+response.msg+'</li></ul></div>').insertBefore('#msg');

             alert_hide();
          }

          }

      });
}

function delete_note(id)
{

  BootstrapDialog.show({
            title: 'Delete Record',
            message: 'Are you sure to delete the record?',
            buttons: [{
                label: 'Yes',
                action: function(dialog) {
                    //dialog.setTitle('Title 1');


                      //console.log('hhh');
                     $.ajax({
                        url: "{{ URL::route('admin.crm.note.delete')}}",
                        //headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data: 'id='+id,
                        success: function(response){
                         // console.log(response);
                         if(response=='yes')
                          table_archive.ajax.reload();
                          table_active.ajax.reload();
                          init_editable();
                          $('<div  class="alert alert-success"><ul><li>'+response.msg+'</li></ul></div>').insertBefore('#msg');
                          alert_hide();
                        }

                      });

                   dialog.close();
                }
            }, {
                label: 'No',
                action: function(dialog) {
                     flg = 'no';
                     dialog.close();
                }
            }]
        });

}

  </script>
@endsection
@section('styles')
  <!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"> -->
   <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
       <link rel="stylesheet" href="{{URL::asset('css/bootstrap-dialog.min.css')}}">

   <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">



    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-multiselect.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-editable.css')}}">

    <link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">

 <style>
 .bot_10px{
        margin-bottom: 10px;
    }
     .top-10px{
        top: 10px;
        position: relative;
    }

  .attachment {
    background: #f4f4f4 none repeat scroll 0 0;
    border-radius: 3px;
    margin-right: 15px;
    padding: 10px;
}
.pin-active{
  color: #000;
}

.pin-active:hover{
  color: #b5bbc8;
}

.pin-disabled{
  color:#b5bbc8;
}

.pin-disabled:hover{
  color:#000;
}

 </style>
@endsection
