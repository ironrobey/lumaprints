<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
	protected $table = 'table_shops';

	protected $fillable = [
		'name',
		'owner_name',
		'description',
		'location',
		'joined_date',
		'sale',
		'url'
	];

	public function listings(){
		return $this->hasMany('App\Listings');
	}

	public function addListing($listing){
		$this->listings()->create($listing);
	}

}
