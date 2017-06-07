<script type="text/javascript">
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
function save_temporary_rate()
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
        $('#rate_form').hide();
        $('#rate_alert').show('slow', function() {
            
          $('#rate_alert').html('Rate added successfully.'); 
          alert_hide(); 
        });
 }

/********************* Location step***************/

    var loc_arr = [];
    

  //first click on add location
   function add_location()
      {
        var location =  new Object();
        
            
        if($('input[name="location_name"]').val()=='')
        {
            $('input[name="location_name"]').after('<label id="location_name-error" class="error" for="location_name">This field is required.</label>');
        
            return false;
        }
        else
        {
            
            //populate location object with value
            location={
                location_name: $('input[name="location_name"]').val(),
                address: $('input[name="address"]').val(),
                country: $('input[name="country"]').val(),
                city: $('input[name="city"]').val(),
                zip: $('input[name="zip"]').val(),
                loc_main_phone: $('input[name="loc_main_phone"]').val(),
                default_: $('input[name="default"]').val()

            };

            //push the new item in array
             loc_arr.push(location);

             //default value for index_ is 0
             index_ = 0;

             //if array have elements, set the index at end 
             if(loc_arr.length !=0)
             index_ = loc_arr.length-1;

            //location panel append at the end
            $('#location_labels').append('<div class="form-group col-lg-4" id="panel_'+index_+'"><div class="panel panel-green" ><div class="panel-heading"><h3 class="panel-title pull-left">'+location.location_name+'</h3><a href="javascript:;" class="btn btn-success pull-left" onclick="load_loc_obj('+index_+')"><i class="fa fa-pencil"></i></a><a href="javascript:;" class="btn btn-success pull-right" onclick="pop_loc_obj('+index_+')"><i class="fa fa-times-circle"></i></a><div class="clearfix"></div></div><div class="panel-body"><label>Address:</label>'+location.address+'<br><label>Country:</label>'+location.country+'<br><label>City:</label>'+location.city+'<br><label>Zip:</label>'+location.zip+'<br><label>Main phone:</label>'+location.loc_main_phone+'<br></div></div></div>');


            //reset the form input values.
            $('#location_inputs').find('input[type="text"]').val('');
        }

        

        
      }

      //on click edit btn at panel right it loads the location object values in form
      function load_loc_obj(id)
      {
        var location_data =loc_arr[id];
            $('input[name="location_name"]').val(location_data.location_name);
            $('input[name="address"]').val( location_data.address);
            $('input[name="country"]').val(location_data.country);
            $('input[name="city"]').val(location_data.city);
            $('input[name="zip"]').val(location_data.zip);
            $('input[name="loc_main_phone"]').val(location_data.loc_main_phone);
            $('input[name="default"]').val(location_data.default_);

            // change the button value to save location and call the func save_location
            $('#add_loc_btn').html('');
            $('#add_loc_btn').append('<a href="javascript:;" onclick="save_location('+id+')"  class="btn btn-lg btn-success btn-block">Save Location</a>');


      }

      //on click delete btn at panel right it deletes the location object from objects array.
      function pop_loc_obj(id)
      {
        //delete the item
        loc_arr.splice(id, 1);
        $('#panel_'+id).remove();
        $('#location_inputs').find('input[type="text"]').val('');
        
      }

      //Save the edited location to objects array.
      function save_location(id)
      {
         //delete the old object from array
         loc_arr.splice(id, 1);

         //add the edited data and reset the form
         add_location();

         // remove the panel also
          $('#panel_'+id).remove();

          // reset the button to add new location.
         $('#add_loc_btn').html('');
            $('#add_loc_btn').append('<a href="javascript:;" onclick="add_location()"  class="btn btn-lg btn-success btn-block">Add Location</a>');

        $('#location_inputs').find('input[type="text"]').val('');
        

      }

      /*********************End Location step***************/

      /*********************Contacts step***************/
       function populate_loc_contact()
       {
            $('#cnt_location').empty(); 
            if(loc_arr.length>0) 
            {
                $.each(loc_arr,function(index, el) {  
                        //console.log(el); 

                $('#cnt_location').append($("<option></option>")
                     .attr("value",index)
                     .text( el.location_name)); 
                    });

                $('#cnt_location').multiselect('rebuild');
                $('#contact_inputs').find('input[type="text"]','input[type="email"]').prop('disabled', false);
            }
            else
            {
                alert('please go to preivious step and add location first');
                $('#contact_inputs').find('input[type="text"]','input[type="email"]').prop('disabled', true);
            }
       }




    var cntct_arr = [];
    

  //first click on add location
   function add_contact()
      {
        var contact =  new Object();
        
            
        if($('input[name="f_name"]').val()=='' || $('input[name="email"]').val()=='')
        {
            if($('input[name="f_name"]').val()=='')
            $('input[name="f_name"]').after('<label id="f_name-error" class="error" for="f_name">This field is required.</label>');
            if($('input[name="email"]').val()=='')
            $('input[name="email"]').after('<label id="email-error" class="error" for="email">This field is required.</label>');
        
            return false;
        }
        else
        {
            
            //populate contact object with value
            contact={
                f_name: $('input[name="f_name"]').val(),
                l_name: $('input[name="l_name"]').val(),
                email: $('input[name="email"]').val(),
                title_: $('input[name="title"]').val(),
                contact_phone: $('input[name="contact_phone"]').val(),
                contact_mobile: $('input[name="contact_mobile"]').val(),
                contact_location: $('#cnt_location option:selected').text(),
                contact_location_index: $('#cnt_location').val()

            };

            //push the new item in array
             cntct_arr.push(contact);

             //default value for index_ is 0
             indexx = 0;

             //if array have elements, set the index at end 
             if(cntct_arr.length !=0)
             indexx = cntct_arr.length-1;

            //location panel append at the end
            $('#contact_labels').append('<div class="form-group col-lg-4" id="panel_ct_'+indexx+'"><div class="panel panel-green" ><div class="panel-heading"><h3 class="panel-title pull-left">'+contact.f_name+' '+contact.l_name+'</h3><a href="javascript:;" class="btn btn-success pull-left" onclick="load_cntct_obj('+indexx+')"><i class="fa fa-pencil"></i></a><a href="javascript:;" class="btn btn-success pull-right" onclick="pop_cntct_obj('+indexx+')"><i class="fa fa-times-circle"></i></a><div class="clearfix"></div></div><div class="panel-body"><label>Email:</label>'+contact.email+'<br><label>Title:</label>'+contact.title_+'<br><label>Phone:</label>'+contact.contact_phone+'<br><label>Mobile:</label>'+contact.contact_mobile+'<br><label>Location:</label>'+contact.contact_location+'<br></div></div></div>');


            //reset the form input values.
            $('#contact_inputs').find('input[type="text"]').val('');
            //$('#cnt_email').val('');
        }
      }



      //on click edit btn at panel right it loads the location object values in form
      function load_cntct_obj(id)
      {
        var contact_data =cntct_arr[id];
                $('input[name="f_name"]').val(contact_data.f_name);
                $('input[name="l_name"]').val(contact_data.l_name);
                $('input[name="email"]').val(contact_data.email);
                $('input[name="title"]').val(contact_data.title_);
                $('input[name="contact_phone"]').val(contact_data.contact_phone);
                $('input[name="contact_mobile"]').val(contact_data.contact_mobile);
                //$('#cnt_location option[value="'+contact_data.contact_location_index+'"]').attr("selected", "selected");
                 $('option[value="'+contact_data.contact_location_index+'"]', $('#cnt_location')).prop('selected', true);

                $('#cnt_location').multiselect('refresh');
                //$('#cnt_location').val(contact_data);


            // change the button value to save location and call the func save_location
            $('#add_cntct_btn').html('');
            $('#add_cntct_btn').append('<a href="javascript:;" onclick="save_contact('+id+')"  class="btn btn-lg btn-success btn-block">Save Contact</a>');


      }


      function pop_cntct_obj(id)
      {
        //delete the item
        cntct_arr.splice(id, 1);
        $('#panel_ct_'+id).remove();
        $('#contact_inputs').find('input[type="text"]').val('');
        
      }


      //Save the edited location to objects array.
      function save_contact(id)
      {
         //delete the old object from array
         cntct_arr.splice(id, 1);

         //add the edited data and reset the form
         add_contact();

         // remove the panel also
          $('#panel_ct_'+id).remove();

          // reset the button to add new location.
         $('#add_cntct_btn').html('');
            $('#add_cntct_btn').append('<a href="javascript:;" onclick="add_contact()"  class="btn btn-lg btn-success btn-block">Add Location</a>');

        $('#contact_inputs').find('input[type="text"]').val('');
        

      }
      /*********************End Contacts step***************/
</script>