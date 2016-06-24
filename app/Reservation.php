<?php

namespace App;

use App\Customer;
use App\Transaction;
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

    public function transaction()
    {
        return $this->hasOne('App\Transaction', 'reservationID', 'id');
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
      $this->transaction;
      $this->schedule->time;
      if ($this->group) {

          $this->group->withCustomers();

      }
      return $this;
    }

    public static function today()
    {
      $reservations = Reservation::where('date', date('Y-m-d'))->get();

      foreach ($reservations as $reservation) {

        $reservation->customer;
        $reservation->group->type;
        $reservation->group->time;

      }

      $reservations = array_values(array_sort($reservations, function ($reservation) {
          return $reservation->group->time->name;
      }));

      return $reservations;
    }

    public static function tomorrow()
    {
      $date = (new \DateTime)->createFromFormat('Y-m-d', date('Y-m-d'));
      $date->modify('+1 day');

      $reservations = Reservation::where('date', $date->format('Y-m-d'))->get();

      foreach ($reservations as $reservation) {

        $reservation->customer;
        $reservation->group->type;
        $reservation->group->time;

      }

      $reservations = array_values(array_sort($reservations, function ($reservation) {
          return $reservation->group->time->name;
      }));

      return $reservations;
    }

    public static function byDate($date)
    {
      $reservations = Self::where('date', $date)->get();

      foreach ($reservations as $reservation) {

        $reservation->customer;
        $reservation->group->type;
        $reservation->group->time;

      }

      $reservations = array_values(array_sort($reservations, function ($reservation) {
          return $reservation->group->time->name;
      }));

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
