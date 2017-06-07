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

Route::group(['middleware' => 'web'], function () {

    Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {

        Route::group(['prefix' => 'employee','middleware' => ['role:admin|manager|technician']], function () {

            Route::get('/', ['as'=>'admin.employee.index','middleware' => ['permission:list_employee'], 'uses' => 'EmployeeController@index']);
            Route::get('create', ['as'=>'admin.employee.create','middleware' => ['permission:add_employee'], 'uses' => 'EmployeeController@create']);
            Route::post('/', ['as'=>'admin.employee.store','middleware' => ['permission:add_employee'], 'uses' => 'EmployeeController@store']);
            Route::post('/ajax_update', ['as'=>'admin.employee.ajax_store','middleware' => [], 'uses' => 'EmployeeController@ajaxStore']);

            Route::get('/get_user/{id}', ['as'=>'admin.employee.get_ajax_user','middleware' => ['permission:list_employee'], 'uses' => 'EmployeeController@getById']);
            Route::get('edit/{id}', ['as'=>'admin.employee.edit','middleware' => ['permission:edit_employee'], 'uses' => 'EmployeeController@edit']);
            Route::delete('delete', ['as'=>'admin.employee.destroy','middleware' => ['permission:delete_employee'], 'uses' => 'EmployeeController@destroy']);
            Route::put('/{id}', ['as'=>'admin.employee.update','middleware' => ['permission:edit_employee'], 'uses' => 'EmployeeController@update']);


            Route::get('show/{id}', ['as'=>'admin.employee.show','middleware' => ['permission:edit_employee'], 'uses' => 'EmployeeController@show']);

          /*********************************************** Leaves*****************************/

            Route::group(['prefix' => 'leave'], function () {
                Route::get('/create', ['as'=>'employee.leave.create','middleware' => ['permission:post_leave'], 'uses' => 'LeaveController@create']);
                Route::delete('/delete', ['as'=>'employee.leave.destroy','middleware' => ['permission:delete_leave'], 'uses' => 'LeaveController@destroy']);

                Route::get('/pending_leaves', ['as'=>'admin.leave.pending','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@listPendingLeaves']);
                Route::get('/rejected_leaves', ['as'=>'admin.leave.rejected','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@listRejectedLeaves']);

                Route::get('/calendar', ['as'=>'admin.leave.calendar','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@showCalendar']);
                Route::post('/post_leave_for_employee', ['as'=>'admin.leave.post_leave_for_employee','middleware' => ['permission:post_leave_for_employee'], 'uses' => 'LeaveController@postLeaveForEmployee']);

                Route::get('/{id}', ['as'=>'employee.leave.own.index','middleware' => ['permission:list_own_leaves'], 'uses' => 'LeaveController@index']);

                Route::get('/', ['as'=>'employee.leave.index','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@index']);


                Route::post('/', ['as'=>'employee.leave.store','middleware' => ['permission:post_leave'], 'uses' => 'LeaveController@store']);
            });

          /*********************************************** Leaves*****************************/


            Route::group(['prefix' => 'leave'], function () {
                //dd('fff');
                Route::post('/postToCalendar', ['as'=>'admin.leave.posttocalendar','middleware' => ['permission:approve_leave'], 'uses' => 'LeaveController@postCalander']);
                Route::post('/rejectLeave', ['as'=>'admin.leave.reject_leave','middleware' => ['permission:reject_leave'], 'uses' => 'LeaveController@rejectLeave']);
            });
        });

        Route::group(['prefix' => 'leave'], function () {

            Route::get('/list_leaves/{id}', ['as'=>'admin.leave.list_leaves','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@dashboardListLeaves']);

            Route::get('/list_all_leaves', ['as'=>'admin.leave.list_all_leaves','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@allListLeaves']);


            Route::get('/list_own_leaves/{id}', ['as'=>'admin.leave.list_own_leaves','middleware' => ['permission:list_own_leaves'], 'uses' => 'LeaveController@allListLeaves']);
        });
        Route::resource('/raise', 'RaiseController');

        Route::get('calander', 'EmployeeController@googleCalander');
    });
});
