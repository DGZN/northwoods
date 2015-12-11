<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'clients';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = ['company', 'contact', 'email'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['created_at', 'updated_at'];

}
