<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name', 'description', 'groupID', 'cost'];

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

    public function products()
    {
        return $this->hasMany('App\Product', 'typeID', 'id');
    }

    public static function scheduled()
    {
        $scheduled = [];
        foreach (ProductGroup::all() as $group) {
          if ($group->scheduled) {
            foreach ($group->types as $type) {
              $scheduled[] = $type;
            }
          }
        }
        return $scheduled;
    }

}
