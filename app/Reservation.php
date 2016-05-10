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
    protected $fillable = ['date', 'guests', 'cost', 'primaryGuestID', 'groupID'];

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
      $reservations = Reservation::where('date', date('Y-m-d'))->get();

      foreach ($reservations as $reservation) {

        $reservation->customer;

      }

      return $reservations;
    }

    public static function tomorrow()
    {
      $date = (new \DateTime)->createFromFormat('Y-m-d', date('Y-m-d'));
      $date->modify('+1 day');

      $reservations = Reservation::where('date', $date->format('Y-m-d'))->get();

      foreach ($reservations as $reservation) {

        $reservation->customer;

      }

      return $reservations;
    }

    public function delete()
    {
        $this->customer()->delete();
        $this->schedule()->delete();
        $this->group()->delete();
        if (parent::delete()) {
          return 'deleted';
        }
        return 'error';
    }

}
