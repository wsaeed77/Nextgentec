@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
         Add Ticket
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
         <li >
           <a href="{{ URL::route('admin.ticket.index')}}"> <i class="fa fa-table"></i> Tickets</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Add Ticket
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-xs-12">
             @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
           <div class="clearfix"></div>
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title ">Customer Detail</h3>
                </div>
                <?php $rand1 = rand(0,500);
                      $rand2 = rand(501,999);
                $rand = $rand1.$rand2;?>

                {!! Form::open(['route' => 'admin.ticket.store','method'=>'POST','id'=>'form_validate']) !!}

                 <div class="box-body">
                         <input type="hidden" name="rand" value="<?php echo $rand; ?>">
                  
                    <div class="col-lg-12"> 

                       
                        <div class="form-group col-lg-6">
                            <label>Customer</label>
                            
                             {!! Form::select('customer_id', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','onChange'=>'load_service_items(this.value)'])!!}
                        </div>

                   
                    
                        <div class="form-group col-lg-6">
                         <label>Service Item</label>
                           <?php $service_items = [];?>
                             {!! Form::select('service_item', $service_items,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Service item', 'id'=>'service_items'])!!}
                        </div>
                   
                  
                         <div class="form-group col-lg-6">
                            <label>Location</label>
                             <?php $locations = [];?>
                             {!! Form::select('location', $locations,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Location', 'id'=>'locations'])!!}
                        </div>
                    </div>


                      <div class="clearfix"></div>
                   </div>

                    <div class="box-header with-border top-border bot_10px">
                      <h3 class="box-title">Ticket Detail</h3>
                    </div>

                     <div class="box-body">
                        <div class="col-lg-12"> 

                        
                            <div class="form-group col-lg-6">
                                <label>Title</label>
                                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
                            </div>
                     

                        

                            
                            <div class="form-group col-lg-6">
                                <label>Assign Users</label>
                                 {!! Form::select('users[]', $users,'',['class'=>'form-control multiselect','placeholder' => 'Assign Users', 'id'=>'users','multiple'=>''])!!}
                            </div>
                            
                        </div>

                    <div class="col-lg-12"> 

                        <div class="form-group col-lg-12">
                            <label>Description</label>
                             {!! Form::textarea('body',null, ['placeholder'=>"Ticket descriptions",'class'=>"form-control textarea",'id'=>'description','rows'=>10]) !!}
                        </div>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-1">
                          <label>Priority</label>
                        </div>
                      <div class="form-group col-lg-1">
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="low" id="low" name="priority">
                              <button type="button" class="btn bg-gray  btn-xs">
                                 
                                    <span>Low</span>
                                    </button>
                            </label>
                          </div>
                      </div>

                      <div class="form-group col-lg-1">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="normal" id="normal" name="priority">
                              <button type="button" class="btn bg-blue  btn-xs">
                                 
                                    <span>Normal</span>
                                    </button>
                            </label>
                          </div>
                      </div>

                      <div class="form-group col-lg-1">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="high" id="high" name="priority">
                              <button type="button" class="btn bg-green  btn-xs">
                                 
                                    <span>High</span>
                                    </button>
                            </label>
                          </div>
                      </div>


                      <div class="form-group col-lg-1">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="urgent" id="urgent" name="priority">
                              <button type="button" class="btn bg-yellow  btn-xs">
                                 
                                    <span>Urgent</span>
                                    </button>
                            </label>
                          </div>
                      </div>


                      <div class="form-group col-lg-2">
                          <div class="radio">
                            <label>
                              <input type="radio"  value="critical" id="critical" name="priority">
                              <button type="button" class="btn bg-red  btn-xs">
                                 
                                    <span>Critical</span>
                                    </button>
                            </label>
                          </div>
                      </div>
                          
                          
                     
                    </div>
                  
                    <div class="col-lg-12"> 

                        <div class="form-group col-lg-6 pull-right">
                           <button class="btn btn-lg btn-info pull-right" type="submit">Save</button>
                        </div>
                    </div>
                    </div>
            {!! Form::close() !!}
           <div class="box-header with-border top-border bot_10px">
              <h3 class="box-title">Attatch Images</h3>
            </div>

            <div class="box-body">
               <div class="col-lg-12"> 
                <form action="{{URL::route('admin.ticket.upload')}}" class="dropzone" id="my-awesome-dropzone" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                     <input type="hidden" name="rand" value="<?php echo $rand; ?>">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                        
                    </div>

                </form>      
                </div>
             </div> 


            </div>
        </div>
    </div>
</section>


@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
{{--  <script src="/js/bootstrap3-wysihtml5.all.min.js"></script> --}}
  <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script> 
  <script src="/js/dropzone.js"></script>
<script type="text/javascript">

$(document).ready(function() 
    {
       


        $('.multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });
        
     $('.datepicker').datepicker();

     //$(".textarea").wysihtml5();   
 //CKEDITOR.replace('description');
 CKEDITOR.replace( 'description', {
    filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
    filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
} );


             Dropzone.options.myAwesomeDropzone = {
                init: function() {
                  this.on("addedfile", function(file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement('<button class="btn btn-sm relative left-15px btn-danger top-10px" ><i class="fa  fa-times-circle"></i> Delete</button>');


                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                      // Make sure the button click doesn't submit the form:
                      e.preventDefault();
                      e.stopPropagation();

                      // Remove the file preview.
                      _this.removeFile(file);
                      // If you want to the delete the file on the server as well,
                      // you can do the AJAX request here.

                            $.ajax({
                                      url: "{{ URL::route('admin.ticket.ajax_del_img')}}",
                                      //headers: {'X-CSRF-TOKEN': token},
                                      type: 'POST',
                                      dataType: 'json',
                                      data:'file='+ file.name+'&rand='+'<?php echo $rand; ?>',
                                      success: function(response){
                                       
                                      }
                                    });  
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                  });
                }
              };
    });

function load_service_items(c_id)
{
 //console.log('ff');
  $.get('/admin/crm/ticket/ajax_get_service_items/'+c_id,function(response ) {
                
                //console.log(data_response);
                var service_items = response.service_items;
                 $.each(service_items,function(index, service_item) {  
                        //console.log(el); 
                    $('#service_items').append($("<option></option>")
                             .attr("value",service_item.id)
                             .text( service_item.title)); 
                   
                });

                $('#service_items').multiselect('rebuild');

                 var locations = response.locations;
                 $.each(locations,function(index, location) {  
                        //console.log(el); 
                    $('#locations').append($("<option></option>")
                             .attr("value",location.id)
                             .text( location.location_name)); 
                   
                });

                $('#locations').multiselect('rebuild');
         
                                                                
                },"json" 
              );

}

</script>
@endsection
@section('styles')
<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="/css/dropzone.css">
<style>
    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
    .bot_10px{
        margin-bottom: 10px;
    }

    .relative{
        position: relative;
    }
    .left-15px{
        left: 15px;
    }
    .dropzone {
              background: white none repeat scroll 0 0;
              border: 2px solid rgba(0, 0, 0, 0.3);
              min-height: 150px;
              padding: 54px;
            }
    .dropzone {
          background: white none repeat scroll 0 0;
          border: 2px dashed #0087f7;
          border-radius: 5px;
        }
</style>
@endsection