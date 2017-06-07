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
            <div class="btn-group pull-right">
                <button class="btn btn-info" type="button" id="add_btn" data-target="#modal-add-simple-note" id="modaal"   data-toggle="modal" >Add</button>
                <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">
                  <span class="caret"></span>
                 
                </button>
                <ul role="menu" class="dropdown-menu">
                  <li><a data-target="#modal-add-simple-note" id="modaal"   data-toggle="modal">Simple Note</a></li>
                  <li><a data-target="#modal-add-excel-note" id="modaal"   data-toggle="modal">Excel Note</a></li>
                 
                </ul>
              </div>
              <div class="clearfix"></div>
                  <div class="nav-tabs-custom ">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_active_note" data-toggle="tab">Active</a></li>
                      <li><a href="#tab_acvhived_note" data-toggle="tab">Archived</a></li>
                      <li><a href="#tab_excel_active_tables" data-toggle="tab">Excel Notes Active</a></li> 
                       <li><a href="#tab_excel_archived_tables" data-toggle="tab">Excel Notes Active</a></li> 
                    </ul>
                    <div class="tab-content ">
                      <div class="tab-pane active table-responsive" id="tab_active_note">
                      <table class="table" data-paging="true" data-filtering="true"  data-sorting="true" id="active_table"></table>
                 
                      </div><!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_acvhived_note">
                      <table class="table" data-paging="true" data-filtering="true"  data-sorting="true" id="archived_table"></table>
                         
                               
                      </div><!-- /.tab-pane -->

                      <div class="tab-pane" id="tab_excel_active_tables">
                        
                           
                           <table class="table" data-paging="true" data-filtering="true"  data-sorting="true" id="excel_active_table"></table>
                         
                        
                      </div> 

                      <div class="tab-pane" id="tab_excel_archived_tables">
                       
                           
                           <table class="table" data-paging="true" data-filtering="true"  data-sorting="true" id="excel_archive_table"></table>
                         
                        
                      </div> 
                    </div><!-- /.tab-content -->
                  </div>



                </div><!-- /.box-body -->

            </div>
          </div>

</section>


 @include('crm::notes.ajax_edit_note_modal')
  {{-- @include('crm::notes.handsontable_modal')  --}}
 @include('crm::notes.ajax_add_simple_note_modal')
 @include('crm::notes.ajax_add_excel_note_modal')
@include('crm::notes.ajax_show_edit_excel_note_modal')


@endsection
@section('script')
@parent
 <!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
 
 
 
  <script src="{{URL::asset('js/bootstrap-dialog.min.js')}}"></script>
  <script src="{{URL::asset('js/bootstrap-editable.min.js')}}"></script>
  <script src="{{URL::asset('js/select2.full.min.js')}}"></script>
  <script src="{{URL::asset('vendor/summernote/summernote.js')}}"></script>
  <script src="{{URL::asset('vendor/summernote/summernote-floats-bs.min.js')}}"></script>

 <script type="text/javascript" src="{{URL::asset('footable/js/footable.js')}}"></script>
   <script  src="{{URL::asset('handsontable/handsontable.full.js')}}"></script>


  <script>
  var table_active ='';
   var table_archive ='';
   var ft;
   var cols = [
                  { "name": "id", "title": "ID", "breakpoints": "xs" },
                  { "name": "subject", "title": "Subject" },
                  { "name": "source", "title": "Source" },
                  { "name": "created_by", "title": "Created By", "breakpoints": "xs" },
                  { "name": "created_at", "title": "Created At", "breakpoints": "xs sm" },
                  { "name": "detail", "title": "Detail", "breakpoints": "xs sm md lg" },
                  { "name": "actions", "title": "Actions", "breakpoints": "xs sm md" }
                ];

    var excel_cols = [
                  { "name": "id", "title": "ID", "breakpoints": "xs" },
                  { "name": "created_by", "title": "Created By", "breakpoints": "xs" },
                  { "name": "created_at", "title": "Created At", "breakpoints": "xs sm" },
                  { "name": "actions", "title": "Actions", "breakpoints": "xs sm md" }
                ];




$(function() {

   



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

   $('#create_simple_note_body').summernote({ 
                   callbacks: {
                            onImageUpload: function(files) {
                            //console.log(files);
                            // console.log($editable);
                          uploadImage(files[0],'note','create_simple_note_body');
                          }},
                  lang: 'en-US',
                  dialogsInBody: true,
                  height: 200,                 // set editor height
                  minHeight: null,             // set minimum height of editor
                  maxHeight: null,             // set maximum height of editor
                  focus: true});

   $(".select2").select2({
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

      $('#modal-edit-note').on('show.bs.modal', function(e)
       {

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



  $( ".add_ajax_simple_note" ).click(function() {
     /* for ( instance in CKEDITOR.instances )
              CKEDITOR.instances[instance].updateElement();*/
      $.ajax({
        url: "{{ URL::route('admin.crm.note.create')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#simple_note_form').serialize(),
        success: function(response){
          if(response.success){
            $(".add_ajax_simple_note").html('Success');
            $(".add_ajax_simple_note").toggleClass('btn-success btn-primary');

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
            setTimeout(
              function()
              {
                $( "#close_modal_simple_note" ).trigger( "click" );
              }, 1200);
          }
        },
        error: function(data) {
          console.log('fail');
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
            //$('.table').trigger('footable_redraw'); 
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
            //table_active.ajax.reload();
            //table_archive.ajax.reload();

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
           // table_archive.ajax.reload();
            //table_active.ajax.reload();

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

       <link rel="stylesheet" href="{{URL::asset('css/bootstrap-dialog.min.css')}}">

   <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">



    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-multiselect.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-editable.css')}}">

    <link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">

    <link  rel="stylesheet"  href="{{URL::asset('handsontable/handsontable.full.css')}}">
    <link  rel="stylesheet"  href="{{URL::asset('footable/css/footable.bootstrap.css')}}">

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
.action_td > a {
  cursor: pointer;

}
.handsontable{
    width: 500px;
    height: 210px;
    overflow: hidden;
}

 </style>
@endsection
