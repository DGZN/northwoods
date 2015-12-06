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

        Route::put('transactions/process', 'TransactionController@processAll');
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

Route::group(['prefix' => 'admin'], function ()
{
    Route::get('/', function() {
        return View('admin.dashboard');
    });

    Route::get('/customers', function() {
        return View('admin.customers', [
            'customers' => App\Customer::all()
        ]);
    });

    Route::get('/employees', function() {
        return View('admin.employees', [
            'employees' => App\Employee::all()
        ]);
    });

    Route::get('/reservations', function() {
        return View('admin.reservations', [
            'reservations' => App\Reservation::all(),
            'customers'    => App\Customer::all()
        ]);
    });

    Route::get('/transactions', function() {
        return View('admin.transactions', [
            'transactions' => App\Transaction::all()
        ]);
    });

    Route::get('/products', function() {
        return View('admin.products', [
            'products' => App\Product::all()
        ]);
    });

    Route::get('/product-groups', function() {
        return View('admin.product-groups', [
            'productGroups' => App\ProductGroup::all()
        ]);
    });

    Route::get('/product-types', function() {
        return View('admin.product-types', [
            'productTypes' => App\ProductType::all()
        ]);
    });

});
