{{--
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
--}}
@extends('layouts.master')

@php
    $displayStatesSearchTip = config('settings.list.display_states_search_tip');
	
@endphp

@section('search')
    
@endsection

@section('content')
    <div class="main-container {{-- .main-container-mobile --}}" id="homepage" style>

        @if (session()->has('flash_notification'))
            @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
            @php
                $paddingTopExists = true;
            @endphp
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @include('flash::message')
                    </div>
                </div>
            </div>
        @endif

        @if (!empty($sections))
            @php
                //  Log::info('sections - '.print_r($sections,true));
            @endphp
            @foreach ($sections as $section)
                @php
                    $section ??= [];
                    $sectionView = data_get($section, 'view');
                    $sectionData = (array) data_get($section, 'data');
                @endphp
                @if (!empty($sectionView) && view()->exists($sectionView))
                    @includeFirst(
                        [config('larapen.core.customizedViewPath') . $sectionView, $sectionView],
                        [
                            'sectionData' => $sectionData,
                            'firstSection' => $loop->first,
                            'slider' => isset($slider) ? $slider : [],
                        ]
                    )
                @endif
            @endforeach
        @endif

    </div>
    <style>
        @media (max-width: 767px) {
            .main-container-mobile {
                margin-top: 40px;
            }
        }
    </style>
    <style>
        @media (min-width: 768px) {
            .navbar-desktop {
                justify-content: end;
            }

            .category-options {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }

            .category-item {
                margin-right: 0;
            }
        }

        @media (min-width: 1024px) {
            .margin-l-null {
                margin-left: 0% !important;
                padding-left: 0px;
                padding-right: 0px;
            }

            .font-size-d {
                font-size: 13px !important;
            }
        }

        @media (min-width: 1440px) {

            .font-size-d {
                font-size: 16px !important;
            }
        }

        
    </style>
@endsection

@section('after_scripts')
    
@endsection
