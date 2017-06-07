<div class="modal fade" id="modal-activity">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Create Activity</h4>
        <span>{{$customer->name}}</span>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-pills">
                <li class="active"><a href="#note_tab" data-toggle="tab">Note</a></li>
                <li><a href="#email_tab" data-toggle="tab">Email</a></li>
                <li><a href="#ticket_tab" data-toggle="tab">Ticket</a></li>
                <li><a href="#appointment_tab" data-toggle="tab">Appointment</a></li>
              </ul>
              <div class="tab-content">
                <!-- /.tab-pane ** NOTE ** -->
                <div class="tab-pane active" id="note_tab">
                  <form id="note_form" class="form-horizontal">
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="subject" class="col-sm-2 control-label">Subject</label>
                          <div class="col-sm-10">
                            {!! Form::hidden('customer_id', session('cust_id')) !!}
                            <input class="form-control" type="text" placeholder="" id="note_subject" name="subject" style="margin-bottom: 4px;">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="note_status" class="col-sm-3 control-label">Source</label>
                          <div class="col-sm-9">
                            {!! Form::select('source', array(),'',['class'=>'form-control select2','id'=>'note_source', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-12">
                        <textarea placeholder="Email Body" class="form-control textarea" id="create_note_body" rows="15" name="note" cols="50"></textarea>
                      </div>
                    </div>

                      <div class="col-lg-4 pull-right">
                          <button type="button" class="btn btn-default pull-left close_modal_activity" id="close_modal_activity" data-dismiss="modal">Cancel</button>
                          <a  class="btn btn-primary activity_save pull-right">Save</a>
                      </div>

                  </form>
                  <div class="clearfix"></div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="email_tab">
                  <form class="form-horizontal"  id="email_form">
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="against" class="col-sm-2 control-label">To</label>
                          <div class="col-sm-10">
                            {{-- <input class="form-control" type="text" placeholder="" id="email_to" style="margin-bottom: 4px;"> --}}
                              <?php $email = [];?>
                            {!! Form::select('to[]', $email,'',['class'=>'form-control select2','multiple'=>'','style'=>"width: 100%;"])!!}    
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="against" class="col-sm-2 control-label">CC</label>
                          <div class="col-sm-10">
                           {{--  <input class="form-control" type="text" placeholder="" id="email_to" style="margin-bottom: 4px;"> --}}

                             {!! Form::select('cc[]', $email,'',['class'=>'form-control select2','multiple'=>'','style'=>"width: 100%;"])!!}  
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="subject" class="col-sm-2 control-label">Subject</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder=""  name="email_subject" id="email_subject" style="margin-bottom: 4px;">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-12">
                        <textarea placeholder="Email Body" class="form-control textarea" id="create_email_body" rows="15" name="email_body" cols="50"><br/><br/><br/>{{$email_signature}}</textarea>
                      </div>
                    </div>

                     <div class="col-lg-4 pull-right">
                          <button type="button" class="btn btn-default pull-left close_modal_activity"  data-dismiss="modal">Cancel</button>
                          <a  class="btn btn-primary email_save pull-right">Save</a>
                      </div>
                  </form>
                  <div class="clearfix"></div>
                </div>
                <!-- /.tab-pane **TICKET** -->
                <div class="tab-pane" id="ticket_tab">
                  <form class="form-horizontal" id="ticket_form">
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="ticket_location" class="col-sm-2 control-label">Location</label>
                          <div class="col-sm-10">
                            {!! Form::select('ticket_location', array(),'',['class'=>'form-control select2','id'=>'ticket_location', 'style'=>'width:100%;','onChange'=>'populate_contact(this.value)'])!!}
                          </div>
                        </div>
                      </div>

                     
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="ticket_status" class="col-sm-3 control-label">Status</label>
                          <div class="col-sm-9">
                            {!! Form::select('ticket_status', array(),'',['class'=>'form-control select2','id'=>'ticket_status', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="ticket_assign" class="col-sm-2 control-label">Assign</label>
                          <div class="col-sm-10">
                            {!! Form::select('ticket_assign[]', array(),'',['class'=>'form-control select2','id'=>'ticket_assign', 'style'=>'width:100%;',  'multiple'=>'multiple'])!!}
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="ticket_service_item" class="col-sm-3 control-label">Against</label>
                          <div class="col-sm-9">
                            {!! Form::select('ticket_service_item', array(),'',['class'=>'form-control select2','id'=>'ticket_service_item', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">

                     <div class="col-md-8">
                        <div class="form-group">
                          <label for="ticket_location" class="col-sm-2 control-label">Contact</label>
                          <div class="col-sm-10">
                            {!! Form::select('ticket_location_contact', array(),'',['class'=>'form-control select2','id'=>'ticket_location_contact', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="ticket_priority" class="col-sm-3 control-label">Priority</label>
                          <div class="col-sm-9">
                            {!! Form::select('ticket_priority', array(),'',['class'=>'form-control select2','id'=>'ticket_priority', 'style'=>'width:100%;'])!!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                          <label for="subject" class="col-sm-2 control-label">Subject</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text"  name="ticket_subject" placeholder="" id="note_subject" style="margin-bottom: 4px;">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-12">
                        <textarea placeholder="" class="form-control textarea" id="create_ticket_body" rows="15" name="notes" cols="50"><br/><br/><br/>{{$email_signature}}</textarea>
                      </div>
                    </div>

                     <div class="col-lg-4 pull-right">
                          <button type="button" class="btn btn-default pull-left close_modal_activity"  data-dismiss="modal">Cancel</button>
                          <a  class="btn btn-primary  pull-right" id="ticket_save">Save</a>
                      </div>
                  </form>
                  <div class="clearfix"></div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="appointment_tab">
                  <form class="form-horizontal" id="appointment_form">
                    <div class="row" style="padding-top: 10px;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="visit_location" class="col-sm-2 control-label">Location</label>
                          <div class="col-sm-10">
                            {!! Form::select('location_index', array(),'',['class'=>'form-control select2','id'=>'visit_location', 'style'=>'width:100%;'])!!}
                          </div>
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
                          <label for="visit_contact" class="col-sm-2 control-label">Contact</label>
                          <div class="col-sm-10">
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
                          <label for="eventTitle" class="col-sm-2 control-label">Title</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="appointment_title" type="text" placeholder="" id="eventTitle">
                          </div>
                        </div>
                        <!-- <div class="form-group" id="checkboxes">
                          <label for="tentative">
                          <input type="checkbox" id="tentative" name="status" class="minimal">
                          Tentative
                          </label>
                          <label for="timeframe">
                          <input type="radio" id="timeframe" name="timeframe" class="minimal">
                          Exact
                          </label>
                          <label for="timeframe">
                          <input type="radio" id="timeframe" name="timeframe" class="minimal">
                          &plusmn; 1 Hour
                          </label>
                          <label for="timeframe">
                          <input type="radio" id="timeframe" name="timeframe" class="minimal">
                          &plusmn; 2 Hours
                          </label>
                        </div> -->
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
                        <div id="calendarmd" style="display: none; margin-top: 20px;">
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
                    </div>
                     <div class="col-lg-4 pull-right">
                          <button type="button" class="btn btn-default pull-left close_modal_activity"  data-dismiss="modal">Cancel</button>
                          <a  class="btn btn-primary pull-right" id="appointment_save">Save</a>
                      </div>
                  </form>
                  <div class="clearfix"></div>

                </div>
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>

        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

@section('script')
@parent
<script type="text/javascript" src="/js/calendar.js"></script>
{{-- <script src="/ckeditor/ckeditor.js"></script>
<script src="/ckeditor/config.js"></script> --}}
<script src="/js/select2.full.min.js"></script>

<script src="/js/jquery.autogrow-textarea.js"></script>


<script src="/vendor/summernote/summernote.js"></script>
<script src="/vendor/summernote/summernote-floats-bs.min.js"></script>
<script type="text/javascript">
var calander_data = [];
$(document).ready(function()
{


    $(".select2").select2({
          tags: true
        });

  $('#modal-activity').on('show.bs.modal', function(e) {


     $('#create_note_body').summernote({ 
       callbacks: {
      onImageUpload: function(files) {
        //console.log(files);
        // console.log($editable);
      uploadImage(files[0],'ticket','create_note_body');
    }
                },
    lang: 'en-US',
    dialogsInBody: true,
    height: 400,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});

     $('#create_email_body').summernote({ 
       callbacks: {
      onImageUpload: function(files) {
        //console.log(files);
        // console.log($editable);
      uploadImage(files[0],'ticket','create_email_body');
    }
                },
    lang: 'en-US',
    dialogsInBody: true,
    height: 400,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});
    

     $('#create_ticket_body').summernote({ 
       callbacks: {
      onImageUpload: function(files) {
        //console.log(files);
        // console.log($editable);
      uploadImage(files[0],'ticket','create_ticket_body');
    }
                },
    lang: 'en-US',
    dialogsInBody: true,
    height: 400,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true});




    $("#eventNotes").autogrow();

    function formatRepoSelection (repo) {
      return repo.full_name || repo.text;
    }

    // Populate the locations select box
    $.get('/admin/crm/ajax_get_select_locations/{{session('cust_id')}}',function( data_response ) {
      $("#visit_location").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
      $("#visit_location").val('').change();

      $("#ticket_location").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
      $("#ticket_location").val('').change();
    },"json");

    // Populate the service items (Against) select box
    $.get('/admin/crm/ticket/ajax_get_select_service_items/{{session('cust_id')}}',function( data_response ) {
      $("#ticket_service_item").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
      $("#ticket_service_item").val('').change();

      $("#appointment_against").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
      $("#appointment_against").val('').change();
    },"json");

    // Populate the contacts select box
    $.get('/admin/crm/ajax_get_select_contacts/{{session('cust_id')}}',function( data_response ) {
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

      $("#ticket_assign").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        tags: true,
        tokenSeparators: [',', ' ']
      })
      $("#ticket_assign").val('{{Auth::user()['id']}}').change();

    },"json");

    // Populate the ticket statuses select box
    $.get('/admin/crm/ticket/ajax_get_select_statuses',function( data_response ) {
      $("#ticket_status").select2({
        data: data_response,
        allowClear: true,
        placeholder: "",
        minimumResultsForSearch: 10
      })
    },"json");

    // Populate the note status select box
    // $("#note_status").select2({
    //   data: [
    //     { id: 0, text: 'Pinned' },
    //     { id: 1, text: 'Archived' }
    //   ],
    //   minimumResultsForSearch: Infinity,
    //   placeholder: "",
    //   allowClear: true
    // })
    // $("#note_status").val('').change();

    // Populate the note source select box
    $("#note_source").select2({
      data: [
        { id: 'Call', text: 'Call' },
        { id: 'Email', text: 'Email' },
        { id: 'Visit', text: 'Visit' },
        { id: 'Other', text: 'Other' }
      ],
      minimumResultsForSearch: Infinity,
      placeholder: "",
      allowClear: true
    })
    $("#note_source").val('').change();

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

    // Populate the priority select box
    $("#ticket_priority").select2({
      data: [
        { id: 0, text: 'Low' },
        { id: 1, text: 'Normal' },
        { id: 2, text: 'High' },
        { id: 3, text: 'Urgent' },
        { id: 4, text: 'Critical' },
      ],
      minimumResultsForSearch: Infinity,
      placeholder: "",
      allowClear: true
    });
    $("#ticket_priority").val('1').change();

    // Save Clicked
    $( ".activity_save" ).click(function() {
     /* for ( instance in CKEDITOR.instances )
              CKEDITOR.instances[instance].updateElement();*/
      $.ajax({
        url: "{{ URL::route('admin.crm.note.create')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#note_form').serialize(),
        success: function(response){
          if(response.success){
            $(".activity_save").html('Success');
            $(".activity_save").toggleClass('btn-success btn-primary');
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


    $( ".email_save" ).click(function() {
     /* for ( instance in CKEDITOR.instances )
              CKEDITOR.instances[instance].updateElement();*/
      $.ajax({
        url: "{{ URL::route('admin.crm.email.send')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#email_form').serialize(),
        success: function(response){
          if(response.success=='yes'){
            $(".email_save").html('Success');
            $(".email_save").toggleClass('btn-success btn-primary');
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

    $( "#appointment_save" ).click(function() {
      //console.log(calander);
     /* for ( instance in CKEDITOR.instances )
              CKEDITOR.instances[instance].updateElement();*/
               $("#appointment_save").html('Sending data...');
      $.ajax({
        url: "{{ URL::route('admin.crm.appointment.post')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#appointment_form').serialize()+'&calander_data='+calander_data,
        success: function(response){
          if(response.success=='yes'){
            $("#appointment_save").html('Success');
            $("#appointment_save").toggleClass('btn-success btn-primary');
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
    


    $( "#ticket_save" ).click(function() {
     /* for ( instance in CKEDITOR.instances )
              CKEDITOR.instances[instance].updateElement();*/
      $.ajax({
        url: "{{ URL::route('admin.crm.add.ticket')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#ticket_form').serialize(),
        success: function(response){
          if(response.success=='yes'){
            $("#ticket_save").html('Success');
            $("#ticket_save").toggleClass('btn-success btn-primary');
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

  });

  // On Modal Close
  $('#modal-activity').on('hidden.bs.modal', function (e) {
    /*for(name in CKEDITOR.instances) {
        CKEDITOR.instances[name].destroy(true);
    }*/

    // Change the save button back
    $(".activity_save").html('Save');
    $(".activity_save").toggleClass('btn-success btn-primary');


  });

  $('#modal-activity').on('shown.bs.modal', function() {
    var activetab;
      /*
      * Begin Calendar Element
      */

      /* initialize the external events
       -----------------------------------------------------------------*/
      function ini_events(ele) {
        //console.log('llll');
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
      //var date2 = new Date ();

      var appointmentEvent;
      var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear();


      $('#calendar').fullCalendar({
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
          editable:false
        }],
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        defaultView: 'agendaWeek',
        allDaySlot: false,
        height: 400,
       // defaultDate:'2017-02-03',
        //defaultTimedEventDuration: '01:00:00',
        //hiddenDays: [0,6],

        dayClick: function(date, jsEvent, view) {

          var duration = Number($('#timeframe').val());

           // var sign = ' &#177;'+duration;
           var m = moment(date.format()).add(duration,'hours');
           if(duration==4 || duration==5 || duration==0)
           {
             m = moment(date.format()).add(2,'hours');
            /* if(duration==4)
              sign = ' SDY';
             if(duration==5)
             sign = ' TTV';*/
           }

           var end_ = moment(m).format('YYYY-MM-DD HH:mm:ss');

          if (typeof appointmentEvent == "undefined") {
            //console.log(new Date(new Date().setHours(new Date().getHours()+1)));
            calander_data[0] = date.format();
             calander_data[1] = end_;
            appointmentEvent = $('#calendar').fullCalendar('renderEvent',
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
            $('#calendar').fullCalendar('updateEvent', appointmentEvent[0]);
          }
        },
        eventResize: function( event, delta, revertFunc, jsEvent, ui, view)  {
         
          calander_data[0] = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
             calander_data[1] = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
       
        }
      });



      $( "#eventTitle" ).keyup(function() {
        if (typeof appointmentEvent != "undefined") {
          appointmentEvent[0].title = $('#eventTitle').val();

          $('#calendar').fullCalendar('updateEvent', appointmentEvent[0]);
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


      /*
       * End Calendar Element
       */
  });

    $('#appointment_tab').on('show', function() {
          console.log('#foo is now visible');
    });

    // Run on tab click
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        activetab = $(e.target).attr('href');

        if (activetab == "#appointment_tab") {
          $("#calendarmd").show();
          $('#calendar').fullCalendar('render');
        } else {
          $("#calendarmd").hide();
        }
    });

});

function populate_contact(loc_id)
{
  if(loc_id!='')
  {
     $.get('/admin/crm/contacts_by_loc/'+loc_id,function( data_response ) {

     
           $("#ticket_location_contact").select2({
            data: data_response,
            allowClear: true,
            placeholder: "",
            minimumResultsForSearch: 10
          });

           if(data_response.length>0)
             $("#ticket_location_contact").val('').change();
           else
            $("#ticket_location_contact").empty().trigger('change')
         
        },"json");
  }
}      
</script>
@endsection
@section('styles')
@parent
<link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}">
<link href="{{URL::asset('css/fullcalendar.css')}}" rel="stylesheet" />

<link href="{{URL::asset('vendor/summernote/summernote.css')}}" rel="stylesheet">
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
