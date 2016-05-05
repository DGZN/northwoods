<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModifierGroup extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'product_modifier_groups';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = ['name'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  public function modifiers()
  {
      return $this->hasMany('App\ProductModifier', 'productModifierGroupID', 'id');
  }

}
