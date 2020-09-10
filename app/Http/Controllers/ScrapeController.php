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

    protected $max_pages = 30;

    public function index(){
    	return view('index');
    }

    public function store(){
        foreach(request()->url as $url){

            if( $url == '' ) continue;

            $dom = $this->dom($url);

            foreach($dom->find('.js-merch-stash-check-listing') as $listing_card){
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
            sleep(5);
        }
    }

}
