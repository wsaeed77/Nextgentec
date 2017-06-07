@extends('admin.main')

@section('content_header')
<h1>
         Add Vendor
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
         <li >
           <a href="{{ URL::route('admin.vendors.index')}}"> <i class="fa fa-table"></i> Vendors</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Add Vendor
        </li>
    </ol>
@endsection
@section('content')



<section class="content">
    <div class="row">

        <div class="col-xs-12">

             <div id="err_msgs"></div>
            <!-- Custom Tabs -->
           
                  <form class="form-horizontal" id="appointment_form">
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="visit_location" class="col-sm-3 control-label">Location</label>
                          <div class="col-sm-9">
                            {!! Form::select('location_index', array(),'',['class'=>'form-control select2','id'=>'visit_location', 'style'=>'width:100%;'])!!}
                          </div>
                          <input type="hidden" name="google_event_id" value="{{$id}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="visit_employee" class="col-sm-3 control-label">Technician</label>
                          <div class="col-sm-9">
                            {!! Form::select('employee_index', array(),'',['class'=>'form-control select2','id'=>'visit_employee', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="visit_contact" class="col-sm-3 control-label">Contact</label>
                          <div class="col-sm-9">
                            {!! Form::select('contact_index', array(),'',['class'=>'form-control select2','id'=>'visit_contact', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="timeframe" class="col-sm-3 control-label">Punctuality</label>
                          <div class="col-sm-9">
                            {!! Form::select('timeframe', array(),'',['class'=>'form-control select2','id'=>'timeframe', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="eventTitle" class="col-sm-3 control-label">Title</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="appointment_title" type="text" placeholder="" id="eventTitle">
                          </div>
                        </div>
                       
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="appointment_against" class="col-sm-3 control-label">Against</label>
                          <div class="col-sm-9">
                            {!! Form::select('appointment_against', array(),'',['class'=>'form-control select2','id'=>'appointment_against', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top: 5px;">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="eventNotes" class="col-sm-1 control-label">Notes</label>
                          <div class="col-sm-11">
                            <textarea class="form-control" name="notes" rows="3" id="eventNotes" placeholder="" style="height: 100px;"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                       
                          <div class="box box-default">
                            <div class="box-body no-padding">
                              <!-- THE CALENDAR -->
                              <div id="edit_calendar"></div>
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /. box -->
                      
                      </div>
                    </div>
                     <div class="col-lg-4 pull-right">
                          <button type="button" class="btn btn-default pull-left close_modal_activity"  data-dismiss="modal">Cancel</button>
                          <a  class="btn btn-primary pull-right" id="appointment_update">Save</a>
                      </div>
                  </form>
                  <div class="clearfix"></div>

              
             
          
          </div>
    </div>
</section>
@endsection

@section('script')
@parent
<script type="text/javascript" src="/js/calendar.js"></script>
{{-- <script src="/ckeditor/ckeditor.js"></script>
<script src="/ckeditor/config.js"></script> --}}
<script src="/js/select2.full.min.js"></script>

<script src="/js/jquery.autogrow-textarea.js"></script>



<script type="text/javascript">
var calander_data = [];

var date = new Date();
      //var date2 = new Date ();

      var appointmentEvent;
      var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear();

$(document).ready(function()
{



    $(".select2").select2({
          tags: true
        });







    $("#eventNotes").autogrow();

    function formatRepoSelection (repo) {
      return repo.full_name || repo.text;
    }

    // Populate the locations select box
    $.get('/admin/crm/ajax_get_select_locations/{{$cust_id}}',function( data_response ) {
      $("#visit_location").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      });
      $("#visit_location").val('').change();

    
    },"json");

    // Populate the service items (Against) select box
    $.get('/admin/crm/ticket/ajax_get_select_service_items/{{$cust_id}}',function( data_response ) {
    

      $("#appointment_against").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
      $("#appointment_against").val('').change();
    },"json");

    // Populate the contacts select box
    $.get('/admin/crm/ajax_get_select_contacts/{{$cust_id}}',function( data_response ) {
      $("#visit_contact").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
      $("#visit_contact").val('').change();

    },"json");

    // Populate the technician select box
    $.get('/admin/crm/ajax_get_select_techs',function( data_response ) {
      $("#visit_employee").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
      $("#visit_employee").val('{{Auth::user()['id']}}').change();


    },"json");

  

    // Populate the timeframe select box
    $("#timeframe").select2({
      data: [
        { id: 0, text: 'As scheduled' },
        { id: 1, text: '1 Hour Window' },
        { id: 2, text: '2 Hour Window' },
        { id: 3, text: '3 Hour Window' },
        { id: 4, text: 'Same Day' },
        { id: 5, text: 'Tentative' }
      ],
      minimumResultsForSearch: Infinity,
      placeholder: "",
      allowClear: true
    });
    $("#timeframe").val('').change();

   
var eve_date;


    $.get('/admin/crm/appointment/get_appointment_by_id/{{$id}}',function( response ) {

   
      $("#visit_location").val(response.customer_location_id).change();
      $('#visit_employee').val(response.technician_id).change();
      $('#visit_contact').val(response.customer_location_contact_id).change();

      $('#timeframe').val(response.panctuality).change();
      $('#appointment_against').val(response.customer_service_item_id).change();
      $('#eventTitle').val(response.title);
      $('#eventNotes').val(response.notes);

      eve_date = response.event_date;
     /* $('#edit_calendar').fullCalendar('render');*/
    // var eve = ['title']

     $('#edit_calendar').fullCalendar({
         defaultView: 'agendaWeek',
         height: 400,
         editable: true,
         droppable: true, // this allows things to be dropped onto the calendar !!!
         allDaySlot: false,        
        defaultDate:eve_date,
         scrollTime: moment.duration('09:00:00'),
              minTime: moment.duration('06:00:00'),
              businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                dow: [ 1, 2, 3, 4, 5 ], // Monday - Fri
                start: '9:00', // a start time (10am in this example)
                end: '17:00', // an end time (6pm in this example)
              },
          eventSources: [{
                url: '{{ URL::route('admin.crm.appointment.get_event_by_id',$id)}}', // use the `url` property
               // color: 'yellow',    // an option!
               //textColor: 'black',  // an option!
                editable:true
              }],
          dayClick: function(date, jsEvent, view) {

          var duration = Number($('#timeframe').val());

           // var sign = ' &#177;'+duration;
           var m = moment(date.format()).add(duration,'hours');
           if(duration==4 || duration==5 || duration==0)
           {
             m = moment(date.format()).add(2,'hours');
           
           }

           var end_ = moment(m).format('YYYY-MM-DD HH:mm:ss');

          /*if (typeof appointmentEvent == "undefined") {
           //console.log('fff');
            //console.log(new Date(new Date().setHours(new Date().getHours()+1)));
            calander_data[0] = date.format();
             calander_data[1] = end_;
            appointmentEvent = $('#edit_calendar').fullCalendar('renderEvent',
              {
                title: $('#eventTitle').val(),
                start: date.format(),
                end: end_,
                
              },
                true // make the event "stick"
            );
          } else {*/
            //console.log('h2');
            // Event exists, let's move it
           calander_data[0] = date.format();
           calander_data[1] = end_;

            appointmentEvent[0].start = date.format();
            appointmentEvent[0].end = end_;
            appointmentEvent[0].title = $('#eventTitle').val();
            $('#edit_calendar').fullCalendar('updateEvent', appointmentEvent[0]);
          //}
        },
        eventResize: function( event, delta, revertFunc, jsEvent, ui, view)  {
         
          calander_data[0] = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
             calander_data[1] = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
       
        },
         eventDrop: function( event, delta, revertFunc, jsEvent, ui, view)  {
         
          calander_data[0] = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
             calander_data[1] = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
       
        },
         eventRender: function(event, element) {
          //console.log(event.start);
              calander_data[0] = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
              calander_data[1] = moment(event.end).format('YYYY-MM-DD HH:mm:ss');

             
          }
             // events:[]
      });

      


      

    },'json');
jQuery.ajaxSetup({async:false});

/*$('#edit_calendar').fullCalendar({
        // header: {
        //   left: 'today',
        //   right: 'prev,next'
        // },
        buttonText: {
          today: 'today',
          month: 'month',
          week: 'week',
          day: 'day'
        },
        scrollTime: moment.duration('09:00:00'),
        minTime: moment.duration('06:00:00'),
        businessHours: {
          // days of week. an array of zero-based day of week integers (0=Sunday)
          dow: [ 1, 2, 3, 4, 5 ], // Monday - Fri
          start: '9:00', // a start time (10am in this example)
          end: '17:00', // an end time (6pm in this example)
        },
        eventSources: [{
          url: '{{ URL::route('admin.crm.calendar.eventlist')}}', // use the `url` property
          color: 'yellow',    // an option!
          textColor: 'black',  // an option!
          editable:true
        }],
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        defaultView: 'agendaWeek',
        allDaySlot: false,
        height: 400,
        //defaultTimedEventDuration: '01:00:00',
        //hiddenDays: [0,6],

        dayClick: function(date, jsEvent, view) {

          var duration = Number($('#timeframe').val());

           // var sign = ' &#177;'+duration;
           var m = moment(date.format()).add(duration,'hours');
           if(duration==4 || duration==5 || duration==0)
           {
             m = moment(date.format()).add(2,'hours');
           
           }

           var end_ = moment(m).format('YYYY-MM-DD hh:mm:ss');

          if (typeof appointmentEvent == "undefined") {
           //console.log('fff');
            //console.log(new Date(new Date().setHours(new Date().getHours()+1)));
            calander_data[0] = date.format();
             calander_data[1] = end_;
            appointmentEvent = $('#edit_calendar').fullCalendar('renderEvent',
              {
                title: $('#eventTitle').val(),
                start: date.format(),
                end: end_,
                
              },
                true // make the event "stick"
            );
          } else {
            //console.log('h2');
            // Event exists, let's move it
           calander_data[0] = date.format();
           calander_data[1] = end_;

            appointmentEvent[0].start = date.format();
            appointmentEvent[0].end = end_;
            appointmentEvent[0].title = $('#eventTitle').val();
            $('#edit_calendar').fullCalendar('updateEvent', appointmentEvent[0]);
          }
        },
        eventResize: function( event, delta, revertFunc, jsEvent, ui, view)  {
         
          calander_data[0] = moment(event.start).format('YYYY-MM-DD hh:mm:ss');
             calander_data[1] = moment(event.end).format('YYYY-MM-DD hh:mm:ss');
       
        }
      });*/




   
    $( "#appointment_update" ).click(function() {
        $("#appointment_update").html('Sending data...');
      $.ajax({
        url: "{{ URL::route('admin.crm.appointment.update')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#appointment_form').serialize()+'&calander_data='+calander_data+'&google_event_id={{$id}}',
        success: function(response){
          if(response.success=='yes'){
            $("#appointment_update").html('Success');
            $("#appointment_update").toggleClass('btn-success btn-primary');
            setTimeout(
              function()
              {
                $( ".close_modal_activity" ).trigger( "click" );
              }, 1200);
          }
        },
        error: function(data) {
          console.log('fail');
        }
      });
    });
    


   

       /*-----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      



      $( "#eventTitle" ).keyup(function() {

        if (typeof appointmentEvent != "undefined") {
          appointmentEvent[0].title = $('#eventTitle').val();

          $('#edit_calendar').fullCalendar('updateEvent', appointmentEvent[0]);
        }
      });



   

      /*
       * End Calendar Element
       */
  });






      
</script>
@endsection
@section('styles')
@parent
<link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">
<link href="{{URL::asset('css/fullcalendar.css')}}" rel="stylesheet" />


<style>
.fc-toolbar h2 {
  font-size: 1.1em;
  padding-top: 3px;
}
.box-body .fc {
  margin-top: 0px !important;
}
.fc-button {
  height: auto !important;
}

#checkboxes label {
  font-weight: 500;
  padding-top: 1px;
}

#checkboxes label .icheckbox_square-blue {
  margin-right: 8px;
  margin-left: 10px;
}

#checkboxes label:first-child .icheckbox_square-blue {
  margin-right: 8px;
  margin-left: 0px;
}

/*.cke_editor_create_note_body {
  border: none !important;
  background: none !important;
  padding: 0 !important;
}

.cke_top {
  background: none !important;
}

.cke_bottom {
  background: none !important;
}*/
</style>
@endsection
