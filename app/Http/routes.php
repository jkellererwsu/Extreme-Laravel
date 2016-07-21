<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/





/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
$api = app('Dingo\Api\Routing\Router');

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'HomeController@index');
    Route::auth();

    Route::group(['middleware' => ['auth']], function () {
        Route::get('tags/{tags}','TagsController@show');
        Route::get('positions/{positions}','PositionsController@show');
        Route::get('/about', 'HomeController@about');
        Route::resource('contacts','ContactsController');
        Route::Patch('contacts/{contacts}/events','ContactsController@syncEvents');
        Route::Patch('contacts/{contacts}/groups','ContactsController@syncGroups');
        Route::Patch('contacts/{contacts}/trainings','ContactsController@syncTrainings');
        Route::resource('groups','GroupsController');
        Route::Patch('groups/{groups}/addcontacts','GroupsController@addContacts');
        Route::Delete('groups/{groups}/deletecontacts','GroupsController@deleteContacts');
        Route::resource('events','EventsController');
        Route::Patch('events/{events}/addcontacts','EventsController@addContacts');
        Route::Delete('events/{events}/deletecontacts','EventsController@deleteContacts');
        Route::resource('services','ServicesController');
        Route::Patch('services/{services}/addcontacts','ServicesController@addContacts');
        Route::Delete('services/{services}/deletecontacts','ServicesController@deleteContacts');
        Route::resource('attendances','AttendancesController');
        Route::resource('trainings','TrainingsController');
        Route::Patch('trainings/{trainings}/addcontacts','TrainingsController@addContacts');
        Route::Delete('trainings/{trainings}/deletecontacts','TrainingsController@deleteContacts');

    });

});

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'api.auth'], function ($api) {
        // Endpoints registered here will have the "foo" middleware applied.
        $api->GET('validate_token','App\Http\Controllers\AuthenticateController@validateToken');
        $api->GET('contacts/create','App\Http\Controllers\ApiContactsController@create');
        $api->resource('contacts','App\Http\Controllers\ApiContactsController');
        $api->GET('groups/create','App\Http\Controllers\ApiGroupsController@create');
        $api->GET('groups/createattend/{groups}','App\Http\Controllers\ApiGroupsController@createAttend');
        $api->POST('groups/createattend','App\Http\Controllers\ApiGroupsController@saveAttend');
        $api->resource('groups','App\Http\Controllers\ApiGroupsController');
        $api->GET('events/create','App\Http\Controllers\ApiEventsController@create');
        $api->GET('events/createattend/{events}','App\Http\Controllers\ApiEventsController@createAttend');
        $api->POST('events/createattend','App\Http\Controllers\ApiEventsController@saveAttend');
        $api->resource('events','App\Http\Controllers\ApiEventsController');
        $api->GET('trainings/createattend/{trainings}','App\Http\Controllers\ApiTrainingsController@createAttend');
        $api->POST('trainings/createattend','App\Http\Controllers\ApiTrainingsController@saveAttend');
        $api->resource('trainings','App\Http\Controllers\ApiTrainingsController');

    });

    $api->POST('login','App\Http\Controllers\AuthenticateController@authenticate');

});
