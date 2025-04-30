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

namespace App\Helpers\Search\Traits\Filters;

use App\Models\Category;

trait CategoryFilter
{
    protected function applyCategoryFilter(): void
    {

        if (!isset($this->posts)) {
            return;
        }
    
        $catChildrenIds = []; // Initialize the accumulator array
    
        if (request()->has('c')) {
            $selectedCategories = request()->input('c', []);
    
            if (empty($selectedCategories)) {
                return;
            }
    
            foreach ((array)$selectedCategories as $catId) {
                // Find the selected category (assuming 'c' is ID or slug)
                $cat = Category::where('id', $catId)->orWhere('slug', $catId)->first();
                if ($cat) {
                    // Call the corrected method, passing the main accumulator array by reference
                    $this->getCategoryChildrenIds($cat, $catChildrenIds);
                }
            }
    
            $catChildrenIds = array_unique($catChildrenIds);
    
        } else {
            // When 'c' is NOT present, filter by the current page's category and its children
            if (empty($this->cat) || !($this->cat instanceof Category)) {
                return;
            }
    
            // Call the corrected method, passing the main accumulator array by reference
            $this->getCategoryChildrenIds($this->cat, $catChildrenIds);
        }
    
        if (!empty($catChildrenIds)) {
            $this->posts->whereIn('category_id', $catChildrenIds);
        }

        
    }

    /**
     * Get all the category's children IDs recursively
     *
     * @param $cat
     * @param null $catId
     * @param array $idsArr
     * @return array
     */
    private function getCategoryChildrenIds($cat, $catId = null, array &$idsArr = []): array
    {

        if (!empty($cat->id)) {
            $idsArr[] = (int)$cat->id;
        }
    
      
        if (isset($cat->children) && $cat->children->count() > 0) {
            foreach ($cat->children as $subCat) {
                if ($subCat->active == 1) {
                   
                    $this->getCategoryChildrenIds($subCat, $idsArr);
                }
            }
        }
    
        
        return $idsArr;

        
    }
}