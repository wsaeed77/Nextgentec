<div class="modal fade" id="modal-edit-vendor-info" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Edit Vendor</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="vdr_msg_div_info_edit" style="display:none">
              <ul id="vendor_info_edit_ul">
              </ul>
          </div>
            <form id="edit_info_vendor_form">
            <input type="text" name="vendor_id" value="{{ $vendor->id }}" style="display: none;" />
                     <div class="form-group col-lg-4">
                        <label>Name</label>
                        {!! Form::input('text','name',$vendor->name, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Phone</label>
                    
                    {!! Form::input('text','phone',$vendor->phone_number, ['placeholder'=>"Main phone",'class'=>"form-control dt_mask",'id'=>'dt_mask', 'data-mask'=>'','data-inputmask'=> '"mask": "'.$global_phone_number_mask.'"']) !!} 
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Website</label>
                    {!! Form::input('text','website',$vendor->website, ['placeholder'=>"Website",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-4">
                        <label>State</label>
                        {!! Form::input('text','state',$vendor->state, ['placeholder'=>"State",'class'=>"form-control"]) !!}
                    </div>

                    <div class="form-group col-lg-4">
                        <label>City</label>
                    
                    {!! Form::input('text','city',$vendor->city, ['placeholder'=>"City",'class'=>"form-control"]) !!} 
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Zip</label>
                    {!! Form::input('text','zip',$vendor->zip, ['placeholder'=>"zip",'class'=>"form-control"]) !!}
                    </div>
                     <div class="form-group col-lg-4">
                        <label>Address</label>
                    {!! Form::textarea('address',$vendor->address, ['placeholder'=>"Address",'class'=>"form-control",'rows'=>'6']) !!}
                    </div>

                     <div class="form-group col-lg-8">
                        <label>Business Hours</label>
                     <div id="editBusinessHoursContainer"></div>   
                    </div>
                      
                    <div class="form-group col-lg-12">
                        <label>Dialing instructions</label>
                        {!! Form::textarea('dialing_instructions',$vendor->dailing_instructions, ['placeholder'=>"Dialing instructions",'id'=>'edit_instructions','class'=>"form-control",'rows'=>2]) !!}
                    </div>
                    <div style="clear:both"></div>
            </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default close_modal" id="edit_vendor_info_close_modal"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary edit_ajax_vendor_info">
            Update
          </button>
         
      </div>

    </div>
  </div>
</div>


<style>
  
#modal-edit-vendor-info > .modal-dialog {
    margin: 30px auto;
    width: 70% !important;
}
</style>

@section('document.ready')
@parent

     
       $( ".edit_ajax_vendor_info" ).click(function() {
         {{-- for ( instance in CKEDITOR.instances )
                 CKEDITOR.instances[instance].updateElement(); --}}
         $.ajax({
                url: "{{ URL::route('admin.vendor.update.info')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#edit_info_vendor_form').serialize()+'&business_hours='+JSON.stringify(EditbusinessHoursManager.serialize()),
                success: function(response){
                if(response.success)
                {
                      $( "#edit_vendor_info_close_modal" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#vendor_info');
                   

                 $.get("{{ URL::route('admin.vendor.ajax.refresh_vendor_info',$vendor->id)}}",function( data_response ) {
                 //console.log(data_response);
                 var json_data = JSON.parse(data_response);
                    $('#info_bdy').html(json_data.vendor_left_info);
                    $('#right_vendor_info').html(json_data.vendor_right_info);
                  
                    $("#businessHoursShowDiv").businessHours({                    
                    operationTime: eval(json_data.business_hours),
                    dayTmpl: '<div class="dayContainer" style="width: 80px;">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"/></div>' +
                        '<div class="weekday"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""/></div>' +
                        '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""/></div>' +
                        '</div></div>'
                      });
                            
                          },"html" 
              );
              
                  
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
                $('#vdr_msg_div_info_edit').html(html_error);

              }
            });

          });

@endsection
