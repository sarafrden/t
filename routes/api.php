<?php
use Illuminate\Http\Request;
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

    //Users
    Route::get('Users/{id}/delete', 'UserController@delete');
    Route::post('Users/{id}/update', 'UserController@update');

    //Managers
    Route::get('Managers/{id}/delete', 'ManagerController@delete');
    Route::post('Managers/{id}/update', 'ManagerController@update');
    Route::post('Managers/{id}/getEmployeeList', 'ManagerController@getEmployeeList');
    Route::post('Managers/getList', 'ManagerController@getList');
    Route::get('Managers/{id}/getById', 'ManagerController@getById');

    //Employees
    Route::get('Employees/{id}/delete', 'EmployeeController@delete');
    Route::post('Employees/{id}/update', 'EmployeeController@update');
    Route::post('Employees/getList', 'EmployeeController@getList');
    Route::get('Employees/{id}/getById', 'EmployeeController@getById');

    });

});

Route::post('Users/getList', 'UserController@getList');
Route::get('Users/{id}/getById', 'UserController@getById');





// http://127.0.0.1:8000/api/documentation
