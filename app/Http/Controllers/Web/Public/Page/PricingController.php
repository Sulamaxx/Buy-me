<?php
/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 * Author: BeDigit | https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - https://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Web\Public\Page;

use App\Helpers\UrlGen;
use App\Http\Controllers\Web\Public\FrontController;
use Larapen\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\DB;
use App\Models\Package;


class PricingController extends FrontController
{
	/**
	 * @return \Illuminate\Contracts\View\View
	 * @throws \Exception
	 */
	public function index($sid=1)
	{
		// Get Listings' Promo Packages
		$promoPackagesData = $this->getPromotionPackages();
		$promoPackagesErrorMessage = $this->handleHttpError($promoPackagesData);
		$promoPackages = data_get($promoPackagesData, 'result.data');
		
		// Get Subscriptions Packages
		$subsPackagesData = $this->getSubscriptionPackages($sid);
        
        
        $sccombinations = DB::table('sub_cat_combinations')->get();
//        dd($sccombinations);
        
		$subsPackagesErrorMessage = $this->handleHttpError($subsPackagesData);
        
		$subsPackages = data_get($subsPackagesData, 'result.data');
		
		// Meta Tags
		[$title, $description, $keywords] = getMetaTag('pricing');
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);
		
		// Open Graph
		$this->og->title($title)->description($description)->type('website');
		view()->share('og', $this->og);
		$opensubs=0;
        if($sid>0)
        {
            $opensubs=$sid;
        }
        
		return appView(
			'pages.pricing',
			compact(
				'subsPackages',
				'subsPackagesErrorMessage',
				'promoPackages',
				'promoPackagesErrorMessage',
                'sccombinations',
                'opensubs'
			)
		);
	}
	
	private function getPromotionPackages(): array
	{
		// Get Packages - Call API endpoint
		$endpoint = '/packages/promotion';
		$queryParams = [
			'embed' => 'currency',
			'sort'  => '-lft',
		];
		$queryParams = array_merge(request()->all(), $queryParams);
		$data = makeApiRequest('get', $endpoint, $queryParams);
		
		// Select a Package and go to previous URL
		// Add Listing possible URLs
		$addListingUriArray = [
			'create',
			'post\/create',
			'post\/create\/[^\/]+\/photos',
		];
		// Default Add Listing URL
		$addListingUrl = UrlGen::addPost();
		if (request()->filled('from')) {
			foreach ($addListingUriArray as $uriPattern) {
				if (preg_match('#' . $uriPattern . '#', request()->query('from'))) {
					$addListingUrl = url(request()->query('from'));
					break;
				}
			}
		}
		view()->share('addListingUrl', $addListingUrl);
		
		return $data;
	}
	
	private function getSubscriptionPackages($sid): array
	{
        
        
        
       //return
           
           
//        $test=  Package::where('comb_id', 1)->get()->toArray();
//        dd($test);
        
		// Get Packages - Call API endpoint
		$endpoint = '/packages/subscription';
		$queryParams = [
			'embed' => 'currency',
			'sort'  => '-lft',
			'comb_id'  => $sid,
		];
		$queryParams = array_merge(request()->all(), $queryParams);
		
		return makeApiRequest('get', $endpoint, $queryParams);
	}
}
