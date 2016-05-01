<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModifier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_modifiers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['productModifierGroupID', 'name'];

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

}
