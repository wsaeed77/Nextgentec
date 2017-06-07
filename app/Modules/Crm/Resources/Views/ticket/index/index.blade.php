@extends('admin.main')
@section('content')

@section('content_header')
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
@endsection

<section class="content">
        <div class="row">
          <div class="col-md-9">
                <div class="table-responsive">
                <div id="msg_info"></div>
                  <table cellspacing="0" class="ticketsList table-full">
                        <!-- ngIf: tickets.length > 0 -->
                        <thead  class="hidden-xs">
                            <tr>
                                <td style="height: 45px; padding: 5px;" class="hidden-xs" colspan="3">
                                    <div class="abs">
                                        <button  title="Select All" class="btn btn-default" id="select_all">
                                            <span class="fa fa-fw p fa-square-o"></span>
                                        </button>
                                        <div title="Delete Tickets" class="ib">
                                            <button class="btn btn-default" disabled="disabled" onclick="multi_delete()">
                                                <span class="fa fa-fw fa-trash-o"></span>
                                            </button>
                                        </div>
                                        <div title="Assign Tickets" class="ib">
                                            <button class="btn btn-default" disabled="disabled"  onclick="multi_assign()">
                                                <span class="fa fa-fw fa-user"></span>
                                            </button>
                                        </div>
                                        <div title="Set Tickets Status" class="ib">
                                            <button class="btn btn-default" disabled="disabled" onclick="multi_status()">
                                                <span class="fa fa-fw fa-info"></span>
                                            </button>
                                        </div>
                                        <div title="Set Tickets Priority" class="ib">
                                            <button class="btn btn-default" disabled="disabled" onclick="multi_priority()">
                                                <span class="fa fa-fw fa-thumb-tack"></span>
                                            </button>
                                        </div>
                                        {{-- <div title="Merge Tickets" class="ib">
                                            <button class="btn btn-default" disabled="disabled">
                                                <i class="fa fa-object-group"></i>
                                            </button>
                                        </div> --}}
                                    </div>
                                </td>
                                 <td style="height: 45px; padding: 5px;" class="hidden-xs" colspan="2">
                                 <div class="form-group">
                                  {{-- <label class="col-lg-6"> Per Page:</label> --}}
                                   <?php  $per_page =[5=>5,
                                                      10=>10,
                                                      15 => 15,
                                                      20 => 20,
                                                      25 =>25,
                                                      30 => 30,
                                                      50 =>50,
                                                      100=>100]?>
                                    <div class="col-lg-12">
                                    {!! Form::select('per_page', $per_page, Session::get('arr_input.per_page'),['class'=>'form-control multiselect','placeholder' => 'Per Page','onchange'=>'per_page(this.value)'])!!}
                                    </div>
                                    </div>
                                 </td>
                            </tr>
                        </thead><!-- end ngIf: tickets.length > 0 -->
                        <tbody id="tbody">
                        @foreach($tickets as $ticket)
                            <tr class="ticket-item">
                                <td class="ticketList-a-long-side hidden-xs">
                                    <span  style="margin: 32px 10px;" id="{{$ticket->id}}" class="fa fa-fw p fa-square-o pull-left select_to"></span>
                                    <div class="ticketCustomerLogo">
                                      <img style="width: 74px;"  src="/images/nologo-128.jpg">
                                      <div title=" Customer" class="sprite-ranking " style="position: absolute; bottom: 2px; right: -8px; top: inherit;"></div>
                                    </div>
                                </td>
                                <td style="min-width: 260px !important; max-width: 100% !important;" class="ticketList-b-side">
                                    <div data-ticket-id="1" data-ticket-priority="1" class="ticketDetials" >

                                            <div style="display: inline-block;" class="f16 t10">
                                               <a class="change_title" data-pk="{{$ticket->id}}" data-value="{{$ticket->title}}"> <span class="ticketDetialsTitle l">{{$ticket->title}} </span></a>
                                                <span class="ticketDetialsNumber">#{{$ticket->id}}</span>
                                            </div>
                                        &nbsp;&nbsp;&nbsp;<a  class="btn btn-default" href="{{route('admin.ticket.show',$ticket->id)}}">Detail</a>
                                        <div class="f14 b t3" id="contact_ticket_{{$ticket->id}}">
                                           <div type="button" class="btn bg-gray-active  btn-sm"  >
                                              <span>

                                              @if($ticket->customer_contact)
                                              <a href="{{route('admin.crm.show',$ticket->customer->id)}}"><i class="fa fa-user"></i> {{$ticket->customer_contact->f_name.' '.$ticket->customer_contact->l_name}}</a> &nbsp;<a data-target="#modal-edit-customer-contact" id="modaal"  data-id="{{$ticket->id}}" data-toggle="modal"> <i class="fa fa-pencil"></i> </a>
                                              @elseif($ticket->email)
                                                <i class="fa fa-envelope"></i> {{$ticket->email}}
                                              @else
                                                <i class="fa fa-user"></i>&nbsp;
                                               @endif
                                          </span>
                                          </div>
                                          @if($ticket->customer_contact)
                                          @if($ticket->location)
                                            <button type="button" class="btn bg-gray-active  btn-sm">
                                            <i class="fa fa-map-marker"></i>
                                              <span>{{$ticket->location->location_name}}</span>
                                          </button>
                                          @endif
                                          @endif
                                         @if($ticket->service_item)
                                          <button type="button" class="btn bg-gray-active  btn-sm">
                                            <i class="fa  fa-gears"></i>
                                              <span>{{$ticket->service_item->title}}</span>
                                          </button>
                                          @endif
                                        </div>
                                        <div class="f12 t5 b5">
                                            <span class="ticketactivityLabel ticketactivityLabelBlue" >
                                              @if($ticket->created_by!=0)
                                                System
                                              @else
                                                Email
                                              @endif
                                            </span>
                                            <?php
                                               $field1 = \Carbon\Carbon::now();
                                                $field2 = \Carbon\Carbon::parse($ticket->created_at);

                                                $difference =  $field2->diffForHumans($field1);
                                            ?>
                                            <span class="ticketactivityTime">Created  {{$difference}} </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="ticketList-c-side visible-xl visible-xl-tablecell ">
                                   {{--  <div class="ng-hide">
                                        <div style="width: 100%; margin: 40% auto; opacity: 0.5;" class="progress progress-striped sm">
                                            <div style="width: 100%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" role="progressbar" class="progress-bar progress-bar-white active">
                                                <span class="sr-only">100% Complete</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div>

                                        <div>
                                            <div class="ticketSLA ticketSLAUnknown">
                                                No SLA
                                                <div class="ticketSLAProgress t6"></div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </td>
                                <td class="ticketList-d-side visible-xl visible-xl-tablecell ">
                                    <div class="ticketSource">
                                        <div class="sprite-tsource-phone"></div>
                                    </div>
                                </td>
                                <td class="ticketList-e-side hidden-xs" id="status_user_{{$ticket->id}}">
                                    <div class="ticketInformation f14">
                                      @if(count($ticket->assigned_to)>0)

                                        @foreach($ticket->assigned_to as $assigned_to)

                                          <div class="ticketInformationItem">
                                              <div title="Technician" class="l ticketInformationKeyShort text-center">
                                                  <span class="fa fa-user"></span>
                                              </div>
                                             <a  href="javascript:;" data-target="#modal-edit-assign-users" id="modaal"  data-id="{{$ticket->id}}" data-toggle="modal"   class="p l ticketInformationVal ellipsis span-black btn-link">
                                                {{$assigned_to->f_name.' '.$assigned_to->l_name}}
                                                </a>
                                          </div>
                                          @endforeach
                                        @else
                                           <div class="ticketInformationItem">
                                              <div title="Technician" class="l ticketInformationKeyShort text-center">
                                                  <span class="fa fa-user"></span>
                                              </div>
                                             <a href="javascript:;" data-target="#modal-edit-assign-users" id="modaal"  data-id="{{$ticket->id}}" data-toggle="modal"  class="p l ticketInformationVal ellipsis span-black btn-link">
                                               Unassigned
                                                </a>
                                          </div>

                                        @endif


                                        <div class="ticketInformationItem">
                                            <div title="Status" class="l ticketInformationKeyShort text-center">
                                                <span class="fa fa-info"></span>
                                            </div>
                                            <a href="javascript:;" data-target="#modal-edit-priority-status" id="modaal"  data-id="{{$ticket->id}}" data-toggle="modal" class="p l ticketInformationVal ellipsis span-black btn-link">{{$ticket->status->title}}</a>
                                        </div>
                                        <div class="ticketInformationItem">
                                            <div title="Priority" class="l ticketInformationKeyShort text-center">
                                                <span class="fa fa-thumb-tack"></span>
                                            </div>
                                            <div href="javascript:;" data-target="#modal-edit-priority-status" id="modaal"  data-id="{{$ticket->id}}" data-toggle="modal" class="p l ticketInformationVal ellipsis span-black btn-link">{{$ticket->priority}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                     {!! $tickets->render() !!}
              </div>



            </div>

              <div class="col-md-3" style="padding-bottom: 20px;">
                <a href=" {{ URL::route('admin.ticket.create')}}" class="btn btn-primary pull-right">New Ticket</a>
                <a href="javascript:;" onclick="import_emails()"  class="btn btn-primary pull-left"> <i class="fa fa-download"></i> Import Emails</a>
                <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" />
              </div>


            <div class="col-md-3">


              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Filter</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
               {!! Form::open(array('route' => 'admin.ticket.index_post', 'method' => 'post', 'id'=>'filter_form')) !!}

                <input type="hidden" name="filter" value="yes" id="filter_flag" >

                 <input type="hidden" name="per_page" value="{{Session::get('arr_input.per_page')}}" id="per_page" >
                  <strong><i class="fa fa-user margin-r-5"></i>  Customer</strong>
                    {!! Form::select('customer', $customers, Session::get('arr_input.customer'),['class'=>'form-control multiselect','placeholder' => 'Pick a Customer'])!!}
                   <hr>

                    <strong><i class="fa fa-sort margin-r-5"></i>  Sort</strong>
                    <?php  $sort=['created_at_asc'=>'Created date Asc',
                                  'created_at_desc'=>'Created date Desc',
                                  'updated_at'    => 'Last Modified',
                                  'priority' => 'Priority']?>
                    {!! Form::select('sort', $sort, Session::get('arr_input.sort'),['class'=>'form-control multiselect','placeholder' => 'Sort by'])!!}
                   <hr>

                   <strong><i class="fa fa-user margin-r-5"></i>  Assigned To</strong>
                    {!! Form::select('assigned_to', $users, Session::get('arr_input.assigned_to'),['class'=>'form-control multiselect','placeholder' => 'Pick an Assignee'])!!}
                   <hr>

                  {{-- {{dd(Session::get('arr_input.priority.low'))}} --}}
                   <strong><i class="fa fa-user margin-r-5"></i>  Priority</strong>
                   <div class="form-group">
                    <label class="col-lg-6 b5 t5">
                      <input type="checkbox" name="priority[low]" @if(Session::get('arr_input.priority.low')) checked @endif class="minimal" >
                      Low
                    </label>
                    <label class="col-lg-6 b5 t5">
                      <input type="checkbox" name="priority[high]" @if(Session::get('arr_input.priority.high')) checked @endif class="minimal" >
                      High
                    </label>

                    <label class="col-lg-6 b5 t5">
                      <input type="checkbox" name="priority[normal]" @if(Session::get('arr_input.priority.normal')) checked @endif class="minimal" >
                      Normal
                    </label>
                    <label class="col-lg-6 b5 t5">
                      <input type="checkbox" name="priority[critical]" @if(Session::get('arr_input.priority.critical')) checked @endif class="minimal" >
                      Critical
                    </label>

                     <label class="col-lg-6 b5 t5">
                      <input type="checkbox" name="priority[urgent]" @if(Session::get('arr_input.priority.urgent')) checked @endif class="minimal" >
                      Urgent
                    </label>

                  </div>
                   <div class="clearfix"></div>
                   <hr>

                  <button class="btn btn-primary col-lg-5" id="go"><b>Go</b></button>
                  <a class="btn btn-default col-lg-5 pull-right" href="javascript:void(0)" onclick="clear_filter()"><b>Clear</b></a>
                  {!! Form::close() !!}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
</section>

 @include('crm::ticket.delete_modal')

@include('crm::ticket.index.edit_assigned_users_modal')
@include('crm::ticket.index.multi_assign_users_modal')
@include('crm::ticket.index.multi_status_modal')

@include('crm::ticket.index.multi_priority_modal')

@include('crm::ticket.index.edit_priority_status_modal')

@include('crm::ticket.index.edit_assigned_customer_contact_modal')
@endsection
@section('script')
<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->

 
 <script src="{{URL::asset('iCheck/icheck.min.js')}}"></script>
  <script src="{{URL::asset('js/bootstrap-dialog.min.js')}}"></script>
  <script src="{{URL::asset('js/magicsuggest.js')}}"></script>
  <script src="{{URL::asset('js/bootstrap-editable.min.js')}}"></script>
  <script>

  function multi_delete()
  {
      //$('#tbody').find('.select_to')
      var ids =[];
      $('#tbody').find('.fa-check-square-o').each(function(index, el) {
        //console.log(el);
        //console.log($(el).attr('id'));

        ids.push($(el).attr('id'));


      });
//var flg = '';
      BootstrapDialog.show({
            title: 'Delete Record',
            message: 'Are you sure to delete the record?',
            buttons: [{
                label: 'Yes',
                action: function(dialog) {
                    //dialog.setTitle('Title 1');

                    if(ids.length>0)
                    {
                      //console.log('hhh');
                     $.ajax({
                        url: "{{ URL::route('admin.crm.ajax.ticket_multi_delete')}}",
                        //headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        dataType: 'json',
                        data:'ids='+ids ,
                        success: function(response){
                         // console.log(response);
                         if(response=='yes')
                          location.reload();
                        }

                      });
                   }
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

  function multi_assign()
  {
    var ids =[];
      $('#tbody').find('.fa-check-square-o').each(function(index, el) {
        //console.log(el);
        //console.log($(el).attr('id'));

        ids.push($(el).attr('id'));


      });
      $('#modal-multi-assign-users').modal('show');
      $('#muti_tickets_id').val(ids);

  }

  function multi_status()
  {
    var ids =[];
      $('#tbody').find('.fa-check-square-o').each(function(index, el) {
        //console.log(el);
        //console.log($(el).attr('id'));

        ids.push($(el).attr('id'));


      });
      $('#modal-multi-status').modal('show');
      $('#multi_status_ids').val(ids);

  }
function multi_priority()
  {
    var ids =[];
      $('#tbody').find('.fa-check-square-o').each(function(index, el) {
        //console.log(el);
        //console.log($(el).attr('id'));

        ids.push($(el).attr('id'));


      });
      $('#modal-multi-priority').modal('show');
      $('#multi_priority_ids').val(ids);

  }

  function clear_filter()
  {  //console.log('lll');
     $('#filter_flag').val('clear');
     //$('#form_filter').submit();

     $( "#go" ).trigger( "click" );
  }

  function per_page(perpage)
  {

    $('#per_page').val(perpage);
    $( "#go" ).trigger( "click" );

  }
     function import_emails()
    {
      //console.log(id);
      $('#load_img_z').show();

       $.get(APP_URL+'/admin/crm/ticket/getEmails',function( response ) {
              //console.log(response);
              if(response.success)
              {
                $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
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

function redirect_detailpage(url)
{
  console.log(url);
}
    $(function () {



      $('#select_all').on('click', function(event) {
        if( $(this).children('span').hasClass('fa-square-o'))
        {
            $(this).children('span').removeClass('fa-square-o').addClass('fa-check-square-o');

              $('.abs').find('.ib').children('button').prop('disabled',false);

              $('#tbody').find('.select_to').removeClass('fa-square-o').addClass('fa-check-square-o');

            return true;
        }

         if( $(this).children('span').hasClass('fa-check-square-o'))
        {
            $(this).children('span').removeClass('fa-check-square-o').addClass('fa-square-o');

            $('.abs').find('.ib').children('button').prop('disabled',true);

            $('#tbody').find('.select_to').removeClass('fa-check-square-o').addClass('fa-square-o');;
             return true;
        }

        /* Act on the event */
      });


       $('.select_to').on('click', function()
       {
              if( $(this).hasClass('fa-square-o'))
              {
                  $(this).removeClass('fa-square-o').addClass('fa-check-square-o');


                    $('.abs').find('.ib').children('button').prop('disabled',false);

                  return true;
              }

               if( $(this).hasClass('fa-check-square-o'))
              {
                 $(this).removeClass('fa-check-square-o').addClass('fa-square-o');

                 if(!$('#tbody').find('.select_to').hasClass('fa-check-square-o'))
                 {
                  $('#select_all').children('span').removeClass('fa-check-square-o').addClass('fa-square-o');
                  $('.abs').find('.ib').children('button').prop('disabled',true);
                }
                 return true;
              }
        });


      $('.pagination').addClass('pull-right');

      

       $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });

        $('.change_title').editable({
          inputclass:'col-md-12',
          name:'change_title',
          mode:'inline',
          url: '{{URL::route('admin.crm.ajax.update_title')}}'
        });

    });

  </script>
@endsection
@section('styles')
  <!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
   <link rel="stylesheet" href="{{URL::asset('css/ticket/ticketsstyle.css')}}">
   <link rel="stylesheet" href="{{URL::asset('css/ticket/main.css')}}">
   <link href="{{URL::asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{URL::asset('iCheck/all.css')}}">
     <link rel="stylesheet" href="{{URL::asset('css/bootstrap-dialog.min.css')}}">
     <link rel="stylesheet" href="{{URL::asset('css/magicsuggest.css')}}">
      <link rel="stylesheet" href="{{URL::asset('css/bootstrap-editable.css')}}">
 <style>
 .bot_10px{
        margin-bottom: 10px;
    }
.sprite-tsource-phone {
    background-position: -42px 0;
    height: 60px;
    width: 18px;
}

.ticketDetials {
    padding-left: 10px;
}
.ticket-item {
    border: 1px solid #d1d2d4;
}
.t5{
  margin-top:5px;
}
.b5{
  margin-bottom:5px;
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
