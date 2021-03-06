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
    return view('welcome', ['quote' => '']);
});


Route::group(['prefix' => 'api'], function ()
{
    Route::any('/', function() {});

    Route::group(['prefix' => 'v1'], function ()
    {
        Route::put('transactions/process',                 'TransactionController@processAll');
        Route::resource('reports',                         'ReportController');
        Route::resource('customers',                       'CustomerController');
        Route::resource('corporate-accounts',              'CorporateAccountController');
        Route::post('employees/pin',                       'EmployeeController@validatePIN');
        Route::resource('employees',                       'EmployeeController');
        Route::resource('products',                        'ProductController');
        Route::post('products/{id}',                       'ProductController@storeSubproduct');
        Route::post('products/{id}/modifier/{pivotID}',    'ProductController@deleteSubProduct');
        Route::resource('sales',                      'SaleController');
        Route::resource('sold-products',              'SalePivotController');
        Route::resource('transactions',               'TransactionController');
        Route::resource('reservations',               'ReservationController');
        Route::get('reservations/date/{date}',        'ReservationController@byDate');
        Route::resource('groups',                     'GroupController');
        Route::put('groups/{uuid}/waiver/{id}',       'GroupController@updateWaiver');
        Route::put('groups/{uuid}/terms/{id}',        'GroupController@updateTerms');
        Route::get('tour-times/schedule',             'TourTimesController@schedule');
        Route::resource('tour-times',                 'TourTimesController');
        Route::resource('product-groups',             'ProductGroupController');
        Route::resource('product-modifiers',          'ProductModifierController');
        Route::resource('product-modifier-groups',    'ProductModifierGroupController');
        Route::resource('product-types',              'ProductTypeController');
        Route::resource('settings',                   'SettingController');
        Route::resource('/',                          'APIController');

    });

});


Route::get('admin/',       'Auth\AuthController@getLogin');
Route::get('admin/login',  'Auth\AuthController@getLogin');
Route::post('admin/login', 'Auth\AuthController@postLogin');
Route::get('admin/logout', 'Auth\AuthController@getLogout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function ()
{

    Route::get('/sales', function() {
        return View('admin.sales', [
          'customers'    => App\Customer::validToday(),
          'products' => App\Product::nonScheduled(),
          'groups'   => App\ProductGroup::nonTourGroups(),
          'accounts' => App\CorporateAccount::today(),
          'settings'     => App\Setting::first()
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

    Route::get('/corporate-accounts/{id}', function($id) {
        return View('admin.corporate-details', [
            'account' => App\CorporateAccount::findOrFail($id)
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
            'reservations' => App\Reservation::tomorrow(),
            'today'        => App\Reservation::today()
        ]);
    });

    Route::get('/reservations/{id}', function($id) {
        $reservation = (new \App\Reservation)->findOrFail($id);
        return View('admin.reservation-details', [
            'reservation' => $reservation->relations(),
            'times' => (new \App\ReservationSchedule)->availableTimes($reservation->date)
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
            'sales'        => App\Sale::all(),
            'reservations' => App\Reservation::all()
        ]);
    });

    Route::get('/sales-history/{id}', function($id) {
        return View('admin.transaction-details', [
            'sale' => App\Sale::findOrFail($id),
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

    Route::get('/products/{id}', function($id) {
        return View('admin.product-details', [
            'product' => App\Product::findOrFail($id),
            'modifierGroups' => App\ProductModifierGroup::all()
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
          'productTypes' => App\ProductType::all(),
          'settings'     => App\Setting::first()
      ]);
    });

    Route::group(['prefix' => 'new'], function ()
    {
        Route::get('reservation', function() {
            return View('admin-reservations.reservation', [
              'groups' => (new App\ProductGroup)->tourGroups(),
              'types' => (new App\Product)->tourTypes(),
              'settings' => App\Setting::first()
            ]);
        });

        Route::get('reservations/{uuid}', function($uuid) {
            $group = (new App\Group)->byUUID($uuid);
            return View('admin-reservations.group', [
              'uuid' => $uuid,
              'group' => $group->withCustomers(),
              'customer' => (new App\Customer)->findOrFail($group->primaryGuestID)
            ]);
        });

        Route::get('reservations/{uuid}/checkout', function($uuid) {
            $group = (new App\Group)->byUUID($uuid);
            $group->reservation;
            return View('admin-reservations.checkout', [
              'uuid' => $uuid,
              'group' => $group->withCustomers(),
              'customer' => (new App\Customer)->findOrFail($group->primaryGuestID)
            ]);
        });

        Route::get('reservations/{uuid}/checkout/{reservationID}', function($uuid, $id) {
            $transaction = (new App\Transaction)->findOrFail($id);
            $group = (new App\Group)->byUUID($uuid);
            return View('admin-reservations.confirmation', [
              'uuid' => $uuid,
              'transaction' => $transaction,
              'group' => $group->withCustomers(),
              'customer' => (new App\Customer)->findOrFail($transaction->customerID)
            ]);
        });

        Route::get('reservations/{uuid}/checkout/{reservationID}/success', function($uuid, $id) {
            $transaction = (new App\Transaction)->findOrFail($id);
            return View('admin-reservations.success', [
              'uuid' => $uuid,
              'transaction' => $transaction,
              'customer' => (new App\Customer)->findOrFail($transaction->customerID)
            ]);
        });

        Route::get('reservations/{uuid}/waiver/{customerID}', function($uuid, $customerID) {
            return View('admin-reservations.waiver', [
              'uuid' => $uuid,
              'guest' => (new App\Customer)->findOrFail($customerID)
            ]);
        });

    });


});

Route::group(['prefix' => 'order'], function ()
{
    Route::get('reservations', function() {
        return View('customers.reservation', [
          'types' => (new App\Product)->tourTypes()
        ]);
    });

    Route::get('reservations/{uuid}', function($uuid) {
        $group = (new App\Group)->byUUID($uuid);
        $group->type;
        return View('customers.group', [
          'uuid' => $uuid,
          'group' => $group->withCustomers(),
          'customer' => (new App\Customer)->findOrFail($group->primaryGuestID)
        ]);
    });

    Route::get('reservations/{uuid}/checkout', function($uuid) {
        $group = (new App\Group)->byUUID($uuid);
        $group->reservation;
        $group->type;
        return View('customers.checkout', [
          'uuid' => $uuid,
          'group' => $group->withCustomers(),
          'customer' => (new App\Customer)->findOrFail($group->primaryGuestID)
        ]);
    });

    Route::get('reservations/{uuid}/checkout/{reservationID}', function($uuid, $id) {
        $transaction = (new App\Transaction)->findOrFail($id);
        $group = (new App\Group)->byUUID($uuid);
        $group->type;
        return View('customers.confirmation', [
          'uuid' => $uuid,
          'transaction' => $transaction,
          'settings' => App\Setting::first(),
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
          'settings' => App\Setting::first(),
          'guest' => (new App\Customer)->findOrFail($customerID)
        ]);
    });

});
