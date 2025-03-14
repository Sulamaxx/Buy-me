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


use App\Helpers\UrlGen;
use App\Http\Controllers\Web\Public\Post\Traits\CatBreadcrumbTrait;
use App\Http\Controllers\Web\Public\Post\Traits\ReviewsPlugin;
use App\Models\Package;
use App\Http\Controllers\Web\Public\FrontController;

use Larapen\LaravelMetaTags\Facades\MetaTag;

class CategoryController extends BaseController
{
	/**
	 * Category URL
	 * Pattern: (countryCode/)category/category-slug
	 * Pattern: (countryCode/)category/parent-category-slug/category-slug
	 *
	 * @param $countryCode
	 * @param $catSlug
	 * @param $subCatSlug
	 * @return \Illuminate\Contracts\View\View
	 * @throws \Exception
	 */
	public function index($countryCode, $catSlug, $subCatSlug = null)
	{
		// Check if the multi-country site option is enabled
		if (!config('settings.seo.multi_country_urls')) {
			$subCatSlug = $catSlug;
			$catSlug = $countryCode;
		}
		
		// Call API endpoint
		$endpoint = '/posts';
		$queryParams = [
			'op' => 'search',
			'c'  => $catSlug,
			'sc' => $subCatSlug,
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
//        print_r($data);
        $mydata = data_get($data, 'data');
        if(isset($apiResult['data'][0]))
        {
            $post= $apiResult['data'][0];
        }
        else
        {
            $post= '';
        }
        
//        print_r($apiResult['data'][0]['id']);
//        exit();
        $widgetSimilarPosts = $this->similarPosts(data_get($post, 'id'));
		$dta = "my test 123";
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
		$noIndexCategoriesPermalinkPages = (
			config('settings.seo.no_index_categories')
			&& currentRouteActionContains('Search\CategoryController')
		);
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
				'widgetSimilarPosts',
				'apiMessage',
				'apiResult',
				'apiExtra',
				'noIndexCategoriesPermalinkPages',
				'noIndexFiltersOnEntriesPages',
				'noIndexNoResultPages'
			)
		);
	}
    public function similarPosts($postId = null): ?array
	{
		$post = null;
		$posts = [];
		$totalPosts = 0;
		$widgetSimilarPosts = null;
		$message = null;
		
		// GET SIMILAR POSTS
		if (in_array(config('settings.single.similar_listings'), ['1', '2'])) {
			// Call API endpoint
			$endpoint = '/posts';
			$queryParams = [
				'op'       => 'similar2',
				'postId'   => $postId,
				'distance' => 50, // km OR miles
			];
			$queryParams = array_merge(request()->all(), $queryParams);
			$headers = [
				'X-WEB-CONTROLLER' => class_basename(get_class($this)),
			];
			$data = makeApiRequest('get', $endpoint, $queryParams, $headers);
			
			$message = data_get($data, 'message');
			$posts = data_get($data, 'result.data');
			$totalPosts = data_get($data, 'extra.count.0');
			$post = data_get($data, 'extra.preSearch.post');
		}
		
		if (config('settings.single.similar_listings') == '1') {
			// Featured Area Data
			$widgetSimilarPosts = [
				'title'      => t('Similar Listings'),
				'link'       => UrlGen::category(data_get($post, 'category')),
				'posts'      => $posts,
				'totalPosts' => $totalPosts,
				'message'    => $message,
			];
			$widgetSimilarPosts = ($totalPosts > 0) ? $widgetSimilarPosts : null;
		} else if (config('settings.single.similar_listings') == '2') {
			$distance = 50; // km OR miles
			
			// Featured Area Data
			$widgetSimilarPosts = [
				'title'      => t('more_listings_at_x_distance_around_city', [
					'distance' => $distance,
					'unit'     => getDistanceUnit(config('country.code')),
					'city'     => data_get($post, 'city.name'),
				]),
				'link'       => UrlGen::city(data_get($post, 'city')),
				'posts'      => $posts,
				'totalPosts' => $totalPosts,
				'message'    => $message,
			];
			$widgetSimilarPosts = ($totalPosts > 0) ? $widgetSimilarPosts : null;
		}
		
		return $widgetSimilarPosts;
	}
    
}
