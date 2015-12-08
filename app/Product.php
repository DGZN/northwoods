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

    protected $fillable = ['groupID', 'typeID', 'name', 'description', 'price', 'stock', 'SKU'];

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

    public static function withRelations()
    {
      $_products = Self::all();

      $products = [];

      foreach ($_products as $_product) {
        $group = $_product->group()->get();
        if (isset($group[0])) {
          $group = $group[0]->toArray();
          $_product['group'] = $group;
          $_product['groupName'] = $group['name'];
        } else {
          $_product['groupName'] = ':DELETED:';
        }
        $type = $_product->type()->get();
        if (isset($type[0])) {
          $type = $type[0]->toArray();
          $_product['type'] = $type;
          $_product['typeName'] = $type['name'];
        } else {
          $_product['typeName'] = ':DELETED:';
        }
        $products[] = $_product;
      }
      return $products;
    }

}
