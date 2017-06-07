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

Route::group(['prefix' => 'admin','middleware' => 'admin'], function() {
	Route::group(['prefix' => 'nexpbx','middleware' => []], function() {

		Route::get('/', ['as'=>'admin.nexpbx.index','middleware' => [], 'uses' => 'DeviceController@index']);
		Route::get('/dtdevices', ['as'=>'admin.nexpbx.dt_devices','middleware' => [], 'uses' => 'DeviceController@dt_devices']);

		Route::get('/locations_list_json/{id}', ['as'=>'admin.nexpbx.ajax.locations.json','middleware' => [], 'uses' => 'DeviceController@ajaxLocationsJson']);

		Route::get('/customer_list_json/', ['as'=>'admin.nexpbx.ajax.customers.json','middleware' => [], 'uses' => 'DeviceController@ajaxCustomersJson']);


		Route::post('/assign_customer', ['as'=>'admin.nexpbx.assign.customer','middleware' => ['permission:create_vendor'], 'uses' => 'DeviceController@assignCustomer']);


		Route::get('/assets/', ['as'=>'admin.assets.nexpbx','middleware' => [], 'uses' => 'DeviceController@nexpbxDevices']);

		Route::get('/nexpbx_cust_list', ['as'=>'admin.nexpbx.customer.json','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@ajaxCustomerNexpbx']);


		Route::get('/nexpbx_domain_devices/{id}', ['as'=>'admin.nexpbx.domain.devices','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@DomainDevices']);

		Route::get('/nexpbx_cust_device_list/{domain_uuid}', ['as'=>'admin.nexpbx.customer.devices.json','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@ajaxCustomerDevices']);

		Route::get('/assign_devices', ['as'=>'admin.nexpbx.assign.devices','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@assign_devices']);


		Route::post('/remove_device/', ['as'=>'admin.nexpbx.remove.device','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@remove_device']);


		Route::get('/change_type/{id}/{value}', ['as'=>'admin.nexpbx.change.type','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@change_type']);


		Route::get('/change_location/{id}/{value}', ['as'=>'admin.nexpbx.change.location','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@change_location']);

		Route::get('/ajax_device_detail/{id}', ['as'=>'admin.nexpbx.device.detail','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@device_detail']);

		Route::post('/update_notes', ['as'=>'admin.nexpbx.update.notes','middleware' => ['permission:list_vendor'], 'uses' => 'DeviceController@updateNotes']);

	});
});
