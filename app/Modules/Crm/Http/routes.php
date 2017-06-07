<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::group(['prefix' => 'crm'], function() {
	Route::get('/', function() {
		dd('This is the Crm module index page.');
	});
});*/

Route::get('/user_files/{folder}/_thumb/{filename}', ['as'=>'get.user_files.thumb', 'uses' => 'FilemanagerController@retrieveThumb'])->where('filename', '.+');

Route::get('/user_files/{folder}/{filename}', ['as'=>'get.user_files.file', 'uses' => 'FilemanagerController@retrieveFile'])->where('filename', '.+');
//Route::get('view/{template}', 'EngineController@view')->where('template', '.+');


Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {




    Route::group(['prefix' => 'crm','middleware' => ['role:admin|manager|technician']], function () {

        Route::controller('/filemanager', 'FilemanagerController');
        //Connection

        Route::get('/ajax_get_active_customers', ['as'=>'admin.crm.ajax_get_active_customers','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@listAjaxActiveCustomers']);


        Route::get('/', ['as'=>'admin.crm.index','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@index']);
        Route::get('/import', ['as'=>'admin.zoho.import','middleware' => ['permission:add_customer'], 'uses' => 'ZohoController@import']);

        Route::post('/show_custs', ['as'=>'admin.crm.show_custs','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@setSessionShowCusts']);


        Route::get('/data_index', ['as'=>'admin.crm.data_index','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@ajaxDataIndex']);
        Route::get('create', ['as'=>'admin.crm.create','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@create']);
        Route::post('/', ['as'=>'admin.crm.store','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@store']);
        Route::get('edit/{id}', ['as'=>'admin.crm.edit','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@edit']);
        Route::get('show/{id}', ['as'=>'admin.crm.show','middleware' => ['permission:view_customer_detail'], 'uses' => 'CrmController@show']);
        Route::delete('delete', ['as'=>'admin.crm.destroy','middleware' => ['permission:delete_customer'], 'uses' => 'CrmController@destroy']);
        Route::put('/{id}', ['as'=>'admin.crm.update','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@update']);

        Route::post('/ajax_data_load', ['as'=>'admin.crm.ajax.load_items','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@ajaxDataLoad']);

        Route::post('/ajax_add_product_tag', ['as'=>'admin.crm.ajax.add_p_tag','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@ajaxAddProductTag']);


        Route::get('/ajax_contacts_list/{id}', ['middleware' => ['permission:add_customer'], 'uses' => 'CrmController@ajaxGetSelectContacts']);

        Route::get('search_customers', ['as'=>'admin.crm.search.customers','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@searchCustomers']);

        Route::get('search_locations', ['as'=>'admin.crm.search.locations','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@searchLocations']);

        Route::get('search_cust_contacts', ['as'=>'admin.crm.ajax.search.cust.contacts','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@searchLocationContacts']);

        /********************************************************* Customer info *****************************/
        Route::get('/ajax_load_customer_info/{id}', ['as'=>'admin.crm.ajax.load_customer_info','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadInfo']);

        Route::post('/ajax_update_customer_info', ['as'=>'admin.crm.ajax.update_customer_info','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateInfo']);

        Route::get('/ajax_refresh_info/{id}', ['as'=>'admin.crm.ajax.refresh_info','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxRefreshInfo']);

        Route::post('/ajax_customers_contacts', ['as'=>'admin.crm.ajax.get_contacts','middleware' => ['permission:edit_customer'], 'uses' => 'TicketController@ajaxGetContacts']);
        /********************************************************* Customer info *****************************/


        /********************************************************* Locations *****************************/

        Route::post('/ajax_load_location', ['as'=>'admin.crm.ajax.load_location','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadLocation']);

        Route::post('/ajax_update_location', ['as'=>'admin.crm.ajax.update_location','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateLocation']);

        Route::post('/ajax_add_location', ['as'=>'admin.crm.ajax.add_location','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@ajaxAddLocation']);

        Route::get('/ajax_get_locations_list/{id}', ['as'=>'admin.crm.ajax.get_locations_list','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxGetLocationsList']);

        Route::get('/ajax_list_locations/{id}', ['as'=>'admin.crm.ajax.list_locations','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxListLocation']);

        Route::post('/ajax_del_location', ['as'=>'admin.crm.ajax.del_location','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteLocation']);

        /********************************************************* Locations *****************************/


        /********************************************************* contacts *****************************/

        Route::post('/ajax_load_contact', ['as'=>'admin.crm.ajax.load_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadContact']);

        Route::post('/ajax_update_contact', ['as'=>'admin.crm.ajax.update_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateContact']);

        Route::get('/ajax_refresh_contacts/{id}', ['as'=>'admin.crm.ajax.refresh_contacts','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxRefreshContacts']);

        Route::post('/ajax_add_contact', ['as'=>'admin.crm.ajax.add_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxAddContact']);

        Route::post('/ajax_del_contact', ['as'=>'admin.crm.ajax.del_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteContact']);

        Route::get('/ajax_click_call/{id}/{exten}/{customer_id}/{is_save}', ['as'=>'admin.crm.ajax.click_call','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxClicktoCall']);


        /********************************************************* contacts *****************************/


        /********************************************************* service items *****************************/

        Route::get('/list_service_items/{id}', ['as'=>'admin.crm.ajax.list_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxListServiceItem']);

        Route::post('/ajax_load_service_item', ['as'=>'admin.crm.ajax.load_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadServiceItem']);

        Route::post('/ajax_update_service_item', ['as'=>'admin.crm.ajax.update_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateServiceItem']);

        Route::get('/load_new_service_item/{id}', ['as'=>'admin.crm.ajax.load_new_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadNewServiceItem']);

        Route::post('/add_service_item', ['as'=>'admin.crm.ajax.add_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxAddServiceItem']);

        Route::get('/ajax_del_sitem/{id}/{cid}', ['as'=>'admin.crm.ajax.del_sitem','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteServiceItem']);

        /********************************************************* service items *****************************/



        /********************************************************* rates *****************************/
        Route::get('/list_rates/{id}', ['as'=>'admin.crm.ajax.list_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxListRate']);

        Route::get('/ajax_load_rate/{id}', ['as'=>'admin.crm.ajax.get_load_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadRate']);

        Route::post('/ajax_update_rate', ['as'=>'admin.crm.ajax.update_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateRate']);

        Route::post('/ajax_add_rate', ['as'=>'admin.crm.ajax.add_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxAddRate']);

        Route::get('/ajax_del_rate/{id}/{sid}', ['as'=>'admin.crm.ajax.del_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteRate']);

        /********************************************************* rates *****************************/


      /********************************************************* Ajax *****************************/

        Route::get('/ajax_get_select_contacts/{id}', ['as'=>'admin.crm.ajax.get_select_contacts','middleware' => ['permission:edit_customer'], 'uses' => 'AjaxController@getSelect2Contacts']);

        Route::get('/ajax_get_select_locations/{id}', ['as'=>'admin.crm.ajax.get_select_locations','middleware' => ['permission:edit_customer'], 'uses' => 'AjaxController@getSelect2Locations']);

        Route::get('/ajax_get_select_techs', ['as'=>'admin.crm.ajax.get_select_techs','middleware' => ['permission:edit_customer'], 'uses' => 'AjaxController@getSelect2Techs']);

        Route::post('/save_customer', ['as'=>'admin.crm.customer_save','middleware' => ['permission:edit_customer'], 'uses' => 'AjaxController@updateCustomer']);

        Route::group(['prefix' => 'ticket'], function () {
            Route::get('ajax_get_select_statuses', ['as'=>'admin.ticket.get_select_statuses','middleware' => ['permission:list_ticket'], 'uses' => 'AjaxController@getSelect2Statuses']);
            Route::get('ajax_get_select_service_items/{id}', ['as'=>'admin.ticket.get_select_service_items','middleware' => ['permission:list_ticket'], 'uses' => 'AjaxController@getSelect2ServiceItems']);
        });

        Route::group(['prefix' => 'note'], function () {
            Route::get('get_list/{id}', ['as'=>'admin.crm.note.list','middleware' => ['permission:list_note'], 'uses' => 'AjaxController@getCustomerNotes']);
            Route::post('create', ['as'=>'admin.crm.note.create','middleware' => ['permission:create_note'], 'uses' => 'AjaxController@createCustomerNote']);


            Route::get('handsontable', ['as'=>'admin.crm.note.handsontable', 'uses' => 'AjaxController@displayDataHtable']);

            //Route::post('handsontable_save', ['as'=>'admin.crm.note.handsontable_save', 'uses' => 'AjaxController@saveDataHtable']);
        });

        Route::post('send_email', ['as'=>'admin.crm.email.send','middleware' => ['permission:create_note'], 'uses' => 'AjaxController@sendEmails']);

        Route::post('add_ticket', ['as'=>'admin.crm.add.ticket','middleware' => ['permission:create_note'], 'uses' => 'TicketController@addTicket']);

        Route::group(['prefix' => 'appointment'], function () {

            Route::post('post_event', ['as'=>'admin.crm.appointment.post','middleware' => ['permission:create_note'], 'uses' => 'AppointmentController@postEvent']);

            Route::post('update_event', ['as'=>'admin.crm.appointment.update','middleware' => ['permission:create_note'], 'uses' => 'AppointmentController@updateEvent']);

            Route::post('delete_event', ['as'=>'admin.crm.appointment.delete','middleware' => ['permission:create_note'], 'uses' => 'AppointmentController@deleteEvent']);



            Route::get('/get_appointment_by_id/{id}', ['as'=>'admin.crm.appointment.get_by_id','middleware' => ['permission:create_note'], 'uses' => 'AppointmentController@getAppointmentById']);

            Route::get('edit/{id}/{cust_id}', ['as'=>'admin.crm.appointment.edit','middleware' => ['permission:create_note'], 'uses' => 'AppointmentController@editEvent']);



            Route::get('/get_event_by_id/{id}', ['as'=>'admin.crm.appointment.get_event_by_id','middleware' => ['permission:create_note'], 'uses' => 'AppointmentController@getEventById']);
        });


        /*****************************Notes*************************/


        Route::group(['prefix' => 'notes'], function () {

            Route::get('/', ['as'=>'admin.crm.notes.index','middleware' => ['permission:list_notes'], 'uses' => 'NotesController@index']);
                Route::get('/single/{id}', ['as'=>'admin.crm.note.single','middleware' => ['permission:list_notes'], 'uses' => 'NotesController@getNote']);
            Route::get('/notes_dt_index_active', ['as'=>'admin.crm.notes.data_index_active','middleware' => ['permission:list_notes'], 'uses' => 'NotesController@DtIndexActive']);
            Route::get('/notes_dt_index_archived', ['as'=>'admin.crm.notes.data_index_archived','middleware' => ['permission:list_notes'], 'uses' => 'NotesController@DtIndexArchived']);
            Route::post('pin_status_change', ['as'=>'admin.crm.note.pin_status_change','middleware' => ['permission:create_note'], 'uses' => 'NotesController@changePinStatus']);
            Route::post('archive_status_change', ['as'=>'admin.crm.note.archive_status_change','middleware' => ['permission:create_note'], 'uses' => 'NotesController@changeArchiveStatus']);
            Route::post('delete', ['as'=>'admin.crm.note.delete','middleware' => ['permission:create_note'], 'uses' => 'NotesController@delete']);


                Route::post('update_editable', ['as'=>'admin.crm.ajax.note.update_editable','middleware' => ['permission:create_note'], 'uses' => 'NotesController@updateEditable']);


                Route::post('update_note', ['as'=>'admin.crm.ajax.note.update','middleware' => ['permission:create_note'], 'uses' => 'NotesController@updateNote']);




            Route::get('notes_json/{type}', ['as'=>'admin.crm.notes.json','middleware' => ['permission:list_notes'], 'uses' => 'NotesController@getNotesJson']);
            Route::post('save_excel', ['as'=>'admin.crm.ajax.note.save_excel','middleware' => ['permission:create_note'], 'uses' => 'NotesController@saveDataExcel']);

            Route::post('update_excel', ['as'=>'admin.crm.ajax.note.update_excel','middleware' => ['permission:create_note'], 'uses' => 'NotesController@updateDataExcel']);

            Route::get('excel_notes_json/{type}', ['as'=>'admin.crm.excel.notes.json','middleware' => ['permission:list_notes'], 'uses' => 'NotesController@getExcelNotesJson']);
            Route::get('get_excel_note/{id}', ['as'=>'admin.crm.excel.get.note','middleware' => ['permission:list_notes'], 'uses' => 'NotesController@getExcelData']);
        });
        /********************************End Notes****************/

      /********************************************************* Angular *****************************/

        Route::group(['prefix' => 'api/v1/contacts'], function () {
            Route::get('/{id}', ['middleware' => ['permission:view_customer_detail'], 'uses' => 'CrmController@angularList']);
            //Route::post('create', ['as'=>'admin.crm.note.create','middleware' => ['permission:create_note'], 'uses' => 'AjaxController@createCustomerNote']);
        });

      /********************************************************* Angular *****************************/


        /********************************************************* Zoho  *****************************/

        Route::group(['prefix' => 'api/v1/invoices'], function () {
            Route::get('/{id}/{status?}', ['as'=>'admin.crm.api.invoices','middleware' => ['permission:zoho_view_invoices'], 'uses' => 'ZohoController@apiGetInvoices']);
        });

        Route::group(['prefix' => 'api/v1/recurringinvoices'], function () {
            Route::get('/{id}/{status?}', ['as'=>'admin.crm.api.recurringinvoices','middleware' => ['permission:zoho_view_invoices'], 'uses' => 'ZohoController@apiGetRecurringInvoices']);
        });

        Route::group(['prefix' => 'api/v1/accountstanding'], function () {
            Route::get('/{id}', ['as'=>'admin.crm.api.accountstanding','middleware' => ['permission:zoho_admin'], 'uses' => 'ZohoController@apiGetCustomerStanding']);
        });

        Route::get('/ajax_customer_export_zoho/{id}', ['as'=>'admin.crm.ajax.customer_export_zoho','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@ajaxExportContact']);

        Route::get('/zoho_credentials', ['as'=>'admin.crm.zoho_credentials','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@getForm']);
        //Route::post('/zoho_store',['as'=>'admin.crm.zoho_store','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@zohoStore']);

        //Route::get('/zoho_reset_token',['as'=>'admin.crm.zoho_reset_token','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@resetAuthToken']);
        Route::get('/zoho_get_contacts', ['as'=>'admin.crm.zoho_get_contacts','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@getContacts']);
        Route::get('/zoho_get_expenses/{id}', ['as'=>'admin.crm.zoho_get_expenses','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@getExpense']);


        Route::get('/get_zoho_contacts', ['as'=>'admin.crm.get_zoho_contacts','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@getZohoContacts']);
        Route::get('/list_unimported', ['as'=>'admin.crm.list_unimported','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@listZohoUnimportedContacts']);
        Route::post('/import_selected', ['as'=>'admin.crm.import_selected','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@importSelectedContacts']);




        /********************************************************* Zoho *****************************/


        //default rates



        Route::group(['prefix' => 'ticket'], function () {
            Route::get('/', ['as'=>'admin.ticket.index','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@index']);
            //Route::get('/by_cust_id/{id}', ['as'=>'admin.ticket.index_by_cust_id','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@index']);

            Route::get('/ajax_ticket/{id}', ['as'=>'admin.ticket.ajax_ticket','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@ajaxGetTicketById']);

            Route::post('/', ['as'=>'admin.ticket.index_post','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@index']);

            //Route::get('/data_index', ['as'=>'admin.ticket.data_index','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@ajaxDataIndex']);

            //Route::get('/data_index_by_cust/{id}', ['as'=>'admin.ticket.data_index_by_cust','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@ajaxDataIndex']);


            Route::get('create', ['as'=>'admin.ticket.create','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@create']);
            Route::post('create', ['as'=>'admin.ticket.store','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@store']);
            Route::get('list_own', ['as'=>'admin.ticket.list_own','middleware' => ['permission:list_assigned_ticket'], 'uses' => 'TicketController@listOwn']);

            Route::get('show/{id}', ['as'=>'admin.ticket.show','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@show']);

            Route::get('ajax_get_service_items/{id}', ['as'=>'admin.ticket.ajax_get_service_items','middleware' => ['permission:create_ticket'], 'uses' => 'CrmController@ajaxGetServiceItems']);

            Route::post('upload', ['as'=>'admin.ticket.upload','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxUploadImage']);
            Route::post('ajax_del_img', ['as'=>'admin.ticket.ajax_del_img','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxDeleteImage']);

            Route::post('add_response', ['as'=>'admin.ticket.add_response','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@addResponse']);

            Route::get('getEmails', ['as'=>'admin.ticket.get_emails','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@readGmail']);

            Route::delete('delete', ['as'=>'admin.ticket.destroy','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'TicketController@destroy']);

            Route::post('/multi_delete', ['as'=>'admin.crm.ajax.ticket_multi_delete','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@destroyMultiple']);
            //Route::post('/',['as'=>'admin.ticket.store','middleware' => ['permission:customer_service_type_add'], 'uses' => 'TicketController@store']);

            Route::post('assign_users', ['as'=>'admin.crm.ajax.ticket_assign_users','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxAssignUsers']);
            Route::post('assign_multi_users', ['as'=>'admin.crm.ajax.multi_ticket_assign_users','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxAssignUsersMultiple']);
            Route::get('delete_user_assigned/{uid}/{tid}', ['as'=>'admin.crm.ajax.ticket_delete_assigned_user','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'TicketController@ajaxDeleteAssignedUser']);
            Route::get('delete_customer_assigned/{tid}', ['as'=>'admin.crm.ajax.ticket_delete_assigned_customer','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'TicketController@ajaxDeleteAssignedCustomer']);


            Route::post('status_priority', ['as'=>'admin.crm.ajax.ticket_priority_status','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxUpdateStatusPriority']);
            Route::post('update_title', ['as'=>'admin.crm.ajax.update_title','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxUpdateTitle']);


            Route::post('multi_status', ['as'=>'admin.crm.ajax.multi_ticket_status','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxUpdateStatusMultiple']);

            Route::post('multi_priority', ['as'=>'admin.crm.ajax.multi_ticket_priority','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxUpdatePriorityMultiple']);

            Route::post('assign_customer', ['as'=>'admin.crm.ajax.ticket_assign_customer','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxAssignCustomer']);

            Route::get('search_tickets', ['as'=>'admin.crm.ajax.search.tickets','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@searchTickets']);
        });



        Route::group(['prefix' => 'ticketstatus'], function () {
            Route::get('/', ['as'=>'admin.ticket.status.index','middleware' => ['permission:list_ticket_status'], 'uses' => 'TicketsStatus@index']);
            Route::get('create', ['as'=>'admin.ticket.status.create','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@create']);
            Route::get('edit/{id}', ['as'=>'admin.ticket.status.edit','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@edit']);

            //Route::post('create', ['as'=>'admin.ticket.store','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@store']);
            Route::post('store', ['as'=>'admin.ticket.status.store','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@store']);
            Route::post('/update', ['as'=>'admin.ticket.status.update','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@update']);
            Route::get('/status_list', ['as'=>'admin.tickets.status.list', 'uses' => 'TicketsStatus@index']);

            Route::post('delete_ticket_status', ['as'=>'admin.tickets.status.delete', 'middleware' => ['permission:delete_ticket_status'],'uses' => 'TicketsStatus@ajaxDelete']);
        });

        Route::group(['prefix' => 'service'], function () {
            Route::get('/', ['as'=>'admin.service_item.index','middleware' => ['permission:customer_service_type_list'], 'uses' => 'ServiceItemsController@index']);
            Route::get('create', ['as'=>'admin.service_item.create','middleware' => ['permission:customer_service_type_add'], 'uses' => 'ServiceItemsController@create']);
            Route::get('delete/{id}', ['as'=>'admin.service_item.destroy','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'ServiceItemsController@destroy']);
            Route::post('/', ['as'=>'admin.service_item.store','middleware' => ['permission:customer_service_type_add'], 'uses' => 'ServiceItemsController@store']);
        });


        // Calendar
        Route::group(['prefix' => 'calendar'], function () {
            Route::get('eventlist', ['as'=>'admin.crm.calendar.eventlist','middleware' => ['permission:view_customer_detail'], 'uses' => 'CrmController@ajaxCalGetEvents']);
        });


        Route::get('contacts_by_loc/{loc_id}', ['as'=>'admin.crm.contacts_by_loc','middleware' => ['permission:customer_service_type_add'], 'uses' => 'TicketController@getContactsByLoc']);
    });



    //Route::resource('/crm','EmployeeController');
    //Route::resource('/raise','RaiseController');

    //Route::get('calander','EmployeeController@googleCalander');
});
