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
<div class="container search-container d-md-none" style="width: 100vw;padding:0%;margin:0%">
	<form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
		<div class="row search-row animated fadeInUp border-null" >

			<div class="col-6 col-lg-6 col-md-5 col-sm-12 search-col relative mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
				<div class="search-col-inner">
					<div class="search-col-input" style="margin-left: 0px;width: 100%;">
						<input class="form-control" name="q" placeholder="{{ t('what') }}" type="text" value="" style="border-radius:0% !important;">
					</div>
				</div>
			</div>

			<input type="hidden" id="lSearch" name="l" value="">

			<div class="col-4 col-lg-4 col-md-5 col-sm-12 search-col relative locationicon mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
				<div class="search-col-inner">
					<div class="search-col-input" style="margin-left: 0px; width: 100%;">
						@if ($displayStatesSearchTip)
							<input class="form-control locinput input-rel searchtag-input"
							style="border-radius:0% !important;"
								   id="locSearch"
								   name="location"
								   placeholder="{{ t('where') }}"
								   type="text"
								   value=""
								   data-bs-placement="top"
								   data-bs-toggle="tooltipHover"
								   title="{{ t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name') }}"
							>
						@else
							<input class="form-control locinput input-rel searchtag-input"
							style="border-radius:0% !important;"
								   id="locSearch"
								   name="location"
								   placeholder="{{ t('where') }}"
								   type="text"
								   value=""
							>
						@endif
					</div>
				</div>
			</div>

			<div class="col-2 col-lg-2 col-md-2 col-sm-12 search-col" style="border-left: 1px solid black;">
				<div class="search-btn-border bg-primary">
					<button class="btn btn-primary btn-search btn-block" style="width: 100%;border-radius: 0px !important;background-color: #e5e5e5 !important;padding:0px">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" style="width: 1.5em; height: 1.5em;">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
						</svg>
					</button>
				</div>
			</div>

		</div>
	</form>
</div>
@endsection

@section('content')
	<div class="main-container main-container-mobile" id="homepage">
		
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
			@foreach($sections as $section)
			    
				@php
					$section ??= [];
					$sectionView = data_get($section, 'view');
					$sectionData = (array)data_get($section, 'data');
				@endphp
				@if (!empty($sectionView) && view()->exists($sectionView))
					@includeFirst(
						[
							config('larapen.core.customizedViewPath') . $sectionView,
							$sectionView
						],
						[
							'sectionData' => $sectionData,
							'firstSection' => $loop->first,
							'slider' => isset($slider) ? $slider : []
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
@endsection

@section('after_scripts')
@endsection
