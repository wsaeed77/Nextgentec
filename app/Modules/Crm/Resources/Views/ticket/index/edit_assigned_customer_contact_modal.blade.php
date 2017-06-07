<div class="modal fade" id="modal-edit-customer-contact" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Change Contact</h4>
      </div>
      <div class="modal-body">
      <div id="edit_customer_contact" style="display: none;"></div>
        <form id="edit_customer_contact_form">
         

            <input type="hidden" name="id" value="">
            <div class="form-group col-lg-9">
                <label>Change Contact</label>
                 {!! Form::input('text','customer_contact',null, ['placeholder'=>"Select contact",'class'=>"form-control",'id'=>'customer_contact_edit']) !!}
                        
                
            </div>
            
            </form>
             <div style="clear:both"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
         
       
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        
          
          <button type="submit" class="btn btn-success ajax_edit_customer_contact">
          Update
          </button>

          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_modal_edit_customer_contact">Close</button>
        
      </div>
    </div>
  </div>
</div>
@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {
      $('#edit_customer_contact').hide();
       
var ms ='';

      $('#modal-edit-customer-contact').on('show.bs.modal', function(e) 
      {
         ms = $('#customer_contact_edit').magicSuggest({
                  data: "{{ URL::route('admin.crm.ajax.get_contacts')}}",
                   queryParam: 'customer_contact',
                   allowFreeEntries: false,
                   maxSelection: 1,
                  valueField: 'id',
                  displayField: 'name',
                  groupBy: 'customer',
                  renderer: function(data){
                      return '<div class="country">' +
                          '<div class="name">' + data.name + '</div>' +
                          '<div style="clear:both;"></div>' +
                          '<div class="prop">' +
                              '<div class="lbl">Location : </div>' +
                              '<div class="val">' + data.location + '</div>' +
                          '</div>' +
                          '<div class="prop">' +
                              '<div class="lbl">Country : </div>' +
                              '<div class="val">' + data.country + '</div>' +
                          '</div>' +
                          '<div style="clear:both;"></div>' +
                            '</div>';
                        }

                    });
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(Id);

        $.get("/admin/crm/ticket/ajax_ticket/"+Id,function(response ) {
           //console.log(response);
            var data =  $.parseJSON(response);

           

              if(data.ticket.customer_location_contact_id &&  data.ticket.customer_location_contact_id != '')
              {
                       
                 ms.setValue([data.ticket.customer_contact.id+'_'+data.ticket.location.id+'_'+data.ticket.customer_id]);
              }
             
        });
        //get data-id attribute of the clicked element
        



      });

        $('#modal-edit-customer-contact').on('hide.bs.modal', function(e) 
        {
          //console.log('fff');
                ms.clear();
        });
      

       $( ".ajax_edit_customer_contact" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.ticket_assign_customer')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#edit_customer_contact_form').serialize() ,
          success: function(response){
            if(response.success){
            
              $( "#close_modal_edit_customer_contact" ).trigger( "click" );
              $('#msg_info').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

            var id = $('#edit_customer_contact_form').find('input[name="id"]').val();

              $.get("/admin/crm/ticket/ajax_ticket/"+id,function(response ) {

                var data =  $.parseJSON(response);
               var html_contact_ticket ='';
               if(data.ticket.customer_location_contact_id)
               {

                    html_contact_ticket +='<button type="button" class="btn bg-gray-active  btn-sm"  data-target="#modal-edit-customer-contact" id="modaal"  data-id="'+data.ticket.id+'" data-toggle="modal"><span><i class="fa fa-user"></i>'+data.ticket.customer_contact.f_name+' '+data.ticket.customer_contact.l_name+'</span></button>';

                    if(data.ticket.location)
                    {
                       html_contact_ticket +=' <button type="button" class="btn bg-gray-active  btn-sm"><i class="fa fa-map-marker"></i><span>'+data.ticket.location.location_name+'</span></button>';
                    }

                     if(data.ticket.service_item)
                    {
                       html_contact_ticket +=' <button type="button" class="btn bg-gray-active  btn-sm"><i class="fa  fa-gears"></i><span>'+data.ticket.service_item.title+'</span></button>';
                    }
              }
               else if(data.ticket.email)
               {
                   html_contact_ticket +=' <button type="button" class="btn bg-gray-active  btn-sm"  data-target="#modal-edit-customer-contact" id="modaal"  data-id="'+data.ticket.id+'" data-toggle="modal"><span> <i class="fa fa-envelope"></i>'+data.ticket.email+'</span></button>';
               }
               else
               {

                   html_contact_ticket +=' <button type="button" class="btn bg-gray-active  btn-sm"  data-target="#modal-edit-customer-contact" id="modaal"  data-id="'+data.ticket.id+'" data-toggle="modal"><span> <i class="fa fa-user"></i>&nbsp;</span></button>';

               }
                                        
                                       

             

             $("#contact_ticket_"+id).html(html_contact_ticket);

             
           });
             
               alert_hide(); 

              
            }
          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '<ul>';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
            html_error += '</ul>';
        $('#edit_customer_contact').html(html_error);
        $('#edit_customer_contact').addClass('alert alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });
    });

  </script>
@endsection
