<?php

namespace App;

use Mail;
use App\Group;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class GroupPivot extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group_pivot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'groupID',
        'customerID',
        'status',
        'waiverStatus',
        'termsStatus',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $visible = [];

    public function customer()
    {
        return $this->hasOne('App\Customer', 'id', 'customerID');
    }

    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'groupID');
    }

    /**
     * Sets customers in pay group as paid.
     *
     * @param  array Group Data
     * @return mixed
     */
    public function setAsPaid($data) {
        if ( array_has($data, 'groupID') && array_has($data, 'pay-group') ) {
            foreach ( json_decode($data['pay-group']) as $pivot ) {
                $customer = (new GroupPivot)
                    ->where('customerID', $pivot->id)
                    ->where('groupID', $data['groupID'])
                    ->first();
                $customer->status = 1;
                $customer->save();
                $this->sendReservationEmail($pivot->id, $data['groupID']);
            }
        }
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
      dd(compact('customer', 'group'));
      Mail::send('emails.reservation', ['customer' => $customer], function ($m) use ($customer) {
          $m->from('reservations@northwoodszipline.com', 'Northwoods Zipline');
          $m->to($customer->email, $customer->first_name . ' ' . $customer->last_name)->subject('Northwoods Zipline Reservation Confirmation');
      });
    }
}
