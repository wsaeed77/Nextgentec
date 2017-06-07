@extends('admin.main')
@section('content')

@section('content_header')
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
@endsection

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


                <?php $rand1 = rand(0,500);
                      $rand2 = rand(501,999);
                $rand = $rand1.$rand2;?>

                {!! Form::open(['route' => 'admin.ticket.store','method'=>'POST','id'=>'form_validate']) !!}
                         <input type="hidden" name="rand" value="<?php echo $rand; ?>">

                    <div class="col-lg-12">
                        <div class="form-group col-lg-4">
                            <label>Customer</label>
                            <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                                    $selected_cust = session('cust_id');
                                  else
                                    $selected_cust = '';
                            ?>
                             {{-- {!! Form::select('customer_id', $customers, $selected_cust,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','onChange'=>'load_service_items(this.value)'])!!} --}}

                            <!--  <input type="text" name="customer_contact" class="form-control" placeholder="Select contactg" id="customer_contact"/>  -->
                            {!! Form::input('text','customer_contact',null, ['placeholder'=>"Select contact",'class'=>"form-control",'id'=>'customer_contact']) !!}
                        </div>

                        <div class="form-group col-lg-4">
                         <label>Service Item</label>
                           <?php $service_items = [];?>
                             {!! Form::select('service_item', $service_items,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Service item', 'id'=>'service_items'])!!}
                        </div>

                    </div>


                    <div class="col-lg-12">
                        <div class="form-group col-lg-4">
                            <label>Title</label>
                            {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Assign Users</label>
                             {!! Form::select('users[]', $users,'',['class'=>'form-control multiselect','placeholder' => 'Assign Users', 'id'=>'users','multiple'=>''])!!}
                        </div>
                         <div class="form-group col-lg-4">
                            <label>Status</label>
                             {!! Form::select('status', $statuses,'',['class'=>'form-control multiselect', 'id'=>'status','multiple'=>''])!!}
                        </div>
                    </div>

                    <div class="col-lg-12">

                        <div class="form-group col-lg-12">
                            <label>Description</label>
                             {!! Form::textarea('body',null, ['placeholder'=>"Ticket descriptions",'class'=>"form-control textarea",'id'=>'description','rows'=>20]) !!}
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




        </div>
    </div>
</section>


@endsection
@section('script')

<script src="{{URL::asset('vendor/summernote/summernote.js')}}"></script>
<script src="{{URL::asset('vendor/summernote/summernote-floats-bs.min.js')}}"></script>
 {{--  <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script>
 --}}
   <script src="/js/magicsuggest.js"></script>

<script type="text/javascript">

$(document).ready(function()
    {

       
        $('.datepicker').datepicker();

             //$(".textarea").wysihtml5();
         //CKEDITOR.replace('description');
        /* CKEDITOR.replace( 'description', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            height :500
        } );
*/

  $('#description').summernote({
     callbacks: {
              onImageUpload: function(files) {
              //console.log(files);
              // console.log($editable);
            uploadImage(files[0],'ticket','description');
            }},
    lang: 'en-US',
    dialogsInBody: true,
    height: 600,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});

 <?php if((session('cust_id')!='') && (session('customer_name')!=''))
     {?>

    //load_service_items(<?php echo session('cust_id');?>);

     <?php } ?>

     /************************ magic suggest*************/

      var ms =  $('#customer_contact').magicSuggest({
        data:"{{ URL::route('admin.crm.ajax.get_contacts')}}",
        queryParam: 'customer_contact',
        allowFreeEntries: false,
        maxSelection: 1,
        valueField: 'id',
        <?php if(count($errors) > 0){?>
        value:["{{Session::get('cust_cont')}}"],
        <?php }?>
        displayField: 'name',
        groupBy: 'customer',
        resultAsString: true,
        renderer: function(data){
            return '<div class="country">' +
                '<div class="name">' + data.name + '</div>' +
                '<div style="clear:both;"></div>' +
                '<div class="prop">' +
                    '<div class="lbl">Location : </div>' +
                    '<div class="val">' + data.location + '</div>' +
                '</div>' +
                '<div class="prop">' +
                    '<div class="lbl">Country : </div>' +
                    '<div class="val">' + data.country + '</div>' +
                '</div>' +
                '<div style="clear:both;"></div>' +
            '</div>';
        }

    });

      $(ms).on('selectionchange', function(e,m){
       //alert("values: " + JSON.stringify(this.getValue()));
      // alert(this.getValue());
       //var strr = JSON.stringify(this.getValue());
       var strr = this.getValue().toString();

       //alert( strr);
        var res = strr.split("_"); 
//console.log(res);

        load_service_items(res[2])
       // console.log(res);
    });
  /************************ End magic suggest*************/

    });


function load_service_items(c_id)
{
 //console.log('ff');
  $.get('/admin/crm/ticket/ajax_get_service_items/'+c_id,function(response ) {

                //console.log(data_response);
                var service_items = response.service_items;
                $('#service_items').html('<option value="">Select service</option>');
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
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
 {{--  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"> --}}
 <link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{URL::asset('css/magicsuggest.css')}}">

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
.ms-res-ctn .ms-res-item em {
   background: none;
   color: #666;
    font-style: normal;
    font-weight: bold;
}

.country .prop .lbl {
    color: #aaa;
    float: left;
    font-size: 11px;
    line-height: 11px;
    margin-left: 25px;
    margin-right: 5px;
}
.country .prop .val {
    color: #666;
    font-size: 11px;
    line-height: 11px;
}
.country .prop {
    float: left;
    width: 50%;
}
</style>
@endsection


