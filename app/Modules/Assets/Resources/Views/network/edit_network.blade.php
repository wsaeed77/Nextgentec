<div class="modal fade" id="modal-edit-network" tabIndex="-1">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Network</h4>
      </div>
      <div class="modal-body">
          <div id="err_edit_network">
          </div>
        <form id="update_network">

        <div class="col-md-6">
            <div class="form-group">
              <label>Customer</label>
                <input type="hidden" name="id">
               <?php if ((session('cust_id')!='') && (session('customer_name')!='')) {
                   $selected_cust = session('cust_id');?>
                  {!! Form::select('customer', $customers,$selected_cust,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','disabled'=>'','id'=>'edit_network_customer'])!!}

                <?php } else { ?>
                      {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'edit_network_customer'])!!}

               <?php } ?>
            </div>

            <div class="form-group">
              <label>Location</label>
                <?php $location_index = [];?>
              {!! Form::select('location_index', $location_index,'',['class'=>'form-control multiselect','id'=>'edit_ntw_location'])!!}
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
           

             <li class="active"><a href="#edit_lan" data-toggle="pill" >LAN</a></li>
              <li><a href="#edit_wan" data-toggle="pill" >WAN</a></li>
              <li><a href="#edit_isp" data-toggle="pill" >ISP</a></li>
          </ul>



          <div class="tab-content">
              <div class="tab-pane  fade in active" id="edit_lan">
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
                      {!! Form::select('edit_lansubnetmask', [
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
                        ['class'=>'form-control multiselect', 'id' => 'edit_lansubnetmask'])!!}
                  </div>
                </div><div class="clearfix"></div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane  fade in " id="edit_wan">
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
                      {!! Form::select('edit_wansubnetmask', [
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
                        ['class'=>'form-control multiselect', 'id'=>'edit_wansubnetmask'])!!}
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
              <div class="tab-pane  fade in " id="edit_isp">
                <!-- Tab 3 -->
                <div class="col-md-6">
                </div>
              </div><div class="clearfix"></div>
              <!-- /.tab-pane -->
            </div>
         
           
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>


             <div class="form-group col-lg-12">
                <label>Notes</label>
                {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'edit_network_notes','rows'=>5]) !!}
            </div>
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_edit_network">Close</button>
          <button  class="btn btn-primary update_network">
             Update
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent

{{--<script type="text/javascript">--}}

//$(".dt_mask").inputmask();
$('#modal-edit-network').on('show.bs.modal', function(e)
{





  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('id');
  //populate the textbox
  $.get('/admin/knowledge/edit/network/'+Id,function(response ) {

    $('option[value="'+response.network.customer_id+'"]', $('#edit_network_customer')).prop('selected', true);
    $('#edit_network_customer').multiselect('refresh');

    $(e.currentTarget).find('input[name="name"]').val(response.network.name);
    $(e.currentTarget).find('input[name="lansubnet"]').val(response.network.lansubnet);
    $(e.currentTarget).find('input[name="langw"]').val(response.network.langw);

    $('#edit_lansubnetmask option[value="'+response.network.lansubnetmask+'"]').prop('selected', true);
    $('#edit_lansubnetmask').multiselect('refresh');

    $(e.currentTarget).find('input[name="wanip"]').val(response.network.wanip);
    $(e.currentTarget).find('input[name="wangw"]').val(response.network.wangw);

    $('#edit_wansubnetmask option[value="'+response.network.wansubnetmask+'"]').prop('selected', true);
    $('#edit_wansubnetmask').multiselect('refresh');

    $(e.currentTarget).find('input[name="dns1"]').val(response.network.dns1);
    $(e.currentTarget).find('input[name="dns2"]').val(response.network.dns2);
    $(e.currentTarget).find('textarea[name="notes"]').val(response.network.notes);
    $(e.currentTarget).find('input[name="id"]').val(Id);



    // Populate Locations
    $.get('/admin/crm/ajax_get_locations_list/{{$selected_cust}}',function( data_response ) {

      $('#edit_ntw_location').html('');
      $.each(data_response.locations,function(index, location_data) {
              //console.log(location_data);
          $('#edit_ntw_location').append($("<option></option>")
                    .attr("value",location_data.id)
                    .text( location_data.location_name));

      });

      $('#edit_ntw_location').multiselect({
        enableFiltering: true,
        includeSelectAllOption: true,
        maxHeight: 400,
        dropUp: false,
        buttonClass: 'form-control',
        onChange: function(option, checked, select) {
            //alert($('#multiselect').val());
        }
      });
      $('#edit_ntw_location').multiselect('rebuild');

      $('option[value="'+response.network.customer_location_id+'"]', $('#edit_ntw_location')).prop('selected', true);

      $('#edit_ntw_location').multiselect('refresh');



    },"json");

  },"json");


});

// On Modal Close
$('#modal-edit-network').on('hidden.bs.modal', function (e) {
  //var editor = CKEDITOR.instances['edit_network_notes'];
  //if (editor) { editor.destroy(true); }
});

$( ".update_network" ).click(function() {

  $.ajax({
         url: "{{ URL::route('admin.knowledge.update.network')}}",
         //headers: {'X-CSRF-TOKEN': token},
         type: 'POST',
         dataType: 'json',
         data: $('#update_network').serialize()+'&customer='+$('#edit_network_customer').val(),
         success: function(response){
         if(response.success)
         {
               $( "#close_edit_network" ).trigger( "click" );
               $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#networks');
             var  table = $('#network_dt_table').DataTable( {
                     retrieve: true

                 } );

                 table.draw();

            alert_hide();
         }

         },
         error: function(data){
             var errors = data.responseJSON;
             //console.log(errors);
             var html_error = '<div  class="alert alert-danger"><ul>';
             $.each(errors, function (key, value)
             {
                 html_error +='<li>'+value+'</li>';
             })
              html_error += "</ul></div>";
         $('#err_edit_network').html(html_error);

       }
     });

   });

@endsection
