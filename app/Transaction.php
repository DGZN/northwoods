<?php

namespace App;

use App\Customer;
use App\Billing\Customer as BillingCustomer;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'type',
        'referenceID',
        'notes',
        'productID',
        'employeeID',
        'reservationID',
        'customerID',
        'corporateID',
        'guests',
        'total',
        'status',
        'auth_code',
        'transactionID',
        'qty',
        'discount',
        'saleID'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Processes All Active Transactions.
     *
     * @var array
     */
     public function processAll()
     {
         $transactions = $this->where('status', 0)->get();
         $processed = [];
         foreach ($transactions as $i => $transaction) {
             $reservationID = $transaction['reservationID'];
             $reservation = Reservation::findOrFail($reservationID);

             $customer = Customer::findOrFail($reservation['primaryGuestID']);
             $customer = $customer->toArray();
             $cost = $reservation['cost'];

             if (!$charge = (new BillingCustomer)->charge($customer, $cost)) {
                 continue;
             }

             $transaction = Transaction::findOrFail($transaction->id);
             $transaction->update(['status' => 1]);

             $processed[] = [
                 'transaction' => $transaction,
                 'charge'      => $charge
            ];
         }

         return $processed;
     }

     public function product()
     {
         return $this->hasOne('App\Product', 'id', 'productID');
     }

     public function employee()
     {
         return $this->hasOne('App\Employee', 'id', 'employeeID');
     }

     public function customer()
     {
         return $this->hasOne('App\Customer', 'id', 'customerID');
     }

     public function corporate()
     {
         return $this->hasOne('App\CorporateAccount', 'id', 'coporateID');
     }

     public function reservation()
     {
         return $this->hasOne('App\Reservation', 'id', 'reservationID');
     }

     public function unpack()
     {
       $this->product();
       $this->employee();
       $this->customer();
       $this->reservation();
       return $this;
     }

}
