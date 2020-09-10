<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listings extends Model
{
    protected $table = 'table_listings';

    protected $fillable = [
    	'name',
    	'currency',
    	'price',
    	'rating',
    	'reviews',
    	'url'
    ];

    public function shop(){
    	return $this->belongsTo('App\Shops');
    }



}
