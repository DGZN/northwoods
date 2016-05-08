<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'groups';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = [
      'primaryGuestID',
      'uuid',
      'date',
      'tourTimeID'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  public function pivot()
  {
      return $this->hasMany('App\GroupPivot', 'groupID', 'id');
  }

  public function reservation()
  {
      return $this->hasOne('App\Reservation', 'groupID', 'id');
  }

  /**
   * Return group by UUID
   *
   * @param  uuid
   * @return \App\Customer
   */
  public static function byUUID($uuid) {

      return Self::where('uuid', $uuid)->first();

  }

  /**
   * Return customers in group
   *
   * @param  self
   * @return \App\Customer
   */
  public function withCustomers() {
     foreach ($this->pivot as $pivot) {
         $pivot->customer['status'] = $pivot->status;
     }
     return $this;
  }

}
