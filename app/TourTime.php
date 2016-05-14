<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourTime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tour_times';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'tierID', 'typeID'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function tier()
    {
        return $this->hasOne('App\TimeTier', 'id', 'tierID');
    }

    public function type()
    {
        return $this->hasOne('App\ProductType', 'id', 'typeID');
    }

    public static function withRelations()
    {
        $times = Self::all();
        foreach ($times as $time) {
          $time->tier;
          $time->type;
        }
        return $times;
    }

}
