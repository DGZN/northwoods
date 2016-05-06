<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['groupID', 'typeID', 'name', 'description', 'price', 'stock', 'SKU', 'modifierID', 'parentID'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function group()
    {
        return $this->hasOne('App\ProductGroup', 'id', 'groupID');
    }

    public function type()
    {
        return $this->hasOne('App\ProductType', 'id', 'typeID');
    }

    public function subs()
    {
        return $this->hasMany('App\Product', 'parentID', 'id');
    }

    public function substext()
    {
      $subs = count($this->subs);
      if ($subs > 0 && $subs < 1)
        return $subs . ' modifier';
      if ($subs > 1)
        return $subs . ' modifiers';
      return null;
    }

    public static function nonScheduled()
    {
      $products = [];
      foreach (Self::where('parentID', 0)->get() as $product) {
          if ($product->group->scheduled == 0) {
            $products[] = $product;
          }
      }
      return $products;
    }

}
