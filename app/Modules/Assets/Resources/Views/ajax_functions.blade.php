{{--<script type="text/javascript">--}}
function submit_asset_form() {

     $.ajax({
            url: "{{ URL::route('admin.assets.store')}}",
            //headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: $('#asset_form').serialize(),
            success: function(response){
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#err_msgs');
               alert_hide();
               //$('#asset_form')[0].reset();
               window.location="{{URL::route('admin.assets.index')}}";
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
              $('#err_msgs').html(html_error);
              //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();

              // Render the errors with js ...
              alert_hide();
            }

          });

  }
function change_server_type(server_type)
{
  if(server_type=='virtual')
  {
    $('#virtual_types').show();
     $('#virtual_server_type').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });

  }
   if(server_type=='physical')
  {
    $('#virtual_types').hide();
  }

}
function change_asset_view(asset_type)
{
  if(asset_type=='network')
  {
    $('#target_div').html($('#network_div').html());
    $('#is_static').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });




  }
  if(asset_type=='gateway')
  {
    $('#target_div').html($('#gateway_div').html());


  }

  if(asset_type=='pbx')
  {
    $('#target_div').html($('#pbx_div').html());

  }

   if(asset_type=='server')
  {
    $('#target_div').html($('#server_div').html());

     $('#server_type').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });




    $(".select2").select2({
          tags: true
        });
  }

}


function show_static_type(option)
{
    if(option==1)
            $('#static_type').show();
    if(option==0)
        $('#static_type').hide();
}


function update_asset() {

     $.ajax({
            url: "{{ URL::route('admin.assets.update')}}",
            //headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: $('#edit_asset').serialize(),
            success: function(response){
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#msg');
               alert_hide();
               $('#close_edit_asset').trigger( "click" );


                var  table = $('#assets_dt_table').DataTable({
                      retrieve: true
   
                         });
   
                       table.draw();

                       alert_hide();

               //$('#asset_form')[0].reset();
            },
              error: function(data){
              //console.log(data);
                  var errors = data.responseJSON;
                  //console.log(errors);
                  var html_error = '<div  class="alert alert-danger"><ul>';
                  $.each(errors, function (key, value)
                  {
                      html_error +='<li>'+value+'</li>';
                  })
                   html_error += "</ul></div>";
              $('#err_msgs_asset_edit').html(html_error);


              // Render the errors with js ...
              alert_hide();
            }

          });

  }

function reload_assets_after_delete()
{
  $('<div  class="alert alert-success"><ul><li>Asset deleted successfully.</li></ul></div>').insertBefore('#msg');
    var  table = $('#assets_dt_table').DataTable({
                      retrieve: true
   
                         });
   
                       table.draw();
                       alert_hide();
}