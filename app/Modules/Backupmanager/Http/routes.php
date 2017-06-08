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
    Route::group(['prefix' => 'bum','middleware' => []], function () {
        Route::get('/', ['as'=>'admin.backupmanager.index','middleware' => [], 'uses' => 'ProvisioningController@index']);

        Route::get('/editor/{id}', ['as'=>'admin.backupmanager.editor','middleware' => [], 'uses' => 'ProvisioningController@editor']);
        Route::post('/editor_save/', ['as'=>'admin.backupmanager.editor.save','middleware' => [], 'uses' => 'ProvisioningController@editorSave']);
    });
});

Route::get('/getscript/{id}/{uuid}', ['as'=>'admin.backupmanager.getscript','middleware' => [], 'uses' => 'ProvisioningController@getscript']);
