@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
         Ticket Detail
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li>
            <i class="fa fa-pencil-square-o"></i>  <a href=" {{ URL::route('admin.ticket.index')}}">Tickets</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> {{$ticket->title}}
        </li>
    </ol>
</section>
 
<section class="content">
        <div class="row">
        <div class="col-xs-12">
          <div class="col-xs-6 pull-right">
             
               {{-- <a href=" {{ URL::route('admin.ticket.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>  Add Response</a>
                <a href=" {{ URL::route('admin.ticket.create')}}" class="btn btn-primary pull-right margin-right10"><i class="fa fa-edit"></i> Edit</a> --}}
                 {{-- <a href=" {{ URL::route('admin.ticket.create')}}" class="btn btn-primary pull-right"> Add Response</a> --}}
          </div>
          </div>
          <div class="col-xs-12">
          <div class="col-xs-6">
            <div id="msg"></div>
              
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Ticket Detail</h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body">
                  <dl class="dl-horizontal">
                    <dt>Title</dt>
                    <dd>{{$ticket->title}}</dd>
                     <br/>

                    <dt>Description</dt>
                    <dd><?php echo urldecode($ticket->body);?></dd>
                    
                  </dl> 
                </div><!-- /.box-body -->
                @if($ticket->attachments)
                <div class="box-header with-border top-border bot_10px">
                  <h3 class="box-title">Attachments</h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body">
                  <dl class="dl-horizontal">
                  @foreach($ticket->attachments as $attachment)
                  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ff"> 
                  @if(basename($attachment->type)=='pdf')
                  <img class="img-responsive" src="{{url('/')."/img/pdf.jpg"}}" />
                      <div class="overlay" style="display:none">
                        <a class="btn btn-md btn-primary iframe" href="{{url('/')."/attachments/$attachment->name"}}">
                          <i class="fa fa-eye"></i>
                        </a>
                      </div>
                  @else
                    <img class="img-responsive" src="{{url('/')."/attachments/$attachment->name"}}" />
                      <div class="overlay" style="display:none">
                        <a class="btn btn-md btn-primary fancybox" href="{{url('/')."/attachments/$attachment->name"}}">
                          <i class="fa fa-eye"></i>
                        </a>
                      </div>
                   @endif 
                  </div>
                  @endforeach
                  </dl> 
                  <div class="clearfix"></div>
                </div><!-- /.box-body -->
                @endif

                 <div class="box-header with-border top-border bot_10px">
                  <h3 class="box-title">Responses</h3>
                  
                </div>


                
                  <div class="box-footer box-comments" id="responses_div">
                    @foreach($ticket->responses as $response)
                    <div class="box-comment">
                      <!-- User image -->
                      <img alt="user image" src="{{ URL::asset('img/avatar2.png')}}" class="img-circle img-sm">
                      <div class="comment-text">
                        <span class="username">
                        {{ $response->responder->f_name }}
                          <span class="text-muted pull-right">{{ date('d/m/Y  h:i A',strtotime($response->created_at)) }}</span>
                       
                        </span><!-- /.username -->
                        {!! html_entity_decode($response->body) !!}
                       
                      </div><!-- /.comment-text -->
                    </div><!-- /.box-comment -->
                    @endforeach
                  </div>

                  <div class="box-footer">

                    <div class="box-header with-border top-border bot_10px">
                      <h3 class="box-title">Add response</h3>
                    </div>

                    <form action="#" method="POST" id="response_form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                      <div class="form-group col-lg-12">
                           
                        {!! Form::textarea('body',null, ['placeholder'=>"Ticket descriptions",'class'=>"form-control textarea",'id'=>'description','rows'=>3]) !!}
                      </div>
                      
                    </form>  

                    <div class="col-lg-12"> 
                        <div class="form-group col-lg-6 pull-right">
                           <a class="btn btn-lg btn-info pull-right" onclick="addResponse()" >Save</a>
                        </div>
                      </div>
                  </div>
               
              </div><!-- /.box -->
          </div>

          <div class="col-xs-6">
            <div id="msg_info"></div>
              
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Info</h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body">
                  
                  <dl class="dl-horizontal info">
                    <dt>Customer Info</dt>
                    <dd> 
                      <button type="button" class="btn bg-gray-active  btn-sm">
                       <span>

                          @if($ticket->customer)
                          <i class="fa fa-user"></i> {{ $ticket->customer->name }}
                          @elseif($ticket->email)
                           <i class="fa fa-envelope"></i> {{ $ticket->email }}@endif
                        </span>
                        </button>  
                        @if($ticket->location)
                         <button type="button" class="btn bg-gray-active  btn-sm">
                          <i class="fa fa-map-marker"></i> 
                            <span>{{ $ticket->location->location_name }}</span>
                        </button>
                        @endif
                        @if($ticket->location)
                         <button type="button" class="btn bg-gray-active  btn-sm">
                          <i class="fa  fa-gears"></i> 
                            <span>{{ $ticket->service_item->title }}</span>
                        </button>
                       @endif

                       <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-assign-users" id="modaal" data-id="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
                    </dd>
                    <dt>Assigned Users</dt>
                    <dd >
                      <div id="assigned_users" class="pull-left"> 
                        @if($ticket->assigned_to)
                        @foreach($ticket->assigned_to as $employee)
                         <p class="btn bg-gray-active  btn-sm">
                            
                                <i class="fa fa-user"></i>  
                                <span>{{ $users[$employee->id] }}</span>
                              <a class="btn btn-xs" href="javascript:;" data-target="#modal-delete-assign-user" id="modaal" data-uid="{{$employee->id}}" data-tid="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-times"></i></a>  
                            </p>
                            @endforeach
                         @endif
                      </div>
                       <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-assign-users" id="modaal" data-id="{{$ticket->id}}"
                                                                 data-toggle="modal"><i class="fa fa-pencil"></i></a>
                    </dd>

                        <?php
                            $btn_class =  '';
                        if ($ticket->priority == 'low') {
                            $btn_class = 'bg-gray';
                        }
                        if ($ticket->priority == 'normal') {
                            $btn_class = 'bg-blue';
                        }
                        if ($ticket->priority == 'high') {
                            $btn_class = 'bg-green';
                        }
                        if ($ticket->priority == 'urgent') {
                            $btn_class = 'bg-yellow';
                        }
                        if ($ticket->priority == 'critical') {
                            $btn_class = 'bg-red';
                        }

                        ?>
                     <dt>Priority</dt>
                    <dd id="priority">
                      <button type="button" class="btn {{$btn_class}}  btn-sm">
                        <span>{{$ticket->priority}}</span>
                      </button>
                      <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-priority-status" id="modaal" data-id="{{$ticket->id}}"
                                                                 data-toggle="modal"><i class="fa fa-pencil"></i></a>
                    </dd>


                     <dt>Status</dt>
                    <dd id="status">
                      <button type="button" class="btn bg-gray-active  btn-sm">
                         
                            <span>{{$ticket->status}}</span>
                        </button>
                        <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-priority-status" id="modaal" data-id="{{$ticket->id}}"
                                                                 data-toggle="modal"><i class="fa fa-pencil"></i></a>
                    </dd>
                    
                  </dl> 
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
          </div>
          </div>
          </div>
</section>

@include('crm::ticket.edit_assigned_users_modal')
@include('crm::ticket.delete_modal_assign_user')
@include('crm::ticket.edit_priority_status_modal')
@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script> 
      <script src="/fancybox/jquery.fancybox.js?v=2.1.5"></script> 
   

  <script>
  $(document).ready(function() 
    {
    CKEDITOR.replace( 'description', {
              filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
              filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
          } );

    $('.fancybox').fancybox();

    $("a.iframe").fancybox({
      
      'type': 'iframe'
      });

    $('.ff').hover(function() {
      $(this).addClass('bb');
      $(this).children('img').css({ opacity: 0.8 });
      $(this).children('.overlay').show();
    }, function() {
      /* Stuff to do when the mouse leaves the element */
      $(this).removeClass('bb');
      $(this).children('img').css({ opacity:1 });
      $(this).children('.overlay').hide();
    });

   /* $('.multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control'
            
        });
*/
    } );

  function addResponse()
  {
      for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();


    //{{URL::route('admin.ticket.add_response')}}
     $.ajax({
        url: "{{ URL::route('admin.ticket.add_response')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#response_form').serialize(),
        success: function(response){
         $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
        $('#msg').removeClass('alert-danger').addClass('alert-success').show(); 
        //location.reload(); 

        var html_response ='' ;

          $.each(response.responses,function(index,response_data) {
          
           html_response += '<div class="box-comment"><img alt="user image" src="{{ URL::asset('img/avatar2.png')}}" class="img-circle img-sm"><div class="comment-text"><span class="username">'+response_data.name+'<span class="text-muted pull-right">'+response_data.response_time+'</span></span>'+response_data.body+'</div></div>';
           
        });
        $('#responses_div').html(html_response);

         alert_hide(); 
      }
    });

  }
  </script>
@endsection
@section('styles')
<link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="/fancybox/jquery.fancybox.css?v=2.1.5">
  <link rel="stylesheet" href="/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5">

  
  
<style>
.info>dd, .info>dt {
    line-height: 3;
}

.top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
    .bot_10px{
        margin-bottom: 10px;
    }

    .margin-right10{
      margin-right: 10px;
    }

.bb {
    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
   
    opacity: 1;
    cursor: pointer;
    overflow: visible;
}
.box .overlay > .btn, .overlay-wrapper .overlay > .btn {
    color: #000;
    font-size: 30px;
    left: 50%;
    margin-left: -15px;
    margin-top: -15px;
    position: absolute;
    top: 50%;
}
</style>
@endsection
