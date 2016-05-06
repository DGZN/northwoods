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
        Route::put('transactions/process',         'TransactionController@processAll');
        Route::resource('reports',                 'ReportController');
        Route::resource('customers',               'CustomerController');
        Route::resource('corporate-accounts',      'CorporateAccountController');
        Route::resource('employees',               'EmployeeController');
        Route::resource('products',                'ProductController');
        Route::post('products/{id}',               'ProductController@storeSubproduct');
        Route::resource('transactions',            'TransactionController');
        Route::resource('reservations',            'ReservationController');
        Route::resource('groups',                  'GroupController');
        Route::put('groups/{uuid}/waiver/{id}',    'GroupController@updateWaiver');
        Route::get('tour-times/schedule',          'TourTimesController@schedule');
        Route::resource('tour-times',              'TourTimesController');
        Route::resource('product-groups',          'ProductGroupController');
        Route::resource('product-modifiers',       'ProductModifierController');
        Route::resource('product-modifier-groups', 'ProductModifierGroupController');
        Route::resource('product-types',           'ProductTypeController');
        Route::resource('/',                       'APIController');

    });

});


Route::get('admin/',  'Auth\AuthController@getLogin');
Route::get('admin/login',  'Auth\AuthController@getLogin');
Route::post('admin/login', 'Auth\AuthController@postLogin');
Route::get('admin/logout', 'Auth\AuthController@getLogout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function ()
{

    Route::get('/sales', function() {
        return View('admin.sales', [
          'products'     => App\Product::nonScheduled(),
          'customers'    => App\Customer::all(),
          'accounts'     => App\CorporateAccount::all(),
          'transactions' => App\Transaction::withRelations(),
          'reservations' => App\Reservation::withRelations()
        ]);
    });

    Route::get('/customers', function() {
        return View('admin.customers', [
            'customers' => App\Customer::all()
        ]);
    });

    Route::get('/customers/{id}', function($id) {
        return View('admin.customer-details', [
            'customer' => App\Customer::findOrFail($id)
        ]);
    });

    Route::get('/corporate-accounts', function() {
        return View('admin.corporate', [
            'accounts' => App\CorporateAccount::all()
        ]);
    });

    Route::get('/employees', function() {
        return View('admin.employees', [
            'employees' => App\Employee::all()
        ]);
    });

    Route::get('/employees/{id}', function($id) {
        return View('admin.employee-details', [
            'employee' => App\Employee::findOrFail($id)
        ]);
    });

    Route::get('/reservations', function() {
        return View('admin.reservations', [
            'times'        => App\TourTime::all(),
            'customers'    => App\Customer::all(),
            'reservations' => App\Reservation::withRelations(),
            'today' => App\Reservation::today()
        ]);
    });

    Route::get('/reservations/{id}', function($id) {
      $reservation = (new \App\Reservation)->findOrFail($id);
        return View('admin.reservation-details', [
            'reservation' => $reservation->relations()
        ]);
    });

    Route::get('/tour-times', function() {
        return View('admin.tour-times', [
            'times' => App\TourTime::withRelations(),
            'types' => App\ProductType::scheduled()
        ]);
    });

    Route::get('/sales-history', function() {
        return View('admin.transactions', [
            'products'     => App\Product::all(),
            'customers'    => App\Customer::all(),
            'transactions' => App\Transaction::withRelations(),
            'reservations' => App\Reservation::withRelations()
        ]);
    });

    Route::get('/products', function() {
        return View('admin.products', [
            'groups'         => App\ProductGroup::all(),
            'times'          => App\TourTime::all(),
            'modifierGroups' => App\ProductModifierGroup::all(),
            'products'       => App\Product::all()
        ]);
    });

    Route::get('/product-groups', function() {
        return View('admin.product-groups', [
            'productGroups' => App\ProductGroup::all()
        ]);
    });

    Route::get('/product-types', function() {
        return View('admin.product-types', [
            'groups'       => App\ProductGroup::all(),
            'productTypes' => App\ProductType::all()
        ]);
    });

    Route::get('/product-modifiers', function() {
        return View('admin.product-modifiers', [
            'groups' => App\ProductModifierGroup::all(),
            'modifiers' => App\ProductModifier::all()
        ]);
    });

    Route::get('/settings', function() {
      return View('admin.settings', [
          'productTypes' => App\ProductType::all()
      ]);
    });

});

Route::group(['prefix' => 'order'], function ()
{
    Route::get('reservations', function() {
        return View('customers.reservation');
    });

    Route::get('reservations/{uuid}', function($uuid) {
        $group = (new App\Group)->byUUID($uuid);
        return View('customers.group', [
          'uuid' => $uuid,
          'group' => $group->withCustomers(),
          'customer' => (new App\Customer)->findOrFail($group->primaryGuestID)
        ]);
    });

    Route::get('reservations/{uuid}/checkout', function($uuid) {
        $group = (new App\Group)->byUUID($uuid);
        $group->reservation;
        return View('customers.checkout', [
          'uuid' => $uuid,
          'group' => $group->withCustomers(),
          'customer' => (new App\Customer)->findOrFail($group->primaryGuestID)
        ]);
    });

    Route::get('reservations/{uuid}/checkout/{reservationID}', function($uuid, $id) {
        $transaction = (new App\Transaction)->findOrFail($id);
        $group = (new App\Group)->byUUID($uuid);
        return View('customers.confirmation', [
          'uuid' => $uuid,
          'transaction' => $transaction,
          'group' => $group->withCustomers(),
          'customer' => (new App\Customer)->findOrFail($transaction->customerID)
        ]);
    });

    Route::get('reservations/{uuid}/checkout/{reservationID}/success', function($uuid, $id) {
        $transaction = (new App\Transaction)->findOrFail($id);
        return View('customers.success', [
          'uuid' => $uuid,
          'transaction' => $transaction,
          'customer' => (new App\Customer)->findOrFail($transaction->customerID)
        ]);
    });

    Route::get('reservations/{uuid}/waiver/{customerID}', function($uuid, $customerID) {
        return View('customers.waiver', [
          'uuid' => $uuid,
          'guest' => (new App\Customer)->findOrFail($customerID)
        ]);
    });

});
