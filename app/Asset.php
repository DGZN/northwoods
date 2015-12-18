<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['clientID', 'projectID', 'name', 'mime', 'thumb'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
	
	public function notes(){
        return $this->hasMany('App\Note', 'id_asset', 'id');
    }
	
	public function type()
	{
		$type = '';
		if (strpos($this->mime, 'image') !== false) $type = 'image';
		else if (strpos($this->mime, 'video') !== false) $type = 'video';
		else $type = $this->mime;
		return $type;
	}
}
