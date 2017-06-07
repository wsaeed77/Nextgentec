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

/*Route::group(['prefix' => 'vendor'], function() {
	Route::get('/', function() {
		dd('This is the Vendor module index page.');
	});
});*/

Route::group(['prefix' => 'admin','middleware' => 'admin'], function() {

	Route::group(['prefix' => 'vendors','middleware' => ['role:admin|manager|technician']], function() {

	Route::get('/', ['as'=>'admin.vendors.index','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@index']);
	Route::get('show/{id}', ['as'=>'admin.vendor.show','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@show']);

	Route::get('/create', ['as'=>'admin.vendor.create','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@create']);

	Route::get('/vendor_index', ['as'=>'admin.vendors.vendor_index','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@vendorsIndex']);

	Route::get('/vendor_index_cust_dashboard', ['as'=>'admin.vendors.vendor_index_cust_dashboard','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@vendorsCustDashboard']);

	Route::post('/store', ['as'=>'admin.vendor.store','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@store']);

	Route::post('/delete', ['as'=>'admin.vendor.destroy','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@destroy']);


	Route::post('/create_contact', ['as'=>'admin.vendor.create_contact','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@addContact']);

	Route::get('/refresh_contacts/{id}', ['as'=>'admin.vendor.ajax.refresh_contacts','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@refreshContacts']);

	Route::post('/create_customer', ['as'=>'admin.vendor.create_customer','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@addCustomer']);

	Route::get('/refresh_customers/{id}', ['as'=>'admin.vendor.ajax.refresh_customers','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@refreshCustomers']);

	Route::get('/refresh_vendor_info/{id}', ['as'=>'admin.vendor.ajax.refresh_vendor_info','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@refreshVendorinfo']);


	Route::post('/update_info', ['as'=>'admin.vendor.update.info','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@updateInfo']);


	Route::get('/edit_contact/{id}', ['as'=>'admin.vendor.edit_contact','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@editContact']);

	Route::post('/update_contact', ['as'=>'admin.vendor.update.contact','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@updateContact']);

	Route::post('/delete_contact', ['as'=>'admin.vendor.contact.destroy','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@destroyContact']);


	Route::get('/edit_customer/{id}', ['as'=>'admin.vendor.edit_customer','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@editCustomer']);

	Route::post('/update_customer', ['as'=>'admin.vendor.update.customer','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@updateCustomer']);

	Route::post('/delete_customer', ['as'=>'admin.vendor.customer.destroy','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@destroyCustomer']);
	Route::post('/unlink_customer', ['as'=>'admin.vendor.customer.unlink','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@unlinkCustomer']);

	Route::get('search_vend_contacts', ['as'=>'admin.vendor.search.contacts','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@searchVendorContacts']);

	// Ajax
	Route::get('ajax_detail/{id}/{loc_id}', ['as'=>'admin.vendor.ajax_details','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@ajaxDetails']);

	Route::get('/vendors_list_json', ['as'=>'admin.ajax.vendors.json','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@ajaxVendorsJson']);


	Route::get('/locations_list_json/{id}', ['as'=>'admin.ajax.locations.json','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@ajaxLocationsJson']);

	Route::get('/vendor_add', ['as'=>'admin.add.vendors.for.customer','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@addVendorForCustomer']);

	// Ajax
	Route::get('ajax_detail/{id}', ['as'=>'admin.vendor.ajax_details','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@ajaxDetails']);

	
	Route::post('/attach_vendor', ['as'=>'admin.vendor.store.cust_selected','middleware' => ['permission:create_vendor'], 'uses' => 'VendorController@storeVendorWithCustomerSelected']);

	Route::get('custs_not_attached_to_vendor/{id}', ['as'=>'admin.vendor.custs_not_attached_to_vendor','middleware' => ['permission:list_vendor'], 'uses' => 'VendorController@custsNotAttachedToVendor']);

	});
});
