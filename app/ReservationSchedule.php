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

    public function availableTimes($date)
    {
        $times = (new TourTime)->all();
        $reservations = $this->where('date', $date)->get();
        $takenTimesIDs = [];
        $availableTimes = [];

        foreach ($reservations as $resrvation) {
            $takenTimesIDs[] = $resrvation->tourTimeID;
        }

        foreach ($times as $time) {
            if ( ! in_array($time->id, $takenTimesIDs) ) {
                $availableTimes[] = $time;
            }
        }

        return $availableTimes;
    }


}
