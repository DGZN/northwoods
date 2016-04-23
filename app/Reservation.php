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
    protected $fillable = ['time', 'date', 'guests', 'cost', 'primaryGuestID', 'groupID'];

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

    public function schedule()
    {
        return $this->hasOne('App\ReservationSchedule', 'reservationID', 'id');
    }

    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'groupID');
    }


    /**
     * Resturns reservation by primary Guest ID.
     *
     * @var array
     */
    public function byPrimaryGuestID($id)
    {
        return $this->where('primaryGuestID', $id)->get();
    }

    public function relations()
    {
      $this->customer;
      $this->schedule->time;
      $this->group->withCustomers();
      return $this;
    }

    public static function today()
    {
      $dateToday = date('m-d-Y');
      $_reservations = Self::all();
      $today = [];

      foreach ($_reservations as $_reservation) {
        $customer = $_reservation->customer;
        if (isset($customer)) {
          $customer = $customer->toArray();
          $_reservation['customer'] = $customer;
          $customerName = $customer['first_name'] . ' ' . $customer['last_name'];
          $_reservation['customerName'] = $customerName;
        } else {
          $_reservation['customerName'] = ':DELETED:';
        }
        if ($_reservation['date'] == $dateToday) {
          $today[] = $_reservation;
        }
      }

      return $today;
    }


    public static function withRelations()
    {
      $_reservations = Self::all();
      $reservations = [];

      foreach ($_reservations as $_reservation) {
        $customer = $_reservation->customer()->get();
        if (isset($customer[0])) {
          $customer = $customer[0]->toArray();
          $_reservation['customer'] = $customer;
          $customerName = $customer['first_name'] . ' ' . $customer['last_name'];
          $_reservation['customerName'] = $customerName;
        } else {
          $_reservation['customerName'] = ':DELETED:';
        }
        $reservations[] = $_reservation;
      }
      return $reservations;
    }

}
