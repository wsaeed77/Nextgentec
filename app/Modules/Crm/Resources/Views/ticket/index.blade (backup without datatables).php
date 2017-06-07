@extends('admin.main')
@section('content')

 <section class="content-header">
    <h1>
         Tickets
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Tickets
        </li>
    </ol>
</section>
 
<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="msg"></div>
               <a href=" {{ URL::route('admin.ticket.create')}}" class="btn btn-primary pull-right"> Create New Ticket</a>
             
               <a href="javascript:;"  onclick="import_emails()"  class="btn btn-primary pull-left"> <i class="fa fa-download"></i> Import Emails</a>
               <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" />
              
               <div class="clearfix"></div>
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tickets listing</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Created By</th>
                      <th>Customer info</th>
                      <th>Created on</th>
                      <th>Status</th>
                      <th>Assigned to</th>

                      <th>Priority</th>
                      <th>Actions</th>
                    </tr>

                    @foreach($tickets as $ticket)
                            
                        <tr>
                         <td>{{ $ticket->id }}.</td>
                            <td>{{ $ticket->title }}</td>
                           <td>@if($ticket->entered_by){{ $ticket->entered_by->f_name }}
                              @elseif($ticket->type =='email')  <button type="button" class="btn bg-gray-active  btn-sm">
                                
                                    <span>{{'system'}}</span>
                                    </button>
                              @endif</td> 
                            <td>
                            
                                <button type="button" class="btn bg-gray-active  btn-sm">
                                
                                    <span>

                                    @if($ticket->customer)
                                    <i class="fa fa-user"></i> {{ $ticket->customer->name }}
                                    @elseif($ticket->email)
                                     <i class="fa fa-envelope"></i> {{ $ticket->email }}@endif</span>
                                </button>  
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
                             
                            </td>
                            <td>{{ date('d/m/Y',strtotime($ticket->created_at)) }}</td>

                              <td><button type="button" class="btn bg-gray-active  btn-sm">
                                 
                                    <span>{{$ticket->status}}</span>
                                </button>
                              </td>
                              <td> 

                              @if($ticket->assigned)
                               @foreach($ticket->assigned_to as $employee)
                               <button type="button" class="btn bg-gray-active  btn-sm">
                                  
                                      <i class="fa fa-user"></i>  
                                      <span>{{ $employee->f_name }}</span>
                                  </button>
                                  @endforeach
                               @endif
                              </td>

                              <?php 
                                    //$btn_class =  '';
                                    //if($ticket->priority == 'low')
                                      $btn_class = 'bg-gray';
                                    if($ticket->priority == 'normal')
                                      $btn_class = 'bg-blue';
                                    if($ticket->priority == 'high')
                                      $btn_class = 'bg-green';
                                    if($ticket->priority == 'urgent')
                                    $btn_class = 'bg-yellow';
                                  if($ticket->priority == 'critical')
                                    $btn_class = 'bg-red';

                              ?>

                              <td><button type="button" class="btn {{$btn_class}}  btn-sm">
                                 
                                    <span>{{$ticket->priority}}</span>
                                </button>
                              </td>
                            <td>
                            
                            <a href="{{ URL::route('admin.ticket.show',$ticket->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                            
                             
                             <button type="button" class="btn btn-danger btn-sm"
                                  data-toggle="modal" data-id="{{$ticket->id}}" id="modaal" data-target="#modal-delete-ticket">
                                    <i class="fa fa-times-circle"></i>
                                    Delete
                                </button>
                               
                            
                            </td>
                        </tr>
                    @endforeach
                   {{--  <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="label label-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr> --}}
                   
                  </table>
                   <div class="col-xs-12">
                    {!! $tickets->render() !!}
                    </div>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
</section>

 @include('crm::ticket.delete_modal')
@endsection
@section('script')
  <script>
     function import_emails()
    {
      //console.log(id);
      $('#load_img_z').show();
       $.get(APP_URL+'/admin/crm/ticket/getEmails',function( response ) {
              //console.log(response);
              if(response.success)
              {
                $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
                $('#load_img_z').hide();
              }

              if(response.error)
              {
                $('#msg').html('<div  class="alert alert-danger"><ul><li>'+response.error_msg+'</li></ul></div>');
                $('#load_img_z').hide();
              }
                //$('#service_items_table').html(response.html_contents);
                },"json" 
            );
       
       alert_hide();
      //setTimeout("location.reload(true);",10000);
    }
    $(function () {

      $('.pagination').addClass('pull-right');
    }); 

  </script>
@endsection