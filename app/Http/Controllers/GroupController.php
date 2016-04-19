<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

use App\Group;
use App\Customer;

use App\Http\Requests;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $customer = Customer::create($request->all());
        $group = Group::create([
          'primaryGuestID' => $customer->id,
          'uuid' => Uuid::uuid1()->toString()
        ]);
        $group->save();
        $pivot = (new \App\GroupPivot)->fill(['groupID' => $group->id, 'customerID' => $customer->id])->save();
        $customer['uuid'] = $group->uuid;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        if ( $request->has('full_name') && $request->has('email') ) {

            $name = explode(' ', $request->get('full_name'));

            if ( isset($name[1]) ) {

              $first_name = $name[0];
              $last_name = $name[1];

            }

            $customer = (new Customer)->create([
                'first_name' => isset($first_name) ? $first_name : '',
                'last_name'  => isset($last_name)  ? $last_name  : '',
                'email'      => $request->get('email')
            ]);

            $group = (new Group)->byUUID($uuid);

            $group->group()->create([
                'customerID' => $customer->id,
            ]);

            return $group->withCustomers();
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
        //
    }
}
