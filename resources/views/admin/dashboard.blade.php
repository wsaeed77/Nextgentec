@extends('admin.main')

@section('content')

@section('content_header')
 <h1>
        Company Dashboard
       {{-- <small>preview of simple tables</small> --}}
   </h1>
   <ol class="breadcrumb">
       <li>
           <i class="fa fa-dashboard"></i>
       </li>
       <li class="active">
           <a href="/admin/dashboard">Dashboard</a>
       </li>
   </ol>
@endsection

<section class="content">
  <div class="row">
    <div class="col-md-5">

    </div>
    <div class="col-md-7">
      <div class="box box-default">
        <div class="box-body no-padding">
          <!-- THE CALENDAR -->
          <div id="calendar"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /. box -->
    </div>

  </div>
</section>


@endsection
@section('script')
<script type="text/javascript" src="/js/calendar.js"></script>
<script type="text/javascript">


function del_event(e_id,event)
{
  //console.log(e_id+'----'+c_id);
 var btn_txt = event.target;


  //console.log(window.event.srcElement.innerHTML);
    var r = confirm("Are you sure?");
    if(r == true)
    {

       
    btn_txt.innerHTML="Sending request...";
    btn_txt.classList.add('btn-success');
    btn_txt.classList.remove('btn-danger');
    $.ajax({
        url: "{{ URL::route('admin.crm.appointment.delete')}}",
        type: 'POST',
        dataType: 'json',
        data: 'event_id='+e_id,
        success: function(response){
          if(response.success=='yes'){
            
           location.reload();
          }
        },
        error: function(data) {
          console.log('fail');
        }
      });
  }
}


  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({
      header: {
				left: 'prev,next today',
				center: 'title',
				right: 'listDay,listWeek,month'
			},
      views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},

      // header: {
      //   left: 'today',
      //   right: 'prev,next'
      // },
      // buttonText: {
      //   today: 'today',
      //   month: 'month',
      //   week: 'week',
      //   day: 'day'
      // },
      scrollTime: moment.duration('08:00:00'),
      minTime: moment.duration('06:00:00'),
      // businessHours: {
      //   // days of week. an array of zero-based day of week integers (0=Sunday)
      //   dow: [ 1, 2, 3, 4, 5 ], // Monday - Fri
      //   start: '9:00', // a start time (10am in this example)
      //   end: '17:00', // an end time (6pm in this example)
      // },
      events:<?php if($events) echo $events;?>,
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      //defaultView: 'listWeek',
      //allDaySlot: false,
      height: 550,
      //hiddenDays: [0,6],
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }
//onclick="del_event('ff','hh')";
      },
      eventRender: function(e, elm) {
                //console.log(e);
                var btn_edit = '',btn_del="";


                 btn_del = '&nbsp; <a onclick="del_event(\''+e.id+'\',event)"  class="btn  btn-danger btn-sm pull-right"><i class="fa fa-pencil"></i> Delete</a><br/>';
                if(e.event_row!='')
                { 
                  btn_edit = ' <a href="/admin/crm/appointment/edit/'+e.id+'/'+e.event_row.customer_id+'" class="btn  btn-success btn-sm pull-left"><i class="fa fa-pencil"></i> Edit</a>';
                 
                }
                    elm.popover({
                        title: e.title,
                        placement: 'top',
                        html: true,
                        content:e.description+'<br/>'+btn_edit+btn_del,
                        trigger: 'click'
                    });
                }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  });
</script>

@endsection
@section('styles')
<link href="/css/fullcalendar.css" rel="stylesheet" />
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
</style>
@endsection
