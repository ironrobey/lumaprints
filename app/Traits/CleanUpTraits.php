<?php

namespace App\Traits;
use KubAT\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Http;
 
trait CleanUpTraits {
 
    public function url($url) {
 		return preg_replace('/\?.*/', '', $url);
    }

    public function dom($url){
	    $response = Http::get($url);
    	$output = json_decode($response);
    	$output = $output->output;
    	sleep(60);
    	return HtmlDomParser::str_get_html($output->listingCards);
    }

    public function listingInfo($listing_card){
    	$listing = array();

    	$listing_url = '';
    	if($listing_card->find('.listing-link')){
    		$listing_url = $this->url($listing_card->find('.listing-link')[0]->attr['href']);
    	}
		$listing['url'] = $listing_url;

		if(!$listing_card->find('.v2-listing-card__info')){
			return false;
		} 

		$listing_card_info = $listing_card->find('.v2-listing-card__info')[0];
		
		$price = trim($listing_card_info->find('.n-listing-card__price .currency-value')[0]->innertext);
		$price = str_replace(',', '', $price);
		$listing['price'] = $price;
		$listing['currency'] = trim($listing_card_info->find('.n-listing-card__price .currency-symbol')[0]->innertext);

    	$shop = trim($listing_card_info->find('.v2-listing-card__shop .screen-reader-only')[0]->innertext);
        $remove_from_shop = array('Ad from shop ', 'From shop ');
        $listing['shop'] = str_replace($remove_from_shop, '', $shop);

        $reviews = 0;
        if($listing_card_info->find('.v2-listing-card__rating > .screen-reader-only')){
        	$reviews = str_replace(',', '', $listing_card_info->find('.v2-listing-card__rating > .screen-reader-only')[0]->innertext);
        	$reviews = str_replace(' reviews', '', $reviews);
        	$reviews = (int)str_replace(',', '', $reviews);
        }
        $listing['reviews'] = $reviews;

        $listing['name'] = trim($listing_card_info->find('h3')[0]->innertext);
    	
    	$rating = 0;
    	if($listing_card_info->find('input[name="rating"]')){
    		$rating = $listing_card_info->find('input[name="rating"]')[0]->attr['value'];
    	}
		$listing['rating'] = $rating;

        return $listing;
    }

    public function shopUrl($listing_url){
	    $listingDom = $this->dom($listing_url);
	    $shopUrl = $listingDom->find('#listing-page-cart p a')[0]->attr['href'];
		return $this->url($shopUrl);
    }

    public function shopDetails($shop_url,$shop_name){
    	$details = array();

	    $shopDom = $this->dom($shop_url);

        $details['name'] = $shop_name;
        $description = '';
        if($shopDom->find('.shop-name-and-title-container span')){
        	$description = trim($shopDom->find('.shop-name-and-title-container span')[0]->innertext);
        }
	    $details['description'] = $description;

	    $location = '';
	    if($shopDom->find('.shop-info .shop-location')){
	    	$location = trim($shopDom->find('.shop-info .shop-location')[0]->innertext);
	    }
	    $details['location'] = $location;

	    $since = trim($shopDom->find('.shop-info .etsy-since')[0]->innertext);
	    $details['joined_date'] = (int)trim(str_replace('On Etsy since', '', $since));

	    $sales = str_replace(' Sales', '', strip_tags($shopDom->find('.shop-info div', 1)->children(0)));
	    $details['sale'] = (int)str_replace(',', '', $sales);

	    $details['owner_name'] = $shopDom->find('.shop-owner div .img-container a p')[0]->innertext;

	    $details['url'] = $shop_url;

	    return $details;
    }

}