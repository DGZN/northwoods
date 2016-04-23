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
        'transactionID'
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

     public static function withRelations()
     {
       $_transactions = Self::all();

       $transactions = [];

       foreach ($_transactions as $_transaction) {
         if ($_transaction->productID > 0) {
           $product = $_transaction->product()->get()->toArray();
           if (isset($product[0])){
             $_transaction['product'] = $product[0];
           } else {
             $_transaction['product'] = ['name' => ':DELETED:'];
           }
         }
         if ($_transaction->employeeID > 0) {
           $employee = $_transaction->employee()->get()->toArray();
           if (isset($employee[0])) {
             $_transaction['employee'] = $employee[0];
           } else {
             $_transaction['employee'] = 'Deleted';
           }
         }
         if ($_transaction->customerID > 0) {
           $customer = $_transaction->customer();
           $customer = $customer->get()->toArray();
           if (isset($customer[0])) {
             $customer = $customer[0];
             $_transaction['customer'] = $customer;
             $customerName = $customer['first_name'] . ' ' . $customer['last_name'];
             $_transaction['customerName'] = $customerName;
           } else {
             $_transaction['customerName'] = ':DELETED:';
           }
         }
         if ($_transaction->reservationID > 0) {
           $reservation = $_transaction->reservation();
           $reservation = $reservation->get()->toArray();
           if (isset($reservation[0])) {
             $primaryGuestID = $reservation[0]['primaryGuestID'];
             $customer = (new Customer)->find($primaryGuestID);
             if ( ! $customer) {
                 $customerName = $customer['first_name'] . ' ' . $customer['last_name'];
                 $_transaction['reservation'] = $reservation;
                 $_transaction['reservationName'] = $customerName;
             } else {
                 $_transaction['reservationName'] = ':DELETED:';
             }
           } else {
             $_transaction['reservationName'] = ':DELETED:';
           }
         }
         $transactions[] = $_transaction;
       }
       return $transactions;
     }
}
