<?php

namespace App;

use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['time', 'guests', 'cost', 'primaryGuestID'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function customer()
    {
        return $this->hasOne('App\Customer', 'id', 'primaryGuestID');
    }

    public static function withRelations()
    {
      $_reservations = Self::all();

      $reservations = [];

      foreach ($_reservations as $_reservation) {
        $customer = $_reservation->customer()->get()[0]->toArray();
        $_reservation['customer'] = $customer;
        $customerName = $customer['first_name'] . ' ' . $customer['last_name'];
        $_reservation['customerName'] = $customerName;
        $reservations[] = $_reservation;
      }
      return $reservations;
    }

}
