<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'AdminController@getLogin');
Route::get('admin/login', 'AdminController@getLogin');
Route::post('admin/login', 'AdminController@postLogin');
Route::get('admin/logout', ['as'=>'admin.logout', 'uses' =>  'AdminController@getLogout']);

Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {
    Route::get('dashboard', ['as'=>'admin.dashboard', 'uses' => 'AdminController@showDashboard']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('user', 'UserController');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('role', 'RoleController');
        Route::post('/update', ['as'=>'admin.role.update', 'uses' => 'RoleController@update']);
        Route::get('role/delete/{id}', ['as'=>'admin.role.delete', 'uses' => 'RoleController@destroy']);
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('permissions', 'PermissionsController');
        Route::get('/permissions_list', ['as'=>'admin.permissions.list', 'uses' => 'PermissionsController@ajaxDataIndex']);
        Route::get('permission_del_ajax/{id}', ['as'=>'admin.permissions.del_ajax', 'uses' => 'PermissionsController@ajaxDelete']);
        Route::post('/update', ['as'=>'admin.permissions.update', 'uses' => 'PermissionsController@update']);
    });

  // Admin Settings Routing
    Route::group(['prefix'=>'settings','middleware' => ['role:admin']], function () {

        Route::group(['prefix'=>'general'], function () {
            Route::get('system', ['as'=>'admin.setting.general.system', 'uses' => 'SettingController@system']);
            Route::post('system/save', ['as'=>'admin.setting.system.save', 'uses' => 'SettingController@systemSave']);
        });

        Route::group(['prefix'=>'staff'], function () {
            Route::get('employees', ['as'=>'admin.setting.staff.employees','middleware' => ['permission:list_employee'], 'uses' => '\App\Modules\Employee\Http\Controllers\EmployeeController@index']);
            Route::get('permissions', ['as'=>'admin.setting.permissions', 'uses' => 'SettingController@permissions']);
        });
        Route::get('/ticketing/statuses', ['as'=>'admin.setting.ticketing.statuses', 'uses' => '\App\Modules\Crm\Http\Controllers\TicketsStatus@index']);

        Route::group(['prefix'=>'crm'], function () {


            /******server vitual types settings***/

            Route::get('asset_server_vitual_types', ['as'=>'admin.setting.crm.assets.asset_server_virtual_types','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@assetServerVTypesSettingsDisplay']);

            Route::get('/list_server_virtual_types', ['as'=>'admin.setting.crm.assets.list_server_virtual_types','middleware' => ['permission:list_assets'], 'uses' => 'SettingController@listServerVirtualTypes']);

            Route::post('/delete_server_virtual_type', ['as'=>'admin.setting.crm.assets.delete_server_virtual_type','middleware' => ['permission:list_assets'], 'uses' => 'SettingController@destroyServerVirtualType']);

            Route::post('/create_server_virtual_type', ['as'=>'admin.setting.crm.assets.create_server_virtual_type','middleware' => ['permission:list_assets'], 'uses' => 'SettingController@createServerVirtualType']);




            /******server roles settings***/
            Route::get('asset_server_roles', ['as'=>'admin.setting.crm.assets.asset_server_roles','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@assetServerRoleSettingsDisplay']);

            Route::get('/list_server_roles', ['as'=>'admin.setting.crm.assets.list_server_roles','middleware' => ['permission:list_assets'], 'uses' => 'SettingController@listServerRoles']);

            Route::post('/delete_server_role', ['as'=>'admin.setting.crm.assets.delete_server_role','middleware' => ['permission:list_assets'], 'uses' => 'SettingController@destroyServerRole']);

            Route::post('/create_server_role', ['as'=>'admin.setting.crm.assets.create_server_role','middleware' => ['permission:list_assets'], 'uses' => 'SettingController@createServerRole']);

            /*****gmail settings***/
            Route::get('gmail', ['as'=>'admin.setting.crm.integration.gmail','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@gmailSettingsDisplay']);

            Route::post('/gmail_api_update', ['as'=>'admin.setting.crm.integration.gmail_api_update', 'uses' => 'SettingController@gmailApiUpdate']);

            Route::get('/google_auth', ['as'=>'admin.setting.crm.integration.google_auth', 'uses' => 'SettingController@googleAuth']);

            Route::post('/imap_store', ['as'=>'admin.setting.crm.integration.imap_store', 'uses' => 'SettingController@imapStore']);

            Route::get('/imap', ['as'=>'admin.setting.crm.integration.imap', 'uses' => 'SettingController@imap']);

            Route::post('/smtp_store', ['as'=>'admin.setting.crm.integration.smtp_store', 'uses' => 'SettingController@smtpStore']);
            Route::get('/smtp', ['as'=>'admin.setting.crm.integration.smtp', 'uses' => 'SettingController@smtp']);

            Route::get('slack', ['as'=>'admin.setting.crm.integration.slack','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@slackSettingsDisplay']);

            Route::post('/slack_store', ['as'=>'admin.setting.crm.integration.slack_store','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@slackStore']);

            Route::get('/slack_token_request', ['as'=>'admin.setting.crm.slack_token_request', 'uses' => 'SettingController@slackTokenRequest']);

            Route::get('zoho', ['as'=>'admin.setting.crm.integration.zoho','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@zohoSettingsDisplay']);

            Route::post('/zoho_store', ['as'=>'admin.setting.crm.integration.zoho_store','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@zohoStore']);

            Route::get('/zoho_reset_token', ['as'=>'admin.setting.crm.integration.zoho_reset_token','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@resetAuthToken']);

            Route::get('billingperiods', ['as'=>'admin.setting.crm.billingperiods', 'uses' => 'SettingController@billingPeriods']);
            Route::post('billingperiods/delete', ['as'=>'admin.setting.crm.billingperiods.delete', 'uses' => 'SettingController@deleteBillingPeriod']);
            Route::post('billingperiods/create', ['as'=>'admin.setting.crm.billingperiods.create','middleware' => ['permission:customer_billing_add'], 'uses' => 'SettingController@createBillingPeriod']);

            Route::get('defaultrates', ['as'=>'admin.setting.crm.defaultrates', 'uses' => 'SettingController@defaultRates']);
            Route::post('defaultrates/create', ['as'=>'admin.setting.crm.defaultrates.create','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@createDefaultRate']);
            Route::post('defaultrates/delete', ['as'=>'admin.setting.crm.defaultrates.delete','middleware' => ['permission:delete_customer'], 'uses' => 'SettingController@deleteDefaultRate']);

            Route::get('servicetypes', ['as'=>'admin.setting.crm.servicetypes', 'uses' => 'SettingController@serviceTypes']);
            Route::post('servicetypes/create', ['as'=>'admin.setting.crm.servicetypes.create','middleware' => ['permission:edit_customer'], 'uses' => 'SettingController@createServiceType']);
            Route::post('servicetypes/delete', ['as'=>'admin.setting.crm.servicetypes.delete','middleware' => ['permission:delete_customer'], 'uses' => 'SettingController@deleteServiceType']);
        });
    });

    Route::group(['prefix'=>'settings','middleware' => ['role:admin|manager|technician']], function () {
          Route::get('/', ['as'=>'admin.setting.all', 'uses' => 'SettingController@index']);

        // Exit admin panel
          Route::get('/exit', ['as'=>'admin.setting.exit', function () {
              session(['panel' => 'agent']);
              return redirect('admin/dashboard');
          }]);

          Route::post('/update_email_data', ['as'=>'admin.setting.update_email_data', 'uses' => 'SettingController@updateEmailData']);
          Route::get('get_email_data', ['as'=>'admin.setting.get_email_data', 'uses' => 'SettingController@getEmailData']);
          Route::post('/update_email_signature', ['as'=>'admin.setting.update_email_signature', 'uses' => 'SettingController@updateEmailSignature']);
          Route::get('get_email_signature', ['as'=>'admin.setting.get_email_signature', 'uses' => 'SettingController@getEmailSignature']);


          Route::get('get_user_devices', ['as'=>'admin.setting.get_user_devices', 'uses' => 'SettingController@getUserDevices']);

          Route::get('delete_user_device/{id}', ['as'=>'admin.setting.delete_user_device', 'uses' => 'SettingController@deleteUserDevice']);


          /****no longer been used***/

        //Route::get('/imap', ['as'=>'admin.setting.imap', 'uses' => 'SettingController@imap']);
        //Route::post('/imap_store', ['as'=>'admin.setting.imap_store', 'uses' => 'SettingController@imapStore']);
        //Route::get('/smtp', ['as'=>'admin.setting.smtp', 'uses' => 'SettingController@smtp']);
           // Route::post('/smtp_store', ['as'=>'admin.setting.smtp_store', 'uses' => 'SettingController@smtpStore']);
        //Route::post('/gmail_api_update', ['as'=>'admin.setting.gmail_api_update', 'uses' => 'SettingController@gmailApiUpdate']);
        //Route::get('/google_auth', ['as'=>'admin.setting.google_auth', 'uses' => 'SettingController@googleAuth']);
           // Route::get('/slack_get', ['as'=>'admin.setting.slack_get', 'uses' => 'SlackController@getForm']);
           //Route::post('/slack_store', ['as'=>'admin.setting.slack_store', 'uses' => 'SlackController@slackStore']);


          Route::post('/tel_fax_update', ['as'=>'admin.setting.tel_fax_update', 'uses' => 'SettingController@telFaxUpdate']);
          Route::get('/ajax/listroles', ['as'=>'admin.roles.ajax.list', 'uses' => 'RoleController@ajaxDataIndex']);

        // Delete these no longer used
          Route::post('/time_zone_update', ['as'=>'admin.setting.time_zone_update', 'uses' => 'SettingController@timeZoneUpdate']);
          Route::post('update_date_time', ['as'=>'admin.setting.update_date_time', 'uses' => 'SettingController@updateDateTime']);
          Route::get('/get_date_time', ['as'=>'admin.setting.get_date_time', 'uses' => 'SettingController@getDateTime']);
    });
});

Route::get('/image/{folder}/{filename}', ['as'=>'get.image', 'uses' => 'ImageController@retrieveImage']);
Route::post('/image', ['as'=>'upload.image', 'uses' => 'ImageController@imageUpload']);
Route::get('/get_token', ['as'=>'get_token',  'uses' => 'SettingController@getToken']);
Route::get('/send_mail', ['as'=>'send_mail',  'uses' => 'TestEmailController@sendEmail']);
Route::get('/get_slack_token', ['as'=>'admin.setting.get_slack_token', 'uses' => 'SlackController@getToken']);
