<?php

use Illuminate\Foundation\Inspiring;


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

Route::get('/', function () {
    return view('welcome', ['quote' => Inspiring::quote()]);
});


Route::group(['prefix' => 'api'], function ()
{
    Route::any('/', function() {});

    Route::group(['prefix' => 'v1'], function ()
    {
        Route::resource('reports',        'ReportController');
        Route::resource('customers',      'CustomerController');
        Route::resource('employees',      'EmployeeController');
        Route::resource('products',       'ProductController');
        Route::resource('transactions',   'TransactionController');
        Route::resource('reservations',   'ReservationController');
        Route::resource('product-groups', 'ProductGroupController');
        Route::resource('product-types',  'ProductTypeController');

        Route::resource('/', 'APIController');
    });

});
