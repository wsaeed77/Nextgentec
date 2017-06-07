<script type="text/javascript">


    //var contact_arr = [];
    var index__ = 0;

 



    var cntct_arr = [];
    
    var indexx=0;
  //first click on add location
   function add_contact(id=null)
      {
         
        var contact =  new Object();
         index__ = indexx++;

         //if id is not null, it means that its edit/update time, so take the edit form data only
            if(id !== null)
            {
                     //populate contact object with value
                    contact={
                              cntct_id:index__,
                              f_name: $('#modal-add-edit-contact').find($('input[name="f_name"]')).val(),
                              l_name: $('#modal-add-edit-contact').find($('input[name="l_name"]')).val(),
                              email: $('#modal-add-edit-contact').find($('input[name="email"]')).val(),
                              title_: $('#modal-add-edit-contact').find($('input[name="title"]')).val(),
                              contact_phone: $('#modal-add-edit-contact').find($('input[name="contact_phone"]')).val(),
                              contact_mobile: $('#modal-add-edit-contact').find($('input[name="contact_mobile"]')).val()
                            };
            }
            else
            {
              //populate contact object with value
                    contact={
                        cntct_id:index__,
                        f_name: $('#modal-add-new-contact').find($('input[name="f_name"]')).val(),
                        l_name: $('#modal-add-new-contact').find($('input[name="l_name"]')).val(),
                        email: $('#modal-add-new-contact').find($('input[name="email"]')).val(),
                        title_: $('#modal-add-new-contact').find($('input[name="title"]')).val(),
                        contact_phone: $('#modal-add-new-contact').find($('input[name="contact_phone"]')).val(),
                        contact_mobile: $('#modal-add-new-contact').find($('input[name="contact_mobile"]')).val()
                    

                    };
            }
       
        
 

             $('#cntct_tbody').append('<tr id="cntct_tr_'+index__+'"><td>'+contact.f_name+'</td><td>'+contact.l_name+'</td><td>'+contact.title_+'</td><td>'+contact.email+'</td><td>'+contact.contact_phone+'</td><td>'+contact.contact_mobile+'</td><td><a href="javascript:;" class="btn btn-box-tool" onclick="load_cntct_obj('+index__+')"><i class="fa fa-pencil"></i></a><a href="javascript:;" class="btn btn-box-tool" onclick="pop_cntct_obj('+index__+')"><i class="fa fa-times-circle"></i></a></td></tr>');


            cntct_arr.push(contact);
         
            return true;
       
      }



      //on click edit btn at panel right it loads the location object values in form
      function load_cntct_obj(id)
      {
          $('#modal-add-edit-contact').modal('show');

        $.each(cntct_arr,function(index,contact_data) {
          
               if(contact_data.cntct_id==id)
               {

                $('input[name="f_name"]').val(contact_data.f_name);
                $('input[name="l_name"]').val(contact_data.l_name);
                $('input[name="email"]').val(contact_data.email);
                $('input[name="edit_cnt_id"]').val(id);
                $('input[name="title"]').val(contact_data.title_);
                $('input[name="contact_phone"]').val(contact_data.contact_phone);
                $('input[name="contact_mobile"]').val(contact_data.contact_mobile);
               
               }
           
        });
      

      }


      function pop_cntct_obj(id)
      {
        //delete the item

        $.each(cntct_arr,function(index,contact_data) {
         
            if(contact_data.cntct_id==id)
            {

                cntct_arr.splice(index, 1);
                //delete loc_arr[index];

            }
           
        });
        
        $('#cntct_tr_'+id).remove();
       
        
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
        //console.log('jjjj'+id);
         //add the edited data and reset the form
        var flag_ =  add_contact(id);
        
         // remove the tr also
         if(flag_)
          $('#cntct_tr_'+id).remove();
        return flag_;

      }
      /*********************End Contacts step***************/


       var cust_arr = [];
    
    var cust_index=0;
  //first click on add location
   function add_customer(id=null)
      {
        /*for ( instance in CKEDITOR.instances )
                 CKEDITOR.instances[instance].updateElement();*/
         
        var customer =  new Object();
         index__ = cust_index++;

         //if id is not null, it means that its edit/update time, so take the edit form data only
            if(id !== null)
            {
                     //populate contact object with value
                    customer={
                              cust_id:index__,
                              customer:     $('#modal-edit-customer').find($('#cust_edit_cust_id option:selected')).text(),
                              customer_selected_id: $('#modal-edit-customer').find($('#cust_edit_cust_id option:selected')).val(),
                              location:     $('#modal-edit-customer').find($('#edit_location option:selected')).text(),
                              customer_location_id: $('#modal-edit-customer').find($('#edit_location option:selected')).val(),
                              auth_name:    $('#modal-edit-customer').find($('input[name="auth_contact_name"]')).val(),
                              phone:        $('#modal-edit-customer').find($('input[name="cust_phone"]')).val(),
                              account_num:  $('#modal-edit-customer').find($('input[name="account_number"]')).val(),
                              portal_url:   $('#modal-edit-customer').find($('input[name="portal_url"]')).val(),
                              username:     $('#modal-edit-customer').find($('input[name="cust_user_name"]')).val(),
                              password:     $('#modal-edit-customer').find($('input[name="cust_password"]')).val(),
                              notes:        $('#modal-edit-customer').find($('textarea[name="customer_notes"]')).val()
                            };
            }
            else
            {
              //populate contact object with value
                    customer={
                              cust_id:index__,
                              customer: $('#modal-add-new-customer').find($('#cust_add_cust_id option:selected')).text(),
                              customer_selected_id: $('#modal-add-new-customer').find($('#cust_add_cust_id option:selected')).val(),
                              location: $('#modal-add-new-customer').find($('#location option:selected')).text(),
                              customer_location_id: $('#modal-add-new-customer').find($('#location option:selected')).val(),
                              auth_name: $('#modal-add-new-customer').find($('input[name="auth_contact_name"]')).val(),
                              phone: $('#modal-add-new-customer').find($('input[name="cust_phone"]')).val(),
                              account_num: $('#modal-add-new-customer').find($('input[name="account_number"]')).val(),
                              portal_url: $('#modal-add-new-customer').find($('input[name="portal_url"]')).val(),
                              username: $('#modal-add-new-customer').find($('input[name="cust_user_name"]')).val(),
                              password: $('#modal-add-new-customer').find($('input[name="cust_password"]')).val(),
                              notes: $('#modal-add-new-customer').find($('textarea[name="customer_notes"]')).val()
                            };
            }
       
        
 

             $('#cust_tbody').append('<tr id="customer_tr_'+index__+'"><td>'+customer.customer+'</td><td>'+customer.location+'</td><td>'+customer.auth_name+'</td><td>'+customer.account_num+'</td><td>'+customer.phone+'</td><td>'+customer.username+'</td><td>'+customer.password+'</td><td><a href="javascript:;" class="btn btn-box-tool" onclick="load_cust_obj('+index__+')"><i class="fa fa-pencil"></i></a><a href="javascript:;" class="btn btn-box-tool" onclick="pop_cust_obj('+index__+')" ><i class="fa fa-times-circle"></i></a></td></tr>');


            cust_arr.push(customer);
         
            return true;
       
      }


       function load_cust_obj(id)
      {
          $('#modal-edit-customer').modal('show');

        $.each(cust_arr,function(index,cust) {
          
               if(cust.cust_id==id)
               {
                 $('option[value="'+cust.customer_selected_id+'"]', $('#cust_edit_cust_id')).prop('selected', true);

                 

                 $('#cust_edit_cust_id').multiselect('refresh');
                 

                 $('input[name="edit_cust_id"]').val(id);
                   
                  $('#modal-edit-customer').find($('input[name="auth_contact_name"]')).val(cust.auth_name);
                  $('#modal-edit-customer').find($('input[name="cust_phone"]')).val(cust.phone);
                  $('#modal-edit-customer').find($('input[name="account_number"]')).val(cust.account_num);
                  $('#modal-edit-customer').find($('input[name="portal_url"]')).val(cust.portal_url);
                  $('#modal-edit-customer').find($('input[name="cust_user_name"]')).val(cust.username);
                  $('#modal-edit-customer').find($('input[name="cust_password"]')).val(cust.password);
                  $('#modal-edit-customer').find($('textarea[name="customer_notes"]')).val(cust.notes);


                  $.get('/admin/crm/ajax_get_locations_list/'+cust.customer_selected_id,function(response) {

                    $('#edit_location').html('');
                    $('#edit_location').multiselect('enable');
                     $('#edit_location').append($("<option></option>")
                                         .attr("value",'')
                                         .text('Select location'));
                            $.each(response.locations,function(index, location_data) {
                                    //console.log(location_data);
                                $('#edit_location').append($("<option></option>")
                                         .attr("value",location_data.id)
                                         .text( location_data.location_name));

                            });
                            $('option[value="'+cust.customer_location_id+'"]', $('#edit_location')).prop('selected', true);
                            $('#edit_location').multiselect('rebuild');


                            $('#edit_location').multiselect('refresh');

                  },'json');

               
               }
           
        });
      

      }


       //Save the edited location to objects array.
      function save_customer(id)
      {
         //delete the old object from array
         $.each(cust_arr,function(index,cust) {
          
            if(cust.cust_id==id)
            {
                //console.log(cust_id);
                cust_arr.splice(index, 1);
                return false;
                //delete loc_arr[index];

            }
           
        });
       // console.log(id);
         //add the edited data and reset the form
        var flag_ =  add_customer(id);
        //console.log(flag_);
         // remove the tr also
         if(flag_)
          $('#customer_tr_'+id).remove();
        return flag_;

      }


        function pop_cust_obj(id)
      {
        //delete the item

        $.each(cust_arr,function(index,cust) {
         
            if(cust.cust_id==id)
            {

                cust_arr.splice(index, 1);
                //delete loc_arr[index];

            }
           
        });
        
        $('#customer_tr_'+id).remove();
       
        
      }


</script>