<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationSchedule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservation_schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'tourTimeID', 'reservationID'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function time()
    {
        return $this->hasOne('App\TourTime', 'id', 'tourTimeID');
    }

    public function reservation()
    {
        return $this->hasOne('App\Reservation', 'id', 'reservationID');
    }

    public function availableTimes($date, $groupSize = 0)
    {
        $times = [];
        $capacity = [];

        foreach ((new TourTime)->all() as $time) {

            $times[] = $time;
            $capacity[$time->id] = [];
            $capacity[$time->id]['capacity'] = 8;

        }

        $reservations = $this->where('date', $date)->get();

        foreach ($reservations as $schedule) {

          $schedule->reservation->relations();
          $schedule['groupSize'] =  count($schedule->reservation->group->pivot);
          $capacity[$schedule->tourTimeID]['capacity'] = $capacity[$schedule->tourTimeID]['capacity'] - $schedule['groupSize'];

        }

        foreach ($times as $i => $time) {

          $times[$i]['capacity'] = $capacity[$time->id]['capacity'];

        }

        $available = [];

        if ($groupSize > 0) {

          foreach ($times as $time) {

            if ($groupSize <= $time['capacity']) {

              $available[] = $time;

            }

          }

        } else {

          $available = $times;

        }


        return $available;
    }


}
