<?php

namespace App;

use App\Billing\Customer as BillingCustomer;
use Illuminate\Database\Eloquent\Model;

class CorporateAccount extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'corporate_accounts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = [
      'first_name',
      'last_name',
      'account',
      'organization',
      'phone',
      'email',
      'address',
      'city',
      'zip',
      'state',
      'country',
      'notes',
      'paymentTerms',
      'profileID',
      'taxExempt',
      'validOn',
      'paymentID'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   * Prototype over trait
   *
   * @param  Input $customer
   * @return \App\CorporateAccount
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

          return $billingCustomer->errors();

      }

      $account = $billingCustomer->get();

      $data['profileID'] = $account['profileID'];
      $data['paymentID'] = $account['paymentProfileID'];

    }

    $corporateAccount = (new CorporateAccount);

    if ( ! $corporateAccount->fill($data)->save() ) {

      return 'Error saving corporate account';

    }

    return $corporateAccount;
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

    return $transaction;

  }
}
