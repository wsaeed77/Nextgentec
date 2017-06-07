
<div class="modal fade" id="modal-add-new-service-item" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Add New Service Item</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger alert-dismissable"  id="new_service_item_div" style="display:none">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
           <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <ul id="service_item_new_errors">
              </ul>
          </div>
         <form id="new_service_item_form">
            <input type="hidden" name="customer_id_new_service_item" value="">
                    <div class="col-lg-12">
                       
                        <div class="form-group col-lg-5">
                         <?php $service_types = [''=>'Pick a service type'];?>
                            <label>Service Type</label>
                            {!! Form::select('service_type_id', $service_types,'',['class'=>'form-control multiselect required','placeholder' => 'Pick a service type','onChange'=>'dynamic_data(this.value);','id'=>'new_service_type'])!!}
                            
                        </div>
                        <div class="col-lg-2">
                           
                                <img id="load_img" src="{{asset('img/loader.gif')}}" style="display:none" />
                            
                        </div>
                    </div>
                        
                    <div id="dynamic_data">
                        
                    </div>
                    <div class="col-lg-4" id="rates" style="display:none">

                        <div class="page-header">
                            <h3>Rates</h3>
                        </div>

                            <div class="alert alert-success" id="rate_alert" style="display:none">
                               
                            </div>

                        <?php //$rates = [''=>'Pick a default rate'];?>
                        <div class="form-group col-lg-12">
                            <label>Default Rate</label>
                            {!! Form::select('default_rate', $def_rates,'',['class'=>'form-control multiselect','id'=>'default_rate'])!!}
                            
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Additional Rates</label>
                            <?php //$additional_rates = [];?>
                             {!! Form::select('additional_rates[]', $additional_rates,'',['class'=>'form-control multiselect','id'=>'additional_rate','multiple'=>''])!!}

                            
                        </div>
                        <div class="form-group col-lg-9">
                     
                          <a href="javascript:;" onclick="srvc_item_show_rate_form()" class="btn btn-lg btn-success btn-block"><i class="fa fa-plus"></i> Add New Rate</a>
                            
                        </div> 

                         <div id="rate_form_srvc_item" class="col-lg-12" style="display:none">
                         <div class="form-group col-lg-12">
                            <label>Title</label>
                            {!! Form::input('text','temp_rate_title', null,['class'=>'form-control','placeholder'=>"Rate title"])!!}
                            
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Rate</label>
                            {!! Form::input('text','temp_amount',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
                        </div>
                        <div class="form-group col-lg-6">
                     
                          <a href="javascript:;" onclick="save_temporary_rate_srvc_item()" class="btn btn-lg btn-success btn-block">Save</a>
                            
                        </div> 
                        <div class="col-lg-2">
                           
                                <img id="load_img_rate" src="{{asset('img/loader.gif')}}" style="display:none" />
                            
                        </div>
                         </div>
                    </div>
                 
   <div style="clear:both"></div>
         </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default" id="close_modal_new_service_item"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_service_item">
            Add
          </button>
         
      </div>

    </div>
  </div>
</div>
@section('script')
@parent
  <script type="text/javascript">

  function srvc_item_show_rate_form()
  {
    //$('#btn_rate_form_show').click(function() {
               $('#rate_form_srvc_item').show('slow');
            //});
    // });
  }
  function dynamic_data(id)
{
    $('#load_img').show();

      $.ajax({
        url: "{{ URL::route('admin.crm.ajax.load_items')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'html',
        data: 'id='+id,
        success: function(response){
            //alert('fff');
            //console.log(response);
            $('#dynamic_data').html(response);
            $('#load_img').hide();
            $('#rates').show();
           /* $('#msgs').html(response.success);
            $('#msg_div').removeClass('alert-danger').addClass('alert-success').show();*/
            
            //
            $('#subview.multiselect').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                maxHeight: 400,
                dropUp: false,
                buttonClass: 'form-control'
            });
            $('.datepicker').datepicker(); 

            
      }
    });  
}  


function save_temporary_rate_srvc_item()
{
   // alert($('input[name="temp_amount"]').val());

    $('#load_img_rate').show();
    $('#default_rate')
         .append($("<option></option>")
         .attr("value",$('input[name="temp_rate_title"]').val()+'|'+$('input[name="temp_amount"]').val())
         .text($('input[name="temp_rate_title"]').val()+' ($'+$('input[name="temp_amount"]').val()+')')); 
        $('#default_rate').multiselect('rebuild'); 


        $('#additional_rate')
         .append($("<option></option>")
         .attr("value",$('input[name="temp_rate_title"]').val()+'|'+$('input[name="temp_amount"]').val())
         .text($('input[name="temp_rate_title"]').val()+' ($'+$('input[name="temp_amount"]').val()+')')); 
          $('#additional_rate').multiselect('rebuild'); 

        $('#load_img_rate').hide();
        $('#rate_form_srvc_item').hide();
        $('#rate_alert').show('slow', function() {
            
          $('#rate_alert').html('Rate added successfully.');
          $('#rate_form_srvc_item').find('input[type="text"]').val('') 
          alert_hide(); 
        });
}

    $(document).ready(function() 
    {
      //$('.modal-dialog').css('width', '750px');
      
  
      $('#modal-add-new-service-item').on('show.bs.modal', function(e) 
      {
       

         var CustId = $(e.relatedTarget).data('custid');
         $('input[name="customer_id_new_service_item"]').val(CustId);

         $.get('/admin/crm/load_new_service_item/'+CustId,function( data_response ) {

                
                 $('#new_service_type').html('<option value="">Pick a service type</option>');
                $.each(data_response.service_types,function(index, vlaue) {  
                        //console.log(location_data); 
                    $('#new_service_type').append($("<option></option>")
                             .attr("value",index)
                             .text( vlaue)); 
                   
                });

                $('#new_service_type').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                  dropUp: false,
                  buttonClass: 'form-control',
                  onChange: function(option, checked, select) {
                      //alert($('#multiselect').val());
                  }
                });
                $('#new_service_type').multiselect('rebuild');


                $('#new_service_type').multiselect('refresh');
              
                                  
                                },"json" 
              );
    
       
      
      });
         

         $( ".add_ajax_service_item" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.add_service_item')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#new_service_item_form').serialize() ,
          success: function(response){
            if(response.success){
              //var service_item_id= $('#service_item_id').val();
              //var customer_id = $('input[name="customer_id"]').val();
              //$('#cntct_errors').html(response.success);
             // $('#cntct_msg_div').removeClass('alert-danger').addClass('alert-success').show();

              $( "#close_modal_new_service_item" ).trigger( "click" );
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#service_items_panel');

              
                //load service items list
                $.get("{{ URL::route('admin.crm.ajax.list_service_item',$customer->id)}}",function( data_response ) {
                                          $('#service_items_table').html(data_response);
                                        },"html" );


             $.get("{{ URL::route('admin.crm.ajax.list_rate',$customer->id)}}",function( data_response ) {
                                  $('#rates_table').html(data_response);
                                  
                                },"html" 
              );
              
               alert_hide(); 
              
            }
          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#service_item_new_errors').html(html_error);
        $('#new_service_item_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });
  
        });
    
  </script>
@endsection