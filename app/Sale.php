<?php

namespace App;

use App\Customer;
use App\Billing\Customer as BillingCustomer;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'transactionCode',
        'total',
        'tax',
        'grand',
        'employeeID',
        'notes',
    ];

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employeeID');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'saleID', 'id');
    }
}
