<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeTier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_tiers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tier'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function times()
    {
        return $this->hasMany('App\TourTime', 'tierID', 'id');
    }

}
