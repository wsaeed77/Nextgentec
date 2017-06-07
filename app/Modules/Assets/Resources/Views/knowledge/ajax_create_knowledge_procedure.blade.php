<div class="modal fade" id="modal-create-knowledge-procedure" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Procedure</h4>
      </div>
      <div class="modal-body">
          <div id="err_procedure">
          </div>
        <form id="create_procedure">
            <div class="form-group col-lg-6">
                <label>Customer</label>

                 <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                 {
                    $selected_cust = session('cust_id');?>
                    {!! Form::select('customer', $customers,$selected_cust,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','disabled'=>'','id'=>'customer'])!!}

                        <?php } else{ ?>
                        {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer'])!!}

                         <?php } ?>
            </div>

            <div class="form-group col-lg-6">
                <label>Title</label>
                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}

            </div>

            <div class="form-group col-lg-12">
  	            <label>Procedure</label>
  	            {!! Form::textarea('procedure',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'procedure','rows'=>10]) !!}
  	        </div>
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_knowledge_procedure">Close</button>
          <button  class="btn btn-primary new_knowledge_procedure">
             Save
          </button>

      </div>
    </div>
  </div>
</div>

@section('styles')
@parent
<link href="/vendor/summernote/summernote.css" rel="stylesheet">

<style>
.modal-dialog {
  margin: 30px auto;
  /*width: 75%;*/
}
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

$('#modal-create-knowledge-procedure').on('shown.bs.modal', function(e)
{
  $('#procedure').summernote({
    callbacks: {
      onImageUpload: function(files, editor, $editable) {
      sendFile(files[0],editor,$editable);
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
            success: function(s){
              r = $.parseJSON(s);
              jQuery('#procedure').summernote("insertImage", r.url);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus+" "+errorThrown);
            }
        });
    }

});


$('#modal-create-knowledge-procedure').on('show.bs.modal', function(e)
{
  // Get an Image ID for image storage
  $.get("{{ URL::route('admin.knowledge.get.uniqid')}}", function(response) {
    if(imageDirId == null) {
      imageDirId = response.imageId;
    }
  },"json");

  $('#err_procedure').html('');
});

$( ".new_knowledge_procedure" ).click(function() {
//  for ( instance in CKEDITOR.instances )
//          CKEDITOR.instances[instance].updateElement();
 $.ajax({
        url: "{{ URL::route('admin.knowledge.store.procedure')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#create_procedure').serialize()+'&customer='+$('#customer').val(),
        success: function(response){
        if(response.success)
        {
              $( "#close_create_knowledge_procedure" ).trigger( "click" );
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
        $('#err_procedure').html(html_error);

      }
    });

  });

@endsection
