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

// Route::get('/', function () {
//     return view('welcome');
// });
//Route::get('admin/dashboard','AdminController@showDashboard');
/*Route::get('admin', array('uses' => 'AdminController@showLogin'));*/
Route::get('/', 'AdminController@getLogin');
//Route::get('login', 'AdminController@getLogin');
Route::get('admin/login', 'AdminController@getLogin');
Route::post('admin/login', 'AdminController@postLogin');
//Route::get('admin/register', 'AdminController@getRegister');
//Route::post('admin/register', 'AdminController@postRegister');
Route::get('admin/logout', 'AdminController@getLogout');

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

/*
	Route::group(['prefix'=>'config','middleware' => ['role:admin']], function(){
	 Route::get('/imap', ['as'=>'admin.config.imap', 'uses' => 'ConfigController@imap']);
	 Route::post('/imap_store', ['as'=>'admin.config.imap_store', 'uses' => 'ConfigController@imapStore']);

	 Route::get('/smtp', ['as'=>'admin.config.smtp', 'uses' => 'ConfigController@smtp']);
	 Route::post('/smtp_store', ['as'=>'admin.config.smtp_store', 'uses' => 'ConfigController@smtpStore']);


	});*/
    Route::group(['prefix'=>'settings','middleware' => ['role:admin']], function () {
        Route::get('/all', ['as'=>'admin.setting.all', 'uses' => 'SettingController@index']);

        Route::post('/update_email_data', ['as'=>'admin.setting.update_email_data', 'uses' => 'SettingController@updateEmailData']);

        Route::get('get_email_data', ['as'=>'admin.setting.get_email_data', 'uses' => 'SettingController@getEmailData']);


        Route::post('update_date_time', ['as'=>'admin.setting.update_date_time', 'uses' => 'SettingController@updateDateTime']);
        Route::get('/get_date_time', ['as'=>'admin.setting.get_date_time', 'uses' => 'SettingController@getDateTime']);

         Route::get('/imap', ['as'=>'admin.setting.imap', 'uses' => 'SettingController@imap']);
        Route::post('/imap_store', ['as'=>'admin.setting.imap_store', 'uses' => 'SettingController@imapStore']);

        Route::get('/smtp', ['as'=>'admin.setting.smtp', 'uses' => 'SettingController@smtp']);
        Route::post('/smtp_store', ['as'=>'admin.setting.smtp_store', 'uses' => 'SettingController@smtpStore']);


        Route::post('/gmail_api_update', ['as'=>'admin.setting.gmail_api_update', 'uses' => 'SettingController@gmailApiUpdate']);
    });

    Route::get('/image/{folder}/{filename}', ['as'=>'admin.get.image', 'uses' => 'ImageController@retrieveImage']);

    Route::post('/image', ['as'=>'admin.upload.image', 'uses' => 'ImageController@imageUpload']);
});

Route::get('/get_token', ['as'=>'get_token',  'uses' => 'SettingController@getToken']);



/*Route::get('/get_token', ['as'=>'get_token',  function(){
	$request = Request::all();

dd($request['code']);


//dd($request->all());
}

	]);*/

/*Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/logout', 'Auth\AuthController@getLogout');*/
