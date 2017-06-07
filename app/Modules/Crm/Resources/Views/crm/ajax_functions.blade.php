<script type="text/javascript">
function dynamic_data(id)
{
  //alert('dddd');
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
            $('.multiselect_crm').multiselect({
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
          $('#rate_form').find('input[type="text"]').val('') 
          alert_hide(); 
        });
 }

/********************* Location step***************/

    var loc_arr = [];
    var index__ = 0;

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


             index_ = index__++;
            
            //populate location object with value
            location={
                loc_id:index_,
                location_name: $('input[name="location_name"]').val(),
                address: $('input[name="address"]').val(),
                country: $('#cntry option:selected').text(),
                state: $('input[name="state"]').val(),
                city: $('input[name="city"]').val(),

                zip: $('input[name="zip"]').val(),
                loc_main_phone: $('input[name="loc_main_phone"]').val(),
                back_line_phone: $('input[name="back_line_phone"]').val(),
                primary_fax: $('input[name="primary_fax"]').val(),
                secondary_fax: $('input[name="secondary_fax"]').val(),
                default_: ($('input[name="default"]').is( ":checked" )) ? 1 : 0

            };

       /*     <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Removable</h3>
                  <div class="box-tools pull-right">
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  The body of the box
                </div><!-- /.box-body -->
              </div>*/
            //location panel append at the end
            $('#location_labels').append('<div class="form-group col-lg-4" id="panel_'+index_+'"><div class="box box-success box-solid" ><div class="box-header with-border"><h3 class="box-title">'+location.location_name+'</h3><div class="box-tools pull-right"><a href="javascript:;" class="btn btn-box-tool" onclick="load_loc_obj('+index_+')"><i class="fa fa-pencil"></i></a><a  class="btn btn-box-tool" href="javascript:;"  onclick="pop_loc_obj('+index_+')"><i class="fa fa-times-circle"></i></a></div></div><div class="box-body"><label>Address:</label>'+location.address+'<br><label>Country:</label>'+location.country+'<br><label>State:</label>'+location.state+'<br><label>City:</label>'+location.city+'<br><label>Zip:</label>'+location.zip+'<br><label>Main phone:</label>'+location.loc_main_phone+'<br><label>Back Line #:</label>'+location.back_line_phone+'<br><label>Primary Fax:</label>'+location.primary_fax+'<br><label>Secondary Fax:</label>'+location.secondary_fax+'<br><label>Is Default:</label>'+((location.default_==1)? "Yes":"No")+'<br></div></div></div>');

            loc_arr.push(location);
            //loc_arr['loc_'+index_]=location;

            //reset the form input values.
            $('#location_inputs').find('input[type="text"]').val('');
             $('input[name="default"]').prop('checked',false);
        }

        

        
      }

      //on click edit btn at panel right it loads the location object values in form
      function load_loc_obj(id)
      {
        $.each(loc_arr,function(index,location_data) {
          
               if(location_data.loc_id==id)
               {

                $('input[name="location_name"]').val(location_data.location_name);
                $('input[name="address"]').val( location_data.address);
                //$('input[name="country"]').val(location_data.country);
                 $('option[value="'+location_data.country+'"]', $('#cntry')).prop('selected', true);

                 $('#cntry').multiselect('refresh');
                $('input[name="city"]').val(location_data.city);
                $('input[name="zip"]').val(location_data.zip);
                 $('input[name="state"]').val(location_data.state);
                $('input[name="loc_main_phone"]').val(location_data.loc_main_phone);
                $('input[name="back_line_phone"]').val(location_data.back_line_phone);
                $('input[name="primary_fax"]').val(location_data.primary_fax);
                $('input[name="secondary_fax"]').val(location_data.secondary_fax);
                (location_data.default_==1) ? $('input[name="default"]').prop('checked',true):$('input[name="default"]').prop('checked',false); 
                

                $('#add_loc_btn').html('');
                $('#add_loc_btn').append('<a href="javascript:;" onclick="save_location('+id+')"  class="btn btn-lg btn-success btn-block">Save Location</a>');

               }
           
        });
        


      }

      //on click delete btn at panel right it deletes the location object from objects array.
      function pop_loc_obj(id)
      {
        //delete the item
        $.each(loc_arr,function(index,location_data) {
          
            if(location_data.loc_id==id)
            {

                loc_arr.splice(index, 1);
                //delete loc_arr[index];

            }
           
        });
        //delete loc_arr['loc_'+id];
        //loc_arr.splice('loc_'+id, 1);
        $('#panel_'+id).remove();
        $('#location_inputs').find('input[type="text"]').val('');
        
      }

      //Save the edited location to objects array.
      function save_location(id)
      {
        $.each(loc_arr,function(index,location_data) {
           //console.log(this);
           //return false;
            if(location_data.loc_id==id)
            {
                loc_arr.splice(index, 1);
                return false;
                //delete loc_arr[index];

            }
          
        });
       
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
        //$.toArray(loc_arr);
            $('#cnt_location').empty(); 
            if(loc_arr.length>0) 
            {
                $.each(loc_arr,function(index, location_data) {  
                        //console.log(el); 
                    $('#cnt_location').append($("<option></option>")
                             .attr("value",index)
                             .text( location_data.location_name)); 
                   
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
    
    var indexx=0;
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
             index__ = indexx++;
            //populate contact object with value
            contact={
                cntct_id:index__,
                f_name: $('input[name="f_name"]').val(),
                l_name: $('input[name="l_name"]').val(),
                email: $('input[name="email"]').val(),
                title_: $('input[name="title"]').val(),
                contact_phone: $('input[name="contact_phone"]').val(),
                contact_mobile: $('input[name="contact_mobile"]').val(),
                contact_location: $('#cnt_location option:selected').text(),
                contact_poc: ($('#chk_poc').is( ":checked" )) ? 1 : 0,
                contact_location_index: $('#cnt_location').val()

            };
 /*     <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Removable</h3>
                  <div class="box-tools pull-right">
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  The body of the box
                </div><!-- /.box-body -->
              </div>*/
            
            //location panel append at the end
            $('#contact_labels').append('<div class="form-group col-lg-4" id="panel_ct_'+index__+'"><div class="box box-success box-solid" ><div class="box-header with-border"><h3 class="box-title">'+contact.f_name+' '+contact.l_name+'</h3><div class="box-tools pull-right"><a href="javascript:;" class="btn btn-box-tool" onclick="load_cntct_obj('+index__+')"><i class="fa fa-pencil"></i></a><a href="javascript:;" class="btn btn-box-tool" onclick="pop_cntct_obj('+index__+')"><i class="fa fa-times-circle"></i></a></div><div class="clearfix"></div></div><div class="box-body"><label>Email:</label>'+contact.email+'<br><label>Title:</label>'+contact.title_+'<br><label>Phone:</label>'+contact.contact_phone+'<br><label>Mobile:</label>'+contact.contact_mobile+'<br><label>Location:</label>'+contact.contact_location+'<br><label>Is Poc:</label>'+((contact.contact_poc==1)? "Yes":"No")+'<br></div></div></div>');

            cntct_arr.push(contact);
            //reset the form input values.
            $('#contact_inputs').find('input[type="text"]').val('');
            $("#chk_poc").prop('checked',false);
            //$('#cnt_email').val('');
        }
      }



      //on click edit btn at panel right it loads the location object values in form
      function load_cntct_obj(id)
      {
        $.each(cntct_arr,function(index,contact_data) {
          
               if(contact_data.cntct_id==id)
               {

                $('input[name="f_name"]').val(contact_data.f_name);
                $('input[name="l_name"]').val(contact_data.l_name);
                $('input[name="email"]').val(contact_data.email);
                $('input[name="title"]').val(contact_data.title_);
                $('input[name="contact_phone"]').val(contact_data.contact_phone);
                $('input[name="contact_mobile"]').val(contact_data.contact_mobile);
                (contact_data.contact_poc==1) ? $("#chk_poc").prop('checked',true):$("#chk_poc").prop('checked',false); 
                //$('#cnt_location option[value="'+contact_data.contact_location_index+'"]').attr("selected", "selected");
                 $('option[value="'+contact_data.contact_location_index+'"]', $('#cnt_location')).prop('selected', true);

                 $('#cnt_location').multiselect('refresh');

                // change the button value to save location and call the func save_location
                $('#add_cntct_btn').html('');
                $('#add_cntct_btn').append('<a href="javascript:;" onclick="save_contact('+id+')"  class="btn btn-lg btn-success btn-block">Save Contact</a>');
               }
           
        });
      

      }


      function pop_cntct_obj(id)
      {
        //delete the item

        //delete the item
        $.each(cntct_arr,function(index,contact_data) {
          
            if(contact_data.cntct_id==id)
            {

                cntct_arr.splice(index, 1);
                //delete loc_arr[index];

            }
           
        });
        
        $('#panel_ct_'+id).remove();
        $('#contact_inputs').find('input[type="text"]').val('');
        
      }


      //Save the edited location to objects array.
      function save_contact(id)
      {
         //delete the old object from array
         $.each(cntct_arr,function(index,contact_data) {
          
            if(contact_data.cntct_id==id)
            {

                cntct_arr.splice(index, 1);
                return false;
                //delete loc_arr[index];

            }
           
        });

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