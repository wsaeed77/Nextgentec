<div class="modal fade" id="modal-create-network" tabIndex="-1">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Network</h4>
      </div>
      <div class="modal-body">
          <div id="err_network">
          </div>
        <form id="create_network">

                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Customer</label>
                          <input type="hidden" name="id">
                         <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                         {
                            $selected_cust = session('cust_id');?>
                            {!! Form::select('customer', $customers,$selected_cust,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','disabled'=>'','id'=>'create_network_customer'])!!}

                                <?php } else{ ?>
                                {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'create_network_customer'])!!}

                                 <?php } ?>
                      </div>

                      <div class="form-group">
                        <label>Location</label>
                        <?php $location_index = [];?>
                        {!! Form::select('location_index', $location_index,'',['class'=>'form-control multiselect','id'=>'create_ntw_location'])!!}
                      </div>

                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Name</label>
                        {!! Form::input('text','name',null, ['placeholder'=>"Name",'class'=>"form-control"]) !!}

                      </div>
                  </div>
                  <div class="col-md-12" style="margin-top:15px;">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-pills">
                        <li class="active"><a href="#create_lan" data-toggle="pill">LAN</a></li>
                        <li><a href="#create_wan" data-toggle="pill">WAN</a></li>
                        <li><a href="#create_isp" data-toggle="pill">ISP</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane  fade in  active" id="create_lan">
                          <!-- Tab 1 -->
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Subnet</label>
                                {!! Form::input('text','lansubnet',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group">
                                <label>Gateway</label>
                                {!! Form::input('text','langw',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group">
                                <label>Subnet mask</label>
                                {!! Form::select('lansubnetmask', [
                                  '' => 'None',
                                  '255.0.0.0' => '255.0.0.0 /8',
                                  '255.128.0.0' => '255.128.0.0 /9',
                                  '255.192.0.0' => '255.255.240.0 /10',
                                  '255.224.0.0' => '255.255.240.0 /11',
                                  '255.240.0.0' => '255.240.0.0 /12',
                                  '255.248.0.0' => '255.248.0.0 /13',
                                  '255.252.0.0' => '255.252.0.0 /14',
                                  '255.254.0.0' => '255.254.0.0 /15',
                                  '255.255.0.0' => '255.255.0.0 /16',
                                  '255.255.128.0' => '255.255.128.0 /17',
                                  '255.255.192.0' => '255.255.192.0 /18',
                                  '255.255.224.0' => '255.255.224.0 /19',
                                  '255.255.240.0' => '255.255.240.0 /20',
                                  '255.255.248.0' => '255.255.248.0 /21',
                                  '255.255.252.0' => '255.255.252.0 /22',
                                  '255.255.254.0' => '255.255.254.0 /23',
                                  '255.255.255.0' => '255.255.255.0 /24',
                                  '255.255.255.128' => '255.255.255.128 /25',
                                  '255.255.255.192' => '255.255.255.192 /26',
                                  '255.255.255.224' => '255.255.255.224 /27',
                                  '255.255.255.240' => '255.255.255.240 /28',
                                  '255.255.255.248' => '255.255.255.248 /29',
                                  '255.255.255.252' => '255.255.255.252 /30',
                                  ],null,
                                  ['class'=>'form-control multiselect', 'id' => 'lansubnetmask'])!!}
                            </div>
                          </div><div class="clearfix"></div>
                        </div>
                        <!-- /.tab-pane  fade in  -->
                        <div class="tab-pane  fade in " id="create_wan">
                          <!-- Tab 2 -->
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>IP Address</label>
                                {!! Form::input('text','wanip',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
                                  <?php // Form::text('wanip',null, ['placeholder'=>"",'class'=>"form-control dt_mask", 'data-mask'=>'','data-inputmask'=> new Illuminate\Support\HtmlString("'alias': 'ip'")]) ?>
                            </div>

                            <div class="form-group">
                                <label>Gateway</label>
                                {!! Form::input('text','wangw',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
                            </div>

                            <div class="form-group">
                                <label>Subnet mask</label>
                                {!! Form::select('wansubnetmask', [
                                  '' => 'None',
                                  '255.0.0.0' => '255.0.0.0 /8',
                                  '255.128.0.0' => '255.128.0.0 /9',
                                  '255.192.0.0' => '255.255.240.0 /10',
                                  '255.224.0.0' => '255.255.240.0 /11',
                                  '255.240.0.0' => '255.240.0.0 /12',
                                  '255.248.0.0' => '255.248.0.0 /13',
                                  '255.252.0.0' => '255.252.0.0 /14',
                                  '255.254.0.0' => '255.254.0.0 /15',
                                  '255.255.0.0' => '255.255.0.0 /16',
                                  '255.255.128.0' => '255.255.128.0 /17',
                                  '255.255.192.0' => '255.255.192.0 /18',
                                  '255.255.224.0' => '255.255.224.0 /19',
                                  '255.255.240.0' => '255.255.240.0 /20',
                                  '255.255.248.0' => '255.255.248.0 /21',
                                  '255.255.252.0' => '255.255.252.0 /22',
                                  '255.255.254.0' => '255.255.254.0 /23',
                                  '255.255.255.0' => '255.255.255.0 /24',
                                  '255.255.255.128' => '255.255.255.128 /25',
                                  '255.255.255.192' => '255.255.255.192 /26',
                                  '255.255.255.224' => '255.255.255.224 /27',
                                  '255.255.255.240' => '255.255.255.240 /28',
                                  '255.255.255.248' => '255.255.255.248 /29',
                                  '255.255.255.252' => '255.255.255.252 /30',
                                  ],null,
                                  ['class'=>'form-control multiselect', 'id'=>'wansubnetmask'])!!}
                            </div>

                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Primary DNS</label>
                                  {!! Form::input('text','dns1',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
                            </div>

                            <div class="form-group">
                                <label>Secondary DNS</label>
                                  {!! Form::input('text','dns2',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane  fade in " id="create_isp">
                          <!-- Tab 3 -->
                          <div class="col-md-6">
                          </div>
                        </div><div class="clearfix"></div>
                        <!-- /.tab-pane  fade in  -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                  </div>


                       <div class="form-group col-lg-12">
                          <label>Notes</label>
                          {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'create_network_notes','rows'=>5]) !!}
                      </div>
                  </form>
          <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                <?php //$route  = $route;?>

                    <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


                    <button type="button" class="btn btn-default"
                            data-dismiss="modal" id="close_create_network">Close</button>
                    <button  class="btn btn-primary new_network">
                       Create
                    </button>

                </div>
              </div>
            </div>
          </div>


@section('document.ready')
@parent

{{--<script type="text/javascript">--}}

$('#modal-create-network').on('show.bs.modal', function(e) {
  $('#err_network').html('');




  // Populate Locations
  $.get('/admin/crm/ajax_get_locations_list/{{$selected_cust}}',function( data_response ) {
    $('#create_ntw_location').html('');
    $.each(data_response.locations,function(index, location_data) {
      console.log(location_data);
      $('#create_ntw_location').append($("<option></option>")
      .attr("value",location_data.id)
      .text( location_data.location_name));
    });

    $('#create_ntw_location').multiselect({
      enableFiltering: true,
      includeSelectAllOption: true,
      maxHeight: 400,
      dropUp: false,
      buttonClass: 'form-control',
      onChange: function(option, checked, select) {
          //alert($('#multiselect').val());
      }
    });
    $('#create_ntw_location').multiselect('rebuild');
    $('#create_ntw_location').multiselect('refresh');

  },"json");

});

// On Modal Close


$( ".new_network" ).click(function() {

  $.ajax({
    url: "{{ URL::route('admin.knowledge.store.network')}}",
    //headers: {'X-CSRF-TOKEN': token},
    type: 'POST',
    dataType: 'json',
    data: $('#create_network').serialize()+'&customer='+$('#network_customer').val(),
    success: function(response){
      if(response.success) {
        $( "#close_create_network" ).trigger( "click" );
        $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#networks');
          var table = $('#network_dt_table').DataTable({
            retrieve: true
          });
          table.draw();
          alert_hide();
      }
    },
    error: function(data) {
      var errors = data.responseJSON;
      //console.log(errors);
      var html_error = '<div  class="alert alert-danger"><ul>';
      $.each(errors, function (key, value) {
        html_error +='<li>'+value+'</li>';
      })
      html_error += "</ul></div>";
      $('#err_network').html(html_error);
    }
  });
});

@endsection
