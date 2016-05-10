<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name', 'description', 'parentID', 'scheduled'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function types()
    {
        return $this->hasMany('App\ProductType', 'groupID', 'id');
    }

    public static function tourGroups()
    {
        return Self::where('scheduled', 1)->get();
    }

}
