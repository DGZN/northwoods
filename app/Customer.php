<?php

namespace App;

use App\Billing\Customer as BillingCustomer;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'city',
        'zip',
        'state',
        'country',
        'profileID',
        'paymentID'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \App\Customer Collection
     */
    public static function validToday() {
      $valid = [];
      $reservations = (new Reservation)->where('date', Date('Y-m-d'))->get();
      foreach ($reservations as $reservation) {
        $_valid = array_where($reservation->group->pivot, function ($key, $value) {
            if ($value->status == 1) {
                return $value->customer;
            }
        });
        $valid = array_merge($valid, $_valid);
      }
      return $valid;
    }

    /**
     * Prototype over trait
     *
     * @param  Input $customer
     * @return \App\Customer
     */
    public static function create(Array $attributes = []) {

      $data = $attributes;

      if ( array_has($attributes, 'card_number') ) {

        $billingCustomer = (new BillingCustomer);

        $billingCustomer->setCreditCard([
            'card_number' => $attributes['card_number'],
            'exp_date'    => $attributes['exp_date']
        ]);

        $billingCustomer->setBillingInfo($attributes);

        if ( ! $billingCustomer->save() ) {

            $customer->delete();

            return $billingCustomer->errors();

        }

        $account = $billingCustomer->get();

        $data['profileID'] = $account['profileID'];
        $data['paymentID'] = $account['paymentProfileID'];

      }

      $customer = (new Customer);

      if ( ! $customer->fill($data)->save() ) {

        return 'Error saving customer';

      }

      return $customer;
    }

    /**
     * Prototype over trait
     *
     * @param  Input $customer
     * @return \App\Customer
     */
    public function update(Array $attributes = []) {

      $data = $attributes;

      if ( array_has($attributes, 'card_number') ) {

        $billingCustomer = (new BillingCustomer);

        $billingCustomer->setCreditCard([
            'card_number' => $attributes['card_number'],
            'exp_date'    => $attributes['exp_date']
        ]);

        $billingCustomer->setBillingInfo($attributes);

        if ( ! $billingCustomer->save() ) {

            return $billingCustomer->errors();

        }

        $account = $billingCustomer->get();

        $data['profileID'] = $account['profileID'];
        $data['paymentID'] = $account['paymentProfileID'];

        $charge = $billingCustomer->charge($data, $attributes['total']);

        if ( ! array_has($charge, 'auth_code') ) {

          return ['error charging customer'];

        }

        $transaction = (new Transaction)->findOrFail($data['transactionID']);

        $transaction->status = 1;

        $transaction->auth_code = $charge['auth_code'];

        $transaction->transactionID = $charge['transactionID'];

        $transaction->save();

      }

      if ( ! $this->fill($data)->save() ) {

        return 'Error saving customer';

      }

      if (isset($transaction)) {

        return $transaction;

      } else {

        return ['error processing transaction'];

      }


    }
}
