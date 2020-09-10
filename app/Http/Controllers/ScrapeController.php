<?php

namespace App\Http\Controllers;

use App\Shops;
use App\Listings;
use Illuminate\Http\Request;
use App\Traits\CleanUpTraits;
use KubAT\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Http;

class ScrapeController extends Controller
{
    use CleanUpTraits;

    public function index(){
    	return view('index');
    }

    public function store(){
    	$url = request()->url;
        $this->checker($url);
    }

    public function checker( $url ){
        $dom = $this->dom($url);
        if( $dom->find('ul.responsive-listing-grid', 0) != null ){
            $this->parse( $dom->find('ul.responsive-listing-grid', 0)->children() );
        } else {
            $this->checker($url);
        }
    }

    public function parse($children){
        foreach($children as $listing_card){

            $listing = $this->listingInfo( $listing_card );

            if( !$listing ) continue;
            if( Listings::where( 'name', $listing['name'] )->exists() ) continue;

            $shop = Shops::where('name', $listing['shop']);

            if(!$shop->exists()){
                $shop_url = $this->shopUrl($listing['url']);
                $shop_details = $this->shopDetails($shop_url, $listing['shop']);
                $shop = Shops::create($shop_details);
                $shop->addListing($listing);
            } else {
                $shop->first()->addListing($listing);    
            } 
        }
    }

}
