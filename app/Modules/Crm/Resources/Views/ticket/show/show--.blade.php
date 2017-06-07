@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
         Detail ticket view
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
  <div class="margin">
   
  
  
    <div class="btn-group">
      <button class="btn btn-info" type="button" id="add_btn">Add</button>
      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">
        <span class="caret"></span>
       
      </button>
      <ul role="menu" class="dropdown-menu">
        <li><a href="javascript:" onclick="add_func('reply')">Reply</a></li>
        <li><a href="javascript:" onclick="add_func('note')">Note</a></li>
       
      </ul>
    </div>
   
    <div class="btn-group">
     <button class="btn btn-info" type="button">Action</button>
      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">
        <span class="caret"></span>
        
      </button>
      <ul role="menu" class="dropdown-menu">
     
        <li><a href="javascript:" data-toggle="modal" data-id="{{$ticket->id}}" id="modaal" data-target="#modal-delete-ticket">Delete</a></li>
        <li><a onclick="mark_duplicate()" href="javascript:">Merge</a></li>
       
      </ul>
    </div>
<button class="btn btn-info" type="button" onclick="send_mail()">Email Test</button>
   <?php //echo '<pre>';
   //dd($ticket);
   ?>
    
    <div class="clearfix"></div>
  </div>
<div class="col-md-9" >
  <div  id="time_line_ticket">
    <h3 class="TicketTitle b12 t12 f24"># {{$ticket->id}} {{$ticket->title}}</h3>

    <!-- The time line -->
    <ul class="timeline">
      <!-- timeline time label -->
      <li class="time-label">
        <span class="bg-green">
          {{ date('d M. Y', strtotime($ticket->entered_date))}}
        </span>
      </li>
      <!-- /.timeline-label -->
      <!-- timeline item -->
      <li>
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i>  {{ date('h:i A', strtotime($ticket->entered_time))}}</span>

          @if($ticket->type=='email')
             <h3 class="timeline-header"><a href="#">@if($ticket->customer)
               {{ $ticket->customer->name }}
               @elseif($ticket->email)
                 {{ $ticket->sender_name }}@endif </a> sent an email</h3>
          @endif

          @if($ticket->type=='ticket')
             <h3 class="timeline-header">Created by: <a href="#" class="btn btn-default">
               <i class="fa fa-user"></i> {{ $ticket->entered_by->f_name}} {{'('.$ticket->entered_by->roles[0]->display_name.')'}}</a>  </h3>
          @endif

    
          <div class="timeline-body">
            <?php echo urldecode($ticket->body);?>
           </div>

           
        </div>
      </li>

      @if(count($ticket->attachments)!=0)
      <li>
        <i class="fa fa-paperclip bg-blue"></i>
        <div class="timeline-item">
         
          <h3 class="timeline-header"><a href="#">Attachments</a></h3>
          <div class="timeline-body">
            @foreach($ticket->attachments as $attachment)
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ff"> 
              @if(basename($attachment->type)=='pdf')
              <img class="img-responsive margin" src="{{url('/')."/img/pdf.jpg"}}" />
                  <div class="overlay" style="display:none">
                    <a class="btn btn-md btn-primary iframe" href="{{url('/')."/attachments/$attachment->name"}}">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
              @else
                <img class="img-responsive margin" src="{{url('/')."/attachments/$attachment->name"}}" />
                  <div class="overlay" style="display:none">
                    <a class="btn btn-md btn-primary fancybox" href="{{url('/')."/attachments/$attachment->name"}}">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
               @endif 
            </div>
              @endforeach
           </div>
           <div class="clearfix"></div>
        </div>
      </li>
      @endif
     
      @foreach($responses as $date => $response_record)
        {{-- //if ticket type is email then compare the ticket received with response created/received date --}}
        @if($date != date('Y-m-d',strtotime($ticket->entered_date)))
          <li class="time-label">
            <span class="bg-green">
              {{ date('d M. Y', strtotime($date))}}
            </span>
          </li>
        @endif

        @foreach($response_record as $response)
         @if($response->response_type=='response')
          <li>
            <i class="fa fa-comments bg-yellow"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> @if($response->sender_type=='customer')
              {{ date('h:i A', strtotime($response->entered_time))}}
              @else
              {{ date('h:i A', strtotime($response->entered_time))}}
              @endif </span>
              <h3 class="timeline-header"><a href="#">
              @if($response->sender_type=='customer')
                  @if($ticket->customer)
                    {{ $ticket->customer->name }}
                  @elseif($ticket->email)
                    {{ $ticket->sender_name }}
                  @endif
              @else
              
                 {{ $response->responder->f_name.' '.$response->responder->l_name}}

              @endif</a> Responded</h3>
              <div class="timeline-body">
                {!! html_entity_decode($response->body) !!}
              </div>
        
            </div>
          </li> 
          @endif
          @if($response->response_type=='note')
            <li>
              <i class="fa fa-sticky-note bg-blue"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 
                  {{ date('h:i A', strtotime($response->entered_time))}}
                </span>
                <h3 class="timeline-header"><a href="#">
               
                   {{ $response->responder->f_name.' '.$response->responder->l_name}}

               </a> Added Note</h3>
                <div class="timeline-body">
                  {!! html_entity_decode($response->body) !!}
                </div>
                <div class="timeline-footer">
               
                </div>
              </div>
            </li> 
          @endif   
        @endforeach
       @endforeach
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
    </ul>

    </div>
    <div class="row top-10px" style="display:none" id="response_div">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border top-border bot_10px">
              <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
              <form action="#" method="POST" id="response_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                 <input type="hidden" name="response_flag" value="reply">
               {{--   @if($ticket->type=='email') --}}
                <div class="form-group col-lg-12" id="from">
                   <div class="input-group">
                      <span class="input-group-addon"><b>From :</b> </span>
                      <input type="text"  class="form-control" value="{{' <'.Config::get('google.email_address').'>'}}" disabled>
                    </div>
                </div>
              @if($ticket->type=='ticket')
                 <div class="form-group col-lg-12" id="from">
                   <div class="input-group">
                      <span class="input-group-addon"><b>To :</b> </span>
                      <input type="text" name="to_email" class="form-control" value="@if($ticket->customer_contact->email !=''){{ $ticket->customer_contact->email }} @endif" >
                    </div>
                </div>
              @endif
                <div class="form-group col-lg-12">
                   <div class="col-lg-3">
                     <a href="javascript:" onclick="add_cc()" id="a_cc">Add Cc</a>&nbsp; | &nbsp;
                     <a href="javascript:" onclick="add_bcc()" id="a_bcc">Add Bcc</a>
                    </div>
                </div>
                  <div class="form-group col-lg-12" id="cc" style="display:none">
                    <div class="input-group">
                      <span class="input-group-addon"><b>Cc :</b> </span>
                      <input type="hidden" class="form-control ">

                       {!! Form::select('cc[]', $users,$assigned_users,['class'=>'select2','multiple'=>'','style'=>"width: 100%;"])!!}    
                    </div>
                  </div>
                  <div class="form-group col-lg-12" id="bcc" style="display:none">
                    <div class="input-group">
                      <span class="input-group-addon"><b>Bcc :</b> </span>
                      <input type="hidden" class="form-control ">
                      {!! Form::select('bcc[]', $users,$assigned_users,['class'=>'select2','multiple'=>'','style'=>"width: 100%;"])!!}
                    </div>
                  </div>
               {{--  @endif --}}
                <div class="form-group col-lg-12">
                  {!! Form::textarea('body',null, ['placeholder'=>"Ticket descriptions",'class'=>"form-control textarea",'id'=>'response','rows'=>20]) !!}
                </div>
              </form>  
            
              <div class="col-lg-12"> 
                  <div class="form-group col-lg-6 pull-right">
                     <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" /> <a class="btn btn-lg btn-info pull-right" onclick="addResponse('response_form')" >Save</a>
                  </div>
              </div>
            </div>
          </div><!-- /.box -->
        </div>
    </div>
    <div class="row top-10px" style="display:none" id="note_div">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border top-border bot_10px">
              <h3 class="box-title"></h3>
              {{-- <a class="btn btn-primary btn-xs pull-right" href="javascript:" onclick="mark_duplicate()"><i class="fa fa-copy"></i> Mark as Duplicate</a> --}}
            </div>
            <div class="box-body">
              <form action="#" method="POST" id="note_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                 <input type="hidden" name="response_flag" value="note">
                  <div class="form-group col-lg-12" id="duplicate" style="display:none">
                    <div class="input-group">
                      <span class="input-group-addon"><b>Original Ticket :</b> </span>
                      <input type="hidden" class="form-control ">

                       {!! Form::select('original_ticket', $tickets,'',['class'=>'select2 single','placeholder'=>'Select original','style'=>"width: 100%;"])!!}    
                    </div>
                  </div>
                <div class="form-group col-lg-12">
                  {!! Form::textarea('body',null, ['placeholder'=>"Note detail",'class'=>"form-control textarea",'id'=>'note','rows'=>20]) !!}
                </div>
              </form>  
              <div class="col-lg-12"> 
                  <div class="form-group col-lg-6 pull-right">
                     <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" /> <a class="btn btn-lg btn-info pull-right" onclick="addResponse('note_form')" >Save</a>
                  </div>
              </div>
            </div>
          </div><!-- /.box -->
        </div>
    </div>
  </div> 
<div class="col-md-3">
<div class="col-lg-2 col-fixed-right col-fixed-right-md oh well no-padding">
               
                <div class="pad">
                    <div id="ticket_intro_2" class="oh">
                        <div class="f14 b titleBeforeBreak">
                            Contact Info
                           <span class="p glyphicon glyphicon-edit r pull-right"  data-target="#modal-edit-customer-contact" id="modaal"  data-id="{{$ticket->id}}" data-toggle="modal" title="Change Contact"></span>
                        </div>
                        <div class="breakgreen"></div>
                        <div class="ticketEndUserInfo">
                            <table class="f14">
                                <tbody><tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user span-gray mr6"></span>
                                    </td>
                                    <td>
                                        <a  class="p block" >
                                            <div class="ticketCommentUsername">@if($ticket->customer_contact)
                                                          {{$ticket->customer_contact->f_name.' '.$ticket->customer_contact->l_name}}
                                                        @elseif($ticket->email)
                                                              {{ $ticket->email }}
                                                        @endif
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="margin: 0px;" class="ticketCommentHeader">
                                            <span title=" Customer" class="sprite-ranking "></span>
                                        </div>
                                    </td>
                                    <td>
                                        <a  class="p" >@if($ticket->customer)
                                                          {{$ticket->customer->name}}
                                                          @endif</a>
                                    </td>
                                </tr>
                               @if($ticket->customer_contact)
                                  @if($ticket->customer_contact->tittle)
                                  <tr>
                                      <td>
                                          <span class="glyphicon glyphicon-briefcase span-gray mr6"></span>
                                      </td>
                                      <td>
                                      {{$ticket->customer_contact->tittle}}
                                     
                                      </td>
                                  </tr>
                                   @endif

                                   @if($ticket->customer_contact->phone || $ticket->customer_contact->mobile)
                                  <tr>
                                      <td>
                                          <span class="glyphicon glyphicon-earphone span-gray mr6"></span>
                                      </td>
                                      <td> {{$ticket->customer_contact->phone}}
                                      </td>
                                  </tr>
                                   @endif

                                   @if($ticket->customer_contact->mobile)
                                  <tr>
                                      <td>
                                          <span class="glyphicon glyphicon-phone span-gray mr6"></span>
                                      </td>
                                      <td> {{$ticket->customer_contact->mobile}}
                                      </td>
                                  </tr>
                                   @endif

                                    @if($ticket->customer_contact->email)
                                  <tr>
                                      <td>
                                          <span class="glyphicon glyphicon-envelope span-gray mr6"></span>
                                      </td>
                                      <td>
                                          <a title="{{$ticket->customer_contact->email}}" class="ellipsis" style="display: block; width: 180px;" href="mailto:{{$ticket->customer_contact->email}}">{{$ticket->customer_contact->email}}</a>
                                      </td>
                                  </tr>
                                   @endif
                                @endif
                                <!-- ngIf: ticketrating != null -->
                            </tbody></table>
                        </div>

                        <div class="t10 b20">
                        </div>
                    </div>

                    <div class="f14 b titleBeforeBreak">Ticket Properties</div>
                    <div class="breakgreen"></div>
                     {{--  {!! Form::open(array('route' => array('admin.crm.ajax.ticket_priority_status'), 'method' => 'post')) !!} --}}
                    <div id="ticketobjcustomfields" class="top-10px">
                      <div class="col-md-12 form-group">
                        
                         <label class="f12">Ticket Status</label>
                         &nbsp;&nbsp;
                         <a href="#"  id="ticket_status" data-type="select2">{{$ticket->status->title}}</a>

                      </div>
                       <br>
                        <hr>
                      <div class="col-md-12 form-group">
                        
                         <label class="f12">Ticket Priority</label>
                         &nbsp;&nbsp;
                        
                         <a href="#"  id="ticket_priority" data-type="select2">{{$ticket->priority}}</a>
                      </div>

                        <hr>
                       
                        <div class="clearfix"></div>
                    </div>{{-- 
                     {!! Form::close() !!} --}}
                </div>
            </div>
</div>
  <div class="col-md-3" style="display: none;">
    <div id="msg_info"></div>
              
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Info</h3>
         <button type="button" class="btn btn-danger btn-sm pull-right"
                                  data-toggle="modal" data-id="{{$ticket->id}}" id="modaal" data-target="#modal-delete-ticket">
                                    <i class="fa fa-times-circle"></i>
                                    Delete ticket
                                </button>
      </div><!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-hover table-bordered">
          <tr>
            <th>Subject</th>
            <th>Customer Info</th>
            <th>Assigned Users</th>
            
           
          </tr>
          <tr>
          <td>
           
          </td>
            <td>
              <div id="customer_info" class="pull-left"> 
                <p class="btn bg-gray-active  btn-sm">
                
                  <span>@if($ticket->customer_contact)
                          <i class="fa fa-user"></i> {{$ticket->customer_contact->f_name.' '.$ticket->customer_contact->l_name}}
                        @elseif($ticket->email)
                             <i class="fa fa-envelope"></i> {{ $ticket->email }}
                        @endif
                  </span>
                  <a class="btn btn-xs" href="javascript:;" data-target="#modal-delete-assign-customer" id="modaal"  data-tid="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-times"></i></a>
                </p>  
                  @if($ticket->location)
                   <button type="button" class="btn bg-gray-active  btn-sm">
                    <i class="fa fa-map-marker"></i> 
                      <span>{{ $ticket->location->location_name }}</span>
                  </button>
                  @endif
                  @if($ticket->service_item)
                   <button type="button" class="btn bg-gray-active  btn-sm">
                    <i class="fa  fa-gears"></i> 
                      <span>{{ $ticket->service_item->title }}</span>
                  </button>
                 @endif
              </div>
                <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-customer-contact" id="modaal" data-id="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
            </td>
            <td>
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
              <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-assign-users" id="modaal" data-id="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
            </td>
          

          
          </tr>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
  </div> 

    
</section>
@include('crm::ticket.delete_modal')
@include('crm::ticket.show.edit_assigned_users_modal')
@include('crm::ticket.show.delete_modal_assign_user')
@include('crm::ticket.show.delete_modal_assign_customer')
@include('crm::ticket.show.edit_customer_info_modal')
{{-- @include('crm::ticket.show.edit_priority_status_modal') --}}

@include('crm::ticket.show.edit_assigned_customer_contact_modal') 
@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
{{-- <script src="/ckeditor/ckeditor.js"></script>
<script src="/ckeditor/config.js"></script>  --}}
<script src="/fancybox/jquery.fancybox.js?v=2.1.5"></script> 
<script src="/js/select2.full.min.js"></script>
<script src="/js/magicsuggest.js"></script>
<script src="/js/bootstrap-editable.min.js"></script>

<script src="/vendor/summernote/summernote.js"></script>
<script src="/vendor/summernote/summernote-floats-bs.min.js"></script>
  <script>
  $(document).ready(function() 
    {

      $('#response').summernote({ lang: 'en-US',
           callbacks: {
      onImageUpload: function(files) {
        //console.log(files);
        // console.log($editable);
      uploadImage(files[0],'ticket','response');
    }
                },
    dialogsInBody: true,
    height: 600,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});

    $('#note').summernote({ 
       callbacks: {
      onImageUpload: function(files) {
        //console.log(files);
        // console.log($editable);
      uploadImage(files[0],'ticket','note');
    }
                },
    lang: 'en-US',
    dialogsInBody: true,
    height: 600,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});


 /*   CKEDITOR.replace( 'response', {
              filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
              filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
              height: '40em'
          } );
    CKEDITOR.replace( 'note', {
              filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
              filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
              height: '40em'
          } );*/

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

    $('.multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            buttonWidth: '100%'
            
        });


    $(".select2").select2({
          tags: true
        });
$(".single").select2();

var statusData = [];
var item;

<?php foreach ($statuses as $status) {
  ?>

item = {id:"<?php echo $status->id; ?>",text : "<?php echo $status->text; ?>"};

statusData.push(item);

  <?php 
} ?>

       $('#ticket_status').editable({
          pk:{{$ticket->id}},
          inputclass:'col-md-12',
          mode:'inline',
          value:{{$ticket->ticket_status_id}},
          url: '{{URL::route('admin.crm.ajax.ticket_priority_status')}}',
          source: statusData,
            select2: {
               multiple: false
            }
        });

      var priority_data = [{id:'low',text:'Low'},
                            {id:'normal',text:'Normal'},
                            {id:'high',text:'High'},
                            {id:'urgent',text:'Urgent'}];

       $('#ticket_priority').editable({
          pk:{{$ticket->id}},
          inputclass:'col-md-12',
          mode:'inline',
          value: '{{$ticket->priority}}',
          url: '{{URL::route('admin.crm.ajax.ticket_priority_status')}}',
          source: priority_data,
            select2: {
               multiple: false
            }
        });

       $('.timeline ').find('img').addClass('img-responsive');
    } );





function mark_duplicate()
{
   add_func('note');

  $('#duplicate').show();
}
    function add_func(response_type)
    {
      $("html, body").animate({ scrollTop: $(document).height() }, 1000);
      

      if(response_type =='reply')
      {
        $('#add_btn').html('Reply');
        $('#response_div').find('h3.box-title').html('Add Reply');
        $('#response_div').show();
        $('#note_div').hide();
       
      }
      if(response_type =='note')
      {
         $('#add_btn').html('Note');
        $('#note_div').find('h3.box-title').html('Add Note');
         
        $('#note_div').show();
        $('#response_div').hide();

      }
       


    }

    function add_cc()
    {
      
     
     $('#cc').html($('#cc_select').html());
     $('#cc').show();
    }

    function add_bcc()
    {
      $('#bcc').html($('#bcc_select').html());
      $('#bcc').show();
      
    }
function send_mail()
{
      $.ajax({
        url: "{{ URL::route('send_mail')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        data: '',
        success: function(response){
         console.log(response);
      }
    });

}

  function addResponse(form_id)
  {
      /*for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();*/
$('#load_img_z').show();

    //{{URL::route('admin.ticket.add_response')}}
     $.ajax({
        url: "{{ URL::route('admin.ticket.add_response')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#'+form_id).serialize(),
        success: function(response){
         $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
        $('#msg').removeClass('alert-danger').addClass('alert-success').show(); 
        //location.reload(); 
        $('#time_line_ticket').html(response.html_content);
       
        //CKEDITOR.instances['note'].setData('');
         //CKEDITOR.instances['response'].setData('');
         $('#response').summernote('reset');
         $('#note').summernote('reset');
          $('.timeline ').find('img').addClass('img-responsive');
         $('#load_img_z').hide();
         alert_hide(); 
      }
    });

  }
  </script>
@endsection
@section('styles')
<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
 {{--  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"> --}}
  <link rel="stylesheet" href="/fancybox/jquery.fancybox.css?v=2.1.5">
  <link rel="stylesheet" href="/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5">
 <link rel="stylesheet" href="/css/select2.min.css">
  <link rel="stylesheet" href="/css/magicsuggest.css">

  <link rel="stylesheet" href="/css/bootstrap-editable.css">

   <link href="/vendor/summernote/summernote.css" rel="stylesheet">
  
<style>
.info>dd, .info>dt {
    line-height: 3;
}

.top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
        position: relative;
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
.btn.fancybox {
    color: #000;
    font-size: 30px;
    left: 50%;
    margin-left: -15px;
    margin-top: -15px;
    position: absolute;
    top: 50%;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc;
    border-color: #367fa9;
    color: #fff;
    padding: 1px 10px;
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
.btn-group{
  display: inline-block !important;
}

.TicketTitle {
    color: #8fbc24;
}
.b12 {
    margin-bottom: 12px;
}
.t12 {
    margin-top: 12px;
}
.f24 {
    font-size: 24px !important;
    line-height: 24px;
}
.titleBeforeBreak {
    margin-bottom: 6px;
}
.f14 {
    font-size: 14px !important;
    line-height: 14px;
}
.breakgreen {
    border-top: 1px solid #8fbb23;
    height: 0;
    width: 100%;
}

.ticketEndUserInfo {
    margin: 14px 0;
    overflow: hidden;
    position: relative;
}
.ticketEndUserInfo * {
    line-height: 20px;
}
.mr6 {
    margin-right: 6px;
}
.b {
    font-weight: bold;
}
.f12 {
    font-size: 12px !important;
    line-height: 12px;
}
.r{
  cursor:pointer;
}

</style>
@endsection
