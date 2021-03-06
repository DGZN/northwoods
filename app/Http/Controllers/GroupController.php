<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

use Mail;
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
          'uuid' => Uuid::uuid1()->toString(),
          'date' => $request->get('date'),
          'numGuests' => $request->get('numGuests'),
          'tourTimeID' => $request->get('tourTimeID'),
          'tourTypeID' => $request->get('tourTypeID')
        ]);
        $group->save();
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

            $first_name = $request->get('full_name');

            $name = explode(' ', $request->get('full_name'));

            if ( isset($name[1]) ) {

              $first_name = $name[0];
              $last_name  = $name[1];

            }

            $customer = (new Customer)->create([
                'first_name' => isset($first_name) ? $first_name : '',
                'last_name'  => isset($last_name)  ? $last_name  : '',
                'email'      => $request->get('email')
            ]);

            $group = (new Group)->byUUID($uuid);

            $group->pivot()->create([
                'customerID' => $customer->id,
            ]);


            return $group;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateWaiver(Request $request, $uuid, $customerID)
    {
        $input = $request->all();
        $group = (new Group)->byUUID($uuid);
        $guest = (new \App\GroupPivot)
                    ->where('groupID', $group->id)
                    ->where('customerID', $customerID)
                    ->firstOrFail();

        if ( $request->has('waiverStatus') ) {

          $guest->waiverStatus = $request->get('waiverStatus');
          $guest->save();

        }

        return $guest;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTerms(Request $request, $uuid, $customerID)
    {
        $input = $request->all();
        $group = (new Group)->byUUID($uuid);
        $guest = (new \App\GroupPivot)
                    ->where('groupID', $group->id)
                    ->where('customerID', $customerID)
                    ->firstOrFail();
        if ( $request->has('termsStatus') ) {

          $guest->termsStatus = $request->get('termsStatus');
          $guest->save();

        }

        foreach ($group->pivot as $pivot) {

          $this->sendReservationEmail($pivot->customerID, $pivot->groupID);

        }

        return $guest;
    }

    /**
     * Sends reservation confirmation
     *
     * @param  integer customerID
     * @param  integer groupID
     * @return boolean
     */
    private function sendReservationEmail($customerID, $groupID) {
      $customer = Customer::findOrFail($customerID);
      $group = Group::findOrFail($groupID);
      $group->reservation;
      $group->time;
      $group->type;
      $primary = Customer::findOrFail($group->primaryGuestID);
      $groupURL = env('APIHOST') . '/order/reservations/' . $group->uuid . '/checkout';
      Mail::send('emails.reservation', ['customer' => $customer, 'groupURL' => $groupURL, 'primary' => $primary], function ($m) use ($customer) {
          $m->from('reservations@northwoodszipline.com', 'Northwoods Zipline');
          $m->to($customer->email, $customer->first_name . ' ' . $customer->last_name)->subject('Northwoods Zipline Reservation Confirmation');
      });
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
