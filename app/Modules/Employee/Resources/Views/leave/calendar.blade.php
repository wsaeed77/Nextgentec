@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
         Calander
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Calander
        </li>
    </ol>
@endsection
<section class="content">
    <div class="row">

        <div class="col-xs-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Google Calander</h3>
                </div>

                <div class=" box-body">
                     <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script type="text/javascript" src="{{URL::asset('js/calendar.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() 
    {
       $('#calendar').fullCalendar({
            defaultDate: '{{date("Y-m-d")}}',
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events:<?php echo $events;?>,
            eventRender: function(e, elm) {
                //console.log(e.description);
                var btn = '<button type="button" class="btn btn-block btn-default btn-xs" data-id="11" data-target="#modal-appointment-edit" data-toggle="modal"><i class="fa fa-pencil"></i> Edit</button>';
                    elm.popover({
                        title: e.title,
                        placement: 'top',
                        html: true,
                        content:e.description,
                        trigger: 'click'
                    });
                }
           }); 

       //$('.popover').trigger('click');
    });
</script>
@endsection
@section('styles')
<link href="{{URL::asset('css/fullcalendar.css')}}" rel="stylesheet" />
<style>
.fc-row.fc-rigid {
    overflow: unset !important;
}
.fc-event {
    cursor: pointer;
}
</style>
@endsection