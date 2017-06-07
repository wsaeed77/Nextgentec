<div class="modal fade" id="modal-edit-knowledge-procedure" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Procedure</h4>
      </div>
      <div class="modal-body">
          <div id="err_edit_procedure">
          </div>
        <form id="update_procedure">
            <div class="form-group col-lg-6">
                <label>Customer</label>

                 <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                               {
                                  $selected_cust = session('cust_id');?>
                        {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'edit_procedure_customer','disabled'=>''])!!}
                   <?php } else{ ?>
                          {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'edit_procedure_customer'])!!}
                   <?php }?>

                <input type="hidden" name="id" value="" >

            </div>

            <div class="form-group col-lg-6">
                <label>Title</label>
                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}

            </div>


            <div class="form-group col-lg-12">
  	            <label>Procedure</label>
  	            {!! Form::textarea('procedure',null, ['placeholder'=>"Procedure",'class'=>"form-control textarea",'id'=>'edit_procedure','rows'=>10]) !!}
  	        </div>
            <input type="hidden" name="image_dir" value="">
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_edit_knowledge_procedure">Close</button>
          <button  class="btn btn-primary update_knowledge_procedure">
             Update
          </button>

      </div>
    </div>
  </div>
</div>

@section('styles')
@parent
<link href="/vendor/summernote/summernote.css" rel="stylesheet">

<style>

div.note-editable ol li {
  margin: 0 0 5px 0;
}

div.note-editable img {
  padding: 8px 8px 8px 0;
}

</style>

@endsection

@section('script')
@parent
<script src="/vendor/summernote/summernote.js"></script>
<script src="/vendor/summernote/summernote-floats-bs.min.js"></script>
@endsection

@section('document.ready')
@parent

{{-- <script type="text/javascript"> --}}

var imageDirId;

$('#modal-edit-knowledge-procedure').on('shown.bs.modal', function(e)
{
  $('#edit_procedure').summernote({
    callbacks: {
      onImageUpload: function(files, editor, $editable) {
        sendFile(files[0],editor,$editable);
      },
      onMediaDelete : function($target, editor, $editable) {
        var img = $target.attr("data-id");
        var dir = $target.attr("data-folder");

        $.get("/admin/knowledge/image/del/"+dir+"/"+img, function(response) {
          if (response.status == 'success') {
            // remove element in editor
            $target.remove();
          } else {
            alert('There was an error deleting the image.');
          }
        },"json");
      }
    },

    lang: 'en-US',
    dialogsInBody: true,
    height: 600,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true
  });

  function sendFile(file,editor,welEditable) {
        data = new FormData();
        data.append("file", file);
        data.append("image_dir", imageDirId);
        jQuery.ajax({
            url: "{{ URL::route('admin.knowledge.upload.image')}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(response){
              var data = jQuery.parseJSON(response);
              jQuery('#edit_procedure').summernote("insertImage", unescape(data.url), function($image) {
                $image.attr('data-id', data.id);
                $image.attr('data-folder', data.dir);
              });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus+" "+errorThrown);
            }
        });
    }

});

$('#modal-edit-knowledge-procedure').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('id');
  //populate the textbox
  $.get('/admin/knowledge/edit/procedure/'+Id,function(response ) {
    imageDirId = response.procedure.image_dir;

		if(response.procedure.customer)
      $('option[value="'+response.procedure.customer.id+'"]', $('#edit_procedure_customer')).prop('selected', true);

    $('#edit_procedure_customer').multiselect('refresh');

    $(e.currentTarget).find('input[name="title"]').val(response.procedure.title);
    $(e.currentTarget).find('input[name="image_dir"]').val(response.procedure.image_dir);
    $(e.currentTarget).find('textarea[name="procedure"]').val(response.procedure.procedure);
    $(e.currentTarget).find('input[name="id"]').val(Id);

   },"json");

   // Get an Image ID for image storage
  //  if(imageDirId == null) {
  //    $.get("{{ URL::route('admin.knowledge.get.uniqid')}}", function(response) {
  //        imageDirId = response.imageId;
  //    },"json");
  //  }
});

$( ".update_knowledge_procedure" ).click(function() {
  // for ( instance in CKEDITOR.instances )
  //         CKEDITOR.instances[instance].updateElement();
  $.ajax({
         url: "{{ URL::route('admin.knowledge.update.procedure')}}",
         //headers: {'X-CSRF-TOKEN': token},
         type: 'POST',
         dataType: 'json',
         data: $('#update_procedure').serialize(),
         success: function(response){
         if(response.success)
         {
               $( "#close_edit_knowledge_procedure" ).trigger( "click" );
               $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#procedures');
             var  table = $('#knowledge_procedure_dt_table').DataTable( {
                     retrieve: true

                 } );

                 table.draw();
            $('#knowledge_procedure_dt_table_wrapper').addClass('padding-top-40');
            alert_hide();
         }

         },
         error: function(data){
             var errors = data.responseJSON;
             //console.log(errors);
             var html_error = '<div  class="alert alert-danger"><ul>';
             $.each(errors, function (key, value)
             {
                 html_error +='<li>'+value+'</li>';
             })
              html_error += "</ul></div>";
         $('#err_edit_procedure').html(html_error);

       }
     });
   });

   $('#modal-edit-knowledge-procedure').on('hidden.bs.modal', function(e)
   {
     console.log('closed');
     $('#edit_procedure').summernote('destroy');
   });

@endsection
