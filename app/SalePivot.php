<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalePivot extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'sale_pivot';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = [
      'name',
      'saleID',
      'productID',
      'qty'
  ];

  public function sale()
  {
      return $this->hasOne('App\Sale', 'id', 'saleID');
  }

  public function product()
  {
      return $this->hasMany('App\Product', 'id', 'productID');
  }
}
