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
                if (!empty($cat)) {
                    // Add the current category ID to the array
                    $catChildrenIds[] = (int)$cat->id;
                    
                    // Get all children of this category
                    if (isset($cat->children) && $cat->children->count() > 0) {
                        $this->getAllChildrenIds($cat->children, $catChildrenIds);
                    }
                }
            }

            $catChildrenIds = array_unique($catChildrenIds);
        } else {
            // When 'c' is NOT present, filter by the current page's category and its children
            if (empty($this->cat) || !($this->cat instanceof Category)) {
                return;
            }
    
            // Add the current category ID to the array
            $catChildrenIds[] = (int)$this->cat->id;
            
            // Get all children of this category
            if (isset($this->cat->children) && $this->cat->children->count() > 0) {
                $this->getAllChildrenIds($this->cat->children, $catChildrenIds);
            }
        }
    
        if (!empty($catChildrenIds)) {
            $this->posts->whereIn('category_id', $catChildrenIds);
        }
    }

    /**
     * Get all children IDs recursively
     *
     * @param \Illuminate\Database\Eloquent\Collection $children
     * @param array &$idsArr
     * @return void
     */
    private function getAllChildrenIds($children, array &$idsArr): void
    {
        foreach ($children as $child) {
            if ($child->active == 1) {
                $idsArr[] = (int)$child->id;
                
                if (isset($child->children) && $child->children->count() > 0) {
                    $this->getAllChildrenIds($child->children, $idsArr);
                }
            }
        }
    }
}
