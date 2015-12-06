<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;
use App\Billing\Customer as BillingCustomer;

use App\Http\Requests;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (new Customer)->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {

        $billCustomer = (new BillingCustomer);

        $billCustomer->setCreditCard([
            'card_number' => $request->get('card_number'),
            'exp_date'    => $request->get('exp_date')
        ]);

        $billCustomer->setBillingInfo($request->all());

        if (!$billCustomer->save()) {

            return $billCustomer->errors();

        }

        $account = $billCustomer->get();

        $customer = Customer::create($request->all());
        $customer->profileID = $account['profileID'];
        $customer->paymentID = $account['paymentProfileID'];

        $customer->save();

        return $customer;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Customer::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id)->update($request->all());
        if ($customer) {
            return ['status' => true, 'message' => 'Updated'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Customer::destroy($id);
    }
}
