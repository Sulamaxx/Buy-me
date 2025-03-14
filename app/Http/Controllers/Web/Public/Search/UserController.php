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

namespace App\Http\Controllers\Web\Public\Search;

use Larapen\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\DB; //shop code

class UserController extends BaseController
{
	public ?array $user;
	
	/**
	 * @param string|null $countryCode
	 * @param int|null $userId
	 * @return \Illuminate\Contracts\View\View
	 * @throws \Exception
	 */
	public function index(?string $countryCode, ?int $userId = null)
	{
		// Check if the multi-country site option is enabled
		if (!config('settings.seo.multi_country_urls')) {
			$userId = $countryCode;
		}
		
		return $this->searchByUserId($userId);
	}
	
//    shop code start
    public function index_shop_search()
	{
          
		// Call API endpoint
		$endpoint = '/posts';
		$queryParams = [
			'op'       => 'search',
		];
		
        $queryParams = array_merge(request()->all(), $queryParams);
        
        $userId = request()->userId;
		$headers = [
			'X-WEB-CONTROLLER' => class_basename(get_class($this)),
		];
		$data = makeApiRequest('get', $endpoint, $queryParams, $headers);
		
		$apiMessage = $this->handleHttpError($data);
		$apiResult = data_get($data, 'result');
		$apiExtra = data_get($data, 'extra');
		$preSearch = data_get($apiExtra, 'preSearch');
		
		// Sidebar
		$this->bindSidebarVariables((array)data_get($apiExtra, 'sidebar'));
		
		// Get Titles
		$this->getBreadcrumb($preSearch);
		$this->getHtmlTitle($preSearch);
		
		// Meta Tags
		[$title, $description, $keywords] = $this->getMetaTag($preSearch);
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		MetaTag::set('keywords', $keywords);
		
		// Open Graph
		$this->og->title($title)->description($description)->type('website');
		view()->share('og', $this->og);
		
		// SEO: noindex
		$noIndexUsersByIdPages = false;
		$noIndexUsersByUsernamePages = false;
		if (!empty($userId)) {
			$noIndexUsersByIdPages = (
				config('settings.seo.no_index_users')
				&& currentRouteActionContains('Search\UserController@index')
			);
		}
		if (!empty($username)) {
			$noIndexUsersByUsernamePages = (
				config('settings.seo.no_index_users_username')
				&& currentRouteActionContains('Search\UserController@profile')
			);
		}
		// Filters (and Orders) on Listings Pages (Except Pagination)
		$noIndexFiltersOnEntriesPages = (
			config('settings.seo.no_index_filters_relevance_orders')
			&& currentRouteActionContains('Search\\')
			&& !empty(request()->except(['page']))
		);
		// "No result" Pages (Empty Searches Results Pages)
		$noIndexNoResultPages = (
			config('settings.seo.no_index_no_result')
			&& currentRouteActionContains('Search\\')
			&& empty(data_get($apiResult, 'data'))
		);
        
        
        
		//shop code start
        if (!empty($userId)) {
            
            $userShop = DB::table('member_shop')->select('*')->where('user_id',$userId)->get();
            $currentVisVal = $userShop[0]->shop_visits;
            $currentVisVal++;
//dd($userShop);
            DB::table('member_shop')->where('user_id', $userId)->update(array('shop_visits' => $currentVisVal));
            $userShop = DB::table('member_shop')->select('*')->where('user_id',$userId)->get();
            $userName = DB::table('users')->select('name','created_at','usr_type')->where('id',$userId)->get();

            $usertypeid = $userName[0]->usr_type;
            $UsrType ='';  
            if($usertypeid>1)
            {
                $usertypedata = DB::table('usr_types')->select('usr_type')->where('id',$usertypeid)->get();
                $UsrType = $usertypedata[0]->usr_type;
            }
        }
        //shop code end
        

		return appView(
			'search.shop_results',
			compact(
				'apiMessage',
				'apiResult',
				'apiExtra',
				'noIndexUsersByIdPages',
				'noIndexUsersByUsernamePages',
				'noIndexFiltersOnEntriesPages',
				'noIndexNoResultPages',
				'userName',
				'userShop',
				'UsrType'
			)
		);
	
        
        
	}
    
    public function index_shop($username,$userId)
	{
        
        
//		// Check if the multi-country site option is enabled
//		if (!config('settings.seo.multi_country_urls')) {
//			$userId = $countryCode;
//		}
		
		return $this->searchShopByUserId($userId);
	}
    
    private function searchShopByUserId(?int $userId = null, ?string $username = null)
	{
		// Call API endpoint
		$endpoint = '/posts';
		$queryParams = [
			'op'       => 'search',
			'userId'   => trim($userId),
			'username' => trim($username),
		];
		$queryParams = array_merge(request()->all(), $queryParams);
		$headers = [
			'X-WEB-CONTROLLER' => class_basename(get_class($this)),
		];
		$data = makeApiRequest('get', $endpoint, $queryParams, $headers);
		
		$apiMessage = $this->handleHttpError($data);
		$apiResult = data_get($data, 'result');
		$apiExtra = data_get($data, 'extra');
		$preSearch = data_get($apiExtra, 'preSearch');
		
		// Sidebar
		$this->bindSidebarVariables((array)data_get($apiExtra, 'sidebar'));
		
		// Get Titles
		$this->getBreadcrumb($preSearch);
		$this->getHtmlTitle($preSearch);
		
		// Meta Tags
		[$title, $description, $keywords] = $this->getMetaTag($preSearch);
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		MetaTag::set('keywords', $keywords);
		
		// Open Graph
		$this->og->title($title)->description($description)->type('website');
		view()->share('og', $this->og);
		
		// SEO: noindex
		$noIndexUsersByIdPages = false;
		$noIndexUsersByUsernamePages = false;
		if (!empty($userId)) {
			$noIndexUsersByIdPages = (
				config('settings.seo.no_index_users')
				&& currentRouteActionContains('Search\UserController@index')
			);
		}
		if (!empty($username)) {
			$noIndexUsersByUsernamePages = (
				config('settings.seo.no_index_users_username')
				&& currentRouteActionContains('Search\UserController@profile')
			);
		}
		// Filters (and Orders) on Listings Pages (Except Pagination)
		$noIndexFiltersOnEntriesPages = (
			config('settings.seo.no_index_filters_orders')
			&& currentRouteActionContains('Search\\')
			&& !empty(request()->except(['page']))
		);
		// "No result" Pages (Empty Searches Results Pages)
		$noIndexNoResultPages = (
			config('settings.seo.no_index_no_result')
			&& currentRouteActionContains('Search\\')
			&& empty(data_get($apiResult, 'data'))
		);
		//shop code start
        if (!empty($userId)) {
            $userShop = DB::table('member_shop')->select('*')->where('user_id',$userId)->get();
            $currentVisVal = $userShop[0]->shop_visits;
            $currentVisVal++;

            DB::table('member_shop')->where('user_id', $userId)->update(array('shop_visits' => $currentVisVal));
            $userShop = DB::table('member_shop')->select('*')->where('user_id',$userId)->get();
            $userName = DB::table('users')->select('name','created_at','usr_type')->where('id',$userId)->get();

            $usertypeid = $userName[0]->usr_type;
            $UsrType ='';  
            if($usertypeid>1)
            {
                $usertypedata = DB::table('usr_types')->select('usr_type')->where('id',$usertypeid)->get();
                $UsrType = $usertypedata[0]->usr_type;
            }
        }
        //shop code end
        

		return appView(
			'search.shop_results',
			compact(
				'apiMessage',
				'apiResult',
				'apiExtra',
				'noIndexUsersByIdPages',
				'noIndexUsersByUsernamePages',
				'noIndexFiltersOnEntriesPages',
				'noIndexNoResultPages',
				'userName',
				'userShop',
				'UsrType'
			)
		);
	}
    
//	shop code end
	/**
	 * @param string|null $countryCode
	 * @param string|null $username
	 * @return \Illuminate\Contracts\View\View
	 * @throws \Exception
	 */
	public function profile(?string $countryCode, ?string $username = null)
	{
		// Check if the multi-country site option is enabled
		if (!config('settings.seo.multi_country_urls')) {
			$username = $countryCode;
		}
		
		return $this->searchByUserId(null, $username);
	}
	
	/**
	 * @param int|null $userId
	 * @param string|null $username
	 * @return \Illuminate\Contracts\View\View
	 * @throws \Exception
	 */
	private function searchByUserId(?int $userId = null, ?string $username = null)
	{
		// Call API endpoint
		$endpoint = '/posts';
		$queryParams = [
			'op'       => 'search',
			'userId'   => trim($userId),
			'username' => trim($username),
		];
		$queryParams = array_merge(request()->all(), $queryParams);
		$headers = [
			'X-WEB-CONTROLLER' => class_basename(get_class($this)),
		];
		$data = makeApiRequest('get', $endpoint, $queryParams, $headers);
		
		$apiMessage = $this->handleHttpError($data);
		$apiResult = data_get($data, 'result');
		$apiExtra = data_get($data, 'extra');
		$preSearch = data_get($apiExtra, 'preSearch');
		
		// Sidebar
		$this->bindSidebarVariables((array)data_get($apiExtra, 'sidebar'));
		
		// Get Titles
		$this->getBreadcrumb($preSearch);
		$this->getHtmlTitle($preSearch);
		
		// Meta Tags
		[$title, $description, $keywords] = $this->getMetaTag($preSearch);
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		MetaTag::set('keywords', $keywords);
		
		// Open Graph
		$this->og->title($title)->description($description)->type('website');
		view()->share('og', $this->og);
		
		// SEO: noindex
		$noIndexUsersByIdPages = false;
		$noIndexUsersByUsernamePages = false;
		if (!empty($userId)) {
			$noIndexUsersByIdPages = (
				config('settings.seo.no_index_users')
				&& currentRouteActionContains('Search\UserController@index')
			);
		}
		if (!empty($username)) {
			$noIndexUsersByUsernamePages = (
				config('settings.seo.no_index_users_username')
				&& currentRouteActionContains('Search\UserController@profile')
			);
		}
		// Filters (and Orders) on Listings Pages (Except Pagination)
		$noIndexFiltersOnEntriesPages = (
			config('settings.seo.no_index_filters_orders')
			&& currentRouteActionContains('Search\\')
			&& !empty(request()->except(['page']))
		);
		// "No result" Pages (Empty Searches Results Pages)
		$noIndexNoResultPages = (
			config('settings.seo.no_index_no_result')
			&& currentRouteActionContains('Search\\')
			&& empty(data_get($apiResult, 'data'))
		);
		
		return appView(
			'search.results',
			compact(
				'apiMessage',
				'apiResult',
				'apiExtra',
				'noIndexUsersByIdPages',
				'noIndexUsersByUsernamePages',
				'noIndexFiltersOnEntriesPages',
				'noIndexNoResultPages'
			)
		);
	}
}
