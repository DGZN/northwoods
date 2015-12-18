<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['note'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
