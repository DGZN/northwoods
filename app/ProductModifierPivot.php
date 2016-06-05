<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModifierPivot extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'product_modifier_pivots';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = ['productModifierGroupID', 'productModifierID', 'price'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  public function group()
  {
      return $this->hasOne('App\ProductModifierGroup', 'id', 'productModifierGroupID');
  }

  public function type()
  {
      return $this->hasOne('App\ProductModifier', 'id', 'productModifierID');
  }

  public function product()
  {
      return $this->hasOne('App\Product', 'id', 'productID');
  }
}
