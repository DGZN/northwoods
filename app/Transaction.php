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
        'productID',
        'employeeID',
        'reservationID',
        'guests',
        'total',
        'status'
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
}
