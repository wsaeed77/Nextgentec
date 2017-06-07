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

Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {


    Route::group(['prefix' => 'assets','middleware' => ['role:admin|manager|technician']], function () {

        Route::get('/', ['as'=>'admin.assets.index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@index']);

        Route::get('/create', ['as'=>'admin.assets.create','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@create']);
        Route::post('/store', ['as'=>'admin.assets.store','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@store']);
        Route::post('/update', ['as'=>'admin.assets.update','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@update']);
        Route::get('/show/{id}', ['as'=>'admin.assets.show','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@show']);
        Route::get('/edit/{id}', ['as'=>'admin.assets.show','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@edit']);
        Route::post('/delete', ['as'=>'admin.assets.delete','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@destroy']);



        Route::get('/assets_all', ['as'=>'admin.assets.all','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@assetsAll']);
        Route::get('/network_index', ['as'=>'admin.assets.network_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@networkIndex']);
        Route::get('/gateway_index', ['as'=>'admin.assets.gateway_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@gatewayIndex']);
        Route::get('/pbx_index', ['as'=>'admin.assets.pbx_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@pbxIndex']);
        Route::get('/server_index', ['as'=>'admin.assets.server_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@serverIndex']);

        Route::get('/network_index_bycustomer/{id}', ['as'=>'admin.assets.network_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@networkIndex']);

        Route::get('/gateway_index_bycustomer/{id}', ['as'=>'admin.assets.gateway_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@gatewayIndex']);

        Route::get('/pbx_index_bycustomer/{id}', ['as'=>'admin.assets.pbx_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@pbxIndex']);

        Route::get('/server_index_bycustomer/{id}', ['as'=>'admin.assets.server_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@serverIndex']);

        /****Tansfered to routes on root app***/

        // Route::get('/list_server_roles', ['as'=>'admin.assets.list_server_roles','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@listServerRoles']);

        // Route::get('/delete_server_role/{id}', ['as'=>'admin.assets.delete_server_role','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@destroyServerRole']);

        //Route::post('/create_server_role', ['as'=>'admin.assets.create_server_role','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@createServerRole']);


        // Route::get('/list_server_virtual_types', ['as'=>'admin.assets.list_server_virtual_types','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@listServerVirtualTypes']);

        // Route::get('/delete_server_virtual_type/{id}', ['as'=>'admin.assets.delete_server_virtual_type','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@destroyServerVirtualType']);

        // Route::post('/create_server_virtual_type', ['as'=>'admin.assets.create_server_virtual_type','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@createServerVirtualType']);
    });

    Route::group(['prefix' => 'knowledge','middleware' => ['role:admin|manager|technician']], function () {

        Route::get('/', ['as'=>'admin.knowledge.all','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@index']);

        Route::get('/passwords_list', ['as'=>'admin.knowledge.passwords.list','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@passwordsList']);

        Route::get('/passwords', ['as'=>'admin.knowledge.passwords','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@passwordsIndex']);



        Route::get('/passwords_bycustomer/{id}', ['as'=>'admin.knowledge.passwords_by_cust','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@passwordsIndex']);


        Route::post('/password', ['as'=>'admin.knowledge.store.password','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storePassword']);

        Route::post('/password_tag', ['as'=>'admin.knowledge.store.password.tag','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storePasswordTag']);

        Route::get('/tags', ['as'=>'admin.knowledge.get.tags','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@getTags']);


        Route::get('/edit/password/{id}', ['as'=>'admin.knowledge.edit.password','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@editPassword']);

        Route::post('/update/password', ['as'=>'admin.knowledge.update.password','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@updatePassword']);

        Route::post('/delete/password', ['as'=>'admin.knowledge.delete.password','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@deletePassword']);



        Route::get('/procedures_list', ['as'=>'admin.knowledge.procedures.list','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@proceduresList']);
        Route::get('/procedure_detail/{id}', ['as'=>'admin.knowledge.procedure.detail','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@procedureDetail']);

        Route::get('/procedures', ['as'=>'admin.knowledge.procedures','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@proceduresIndex']);


        // Procedure Image Handling
        Route::get('/image', ['as'=>'admin.knowledge.get.uniqid','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@getImageDirUniqid']);
        Route::post('/image', ['as'=>'admin.knowledge.upload.image','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storeImage']);
        Route::get('/image/{folder}/{filename}', ['as'=>'admin.knowledge.get.image','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@retrieveImage']);
        Route::get('/image/del/{folder}/{filename}', ['as'=>'admin.knowledge.del.image','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@deleteImage']);

        Route::get('/procedures_bycustomer/{id}', ['as'=>'admin.knowledge.procedures_by_cust','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@proceduresIndex']);

        Route::post('/procedure', ['as'=>'admin.knowledge.store.procedure','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storeProcedure']);
        Route::get('/edit/procedure/{id}', ['as'=>'admin.knowledge.edit.procedure','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@editProcedure']);

        Route::post('/update/procedure', ['as'=>'admin.knowledge.update.procedure','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@updateProcedure']);

        Route::post('/delete/procedure', ['as'=>'admin.knowledge.delete.procedure','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@deleteProcedure']);

        Route::get('/serial_numbers_list', ['as'=>'admin.knowledge.serial_numbers.list','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@serialnumberList']);

        Route::get('/serial_numbers', ['as'=>'admin.knowledge.serial_numbers','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@serialnumberIndex']);

        Route::get('/serial_numbers_bycustomer/{id}', ['as'=>'admin.knowledge.serial_numbers_by_cust','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@serialnumberIndex']);

        Route::post('/serial_number', ['as'=>'admin.knowledge.store.serial_number','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storeSerialNumber']);
        Route::get('/edit/serial_number/{id}', ['as'=>'admin.knowledge.edit.serial_number','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@editSerialNumber']);

        Route::post('/update/serial_number', ['as'=>'admin.knowledge.update.serial_number','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@updateSerialNumber']);

        Route::post('/delete/serial_number', ['as'=>'admin.knowledge.delete.serial','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@deleteSerialNumber']);

        Route::get('/type/{type}/{id}', ['as'=>'admin.knowledge.show','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@show']);




        Route::get('/networks', ['as'=>'admin.knowledge.networks','middleware' => ['permission:view_knowledge'], 'uses' => 'NetworkController@Index']);

        Route::get('/networs_list', ['as'=>'admin.knowledge.networks.list','middleware' => ['permission:view_knowledge'], 'uses' => 'NetworkController@networkIndex']);

        Route::get('/networs_list_bycustomer/{id}', ['as'=>'admin.knowledge.networks_list_by_cust','middleware' => ['permission:view_knowledge'], 'uses' => 'NetworkController@networkIndex']);

        Route::post('/network', ['as'=>'admin.knowledge.store.network','middleware' => ['permission:add_knowledge'], 'uses' => 'NetworkController@store']);

        Route::get('/network/{id}', ['as'=>'admin.knowledge.show.network','middleware' => ['permission:add_knowledge'], 'uses' => 'NetworkController@show']);

        Route::get('/edit/network/{id}', ['as'=>'admin.knowledge.edit.network','middleware' => ['permission:view_knowledge'], 'uses' => 'NetworkController@edit']);

        Route::post('/update/network', ['as'=>'admin.knowledge.update.network','middleware' => ['permission:add_knowledge'], 'uses' => 'NetworkController@update']);

        Route::post('/delete/network', ['as'=>'admin.knowledge.delete.network','middleware' => ['permission:view_knowledge'], 'uses' => 'NetworkController@deleteNetwork']);

        // Ajax
        Route::get('ajax_detail/{id}', ['as'=>'admin.knowledge.ajax_details','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@ajaxDetails']);
        // Ajax
    });
        /*Route::group(['prefix' => 'assets'], function() {
			Route::get('/', function() {
				dd('This is the Assets module index page.');
			});
		});*/
});
