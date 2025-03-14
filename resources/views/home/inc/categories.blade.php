<?php
$sectionOptions = $getCategoriesOp ?? [];
$sectionData ??= [];
$categories = (array)data_get($sectionData, 'categories');
$subCategories = (array)data_get($sectionData, 'subCategories');
$countPostsPerCat = (array)data_get($sectionData, 'countPostsPerCat');
$countPostsPerCat = collect($countPostsPerCat)->keyBy('id')->toArray();

$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';

$catDisplayType = data_get($sectionOptions, 'cat_display_type');
$maxSubCats = (int)data_get($sectionOptions, 'max_sub_cats');

$sectionOptions = $getSearchFormOp ?? [];
$sectionData ??= [];

// Get Search Form Options
$enableFormAreaCustomization = data_get($sectionOptions, 'enable_extended_form_area') ?? '0';
$hideTitles = data_get($sectionOptions, 'hide_titles') ?? '0';

$headerTitle = data_get($sectionOptions, 'title_' . config('app.locale'));
$headerTitle = (!empty($headerTitle)) ? replaceGlobalPatterns($headerTitle) : null;

$headerSubTitle = data_get($sectionOptions, 'sub_title_' . config('app.locale'));
$headerSubTitle = (!empty($headerSubTitle)) ? replaceGlobalPatterns($headerSubTitle) : null;

$parallax = data_get($sectionOptions, 'parallax') ?? '0';
$hideForm = data_get($sectionOptions, 'hide_form') ?? '0';
$displayStatesSearchTip = config('settings.list.display_states_search_tip');
?>
@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile])
<div class="container my-4">
<form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
		<div class="row search-row animated fadeInUp">
			
			<div class="col-md-5 col-sm-12 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
				<div class="search-col-inner">
					<i class="fas {{ (config('lang.direction')=='rtl') ? 'fa-angle-double-left' : 'fa-angle-double-right' }} icon-append"></i>
					<div class="search-col-input">
						<input class="form-control has-icon" name="q" placeholder="{{ t('what') }}" type="text" value="">
					</div>
				</div>
			</div>
			
			<input type="hidden" id="lSearch" name="l" value="">
			
			<div class="col-md-5 col-sm-12 search-col relative locationicon mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0 d-none d-md-block d-lg-block d-xl-block">
				<div class="search-col-inner">
					<i class="fas fa-map-marker-alt icon-append"></i>
					<div class="search-col-input">
						@if ($displayStatesSearchTip)
							<input class="form-control locinput input-rel searchtag-input has-icon"
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
							<input class="form-control locinput input-rel searchtag-input has-icon"
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
			
			<div class="col-md-2 col-sm-12 search-col">
				<div class="search-btn-border bg-primary">
					<button class="btn btn-primary btn-search btn-block btn-gradient" style="width: 100%;">
						<i class="fas fa-search"></i> <strong>{{ t('find') }}</strong>
					</button>
				</div>
			</div>
			
		</div>
	</form>
</div>

<div class="container{{ $hideOnMobile }}">
	<div class="col-xl-14 content-box layout-section">
		<div class="row row-featured row-featured-category">
			<div class="col-xl-14 box-title no-border">
				<div class="inner">
					<h2>
					 <!--	<span class="title-3">{{ t('Browse by') }} </span> -->
						<a href="{{ \App\Helpers\UrlGen::sitemap() }}" class="sell-your-item">
					 <!--		{{ t('View more') }} <i class="fas fa-bars"></i>  -->
						</a>
					</h2>
				</div>
			</div>
			
			@if ($catDisplayType == 'c_picture_list')
				<!-- all category display #001 
				<div class="col-lg-2 col-md-3 col-sm-4 col-3 f-category">
				     <a href="/search?c=&q=&r=&l=&location=">
				          <img  src="/public/images/all-icon.png" class="img-fluid" alt="All"><BR> <h4> {{ t('All') }} </h4> </a> 
				     
			    </div>-->
			   
<style>
    .custom-col-lg {
        width: 14.285714% !important; /* 7 items per row for large screens */
    }
        .f-category {
    	padding: 10px 10px 10px !important;
    }
    
    @media (max-width: 767.98px) {
    .custom-col-lg {
        width: 33.3% !important; /* 2 items per row for small screens (50% else 33.3) */
    }
     .f-category {
    	padding: 5px 5px 5px 5px !important;
    }

}
 
</style>
           
				@if (!empty($categories))
					@foreach($categories as $key => $cat)
						  <div class="custom-col-lg custom-col-md custom-col-sm custom-col-xs f-category">
							<a href="{{ \App\Helpers\UrlGen::category($cat) }}">
								<img src="{{ data_get($cat, 'picture_url') }}" class="lazyload img-fluid" alt="{{ data_get($cat, 'name') }}">
								<h4><BR>
									{{ data_get($cat, 'name') }}
									@if (config('settings.list.count_categories_listings'))
										&nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
									@endif
								</h4>
							</a>
						</div>
					@endforeach
				@endif
				
			@elseif ($catDisplayType == 'c_bigIcon_list')
				
				@if (!empty($categories))
					@foreach($categories as $key => $cat)
						  <div class="custom-col-lg custom-col-md custom-col-sm custom-col-xs f-category">
							<a href="{{ \App\Helpers\UrlGen::category($cat) }}" title="{{ \App\Helpers\UrlGen::category($cat) }}">
								@if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
									<i class="{{ data_get($cat, 'icon_class') ?? 'fas fa-folder' }}"></i>
								@endif
								<h6>
									{{ data_get($cat, 'name') }}
									@if (config('settings.list.count_categories_listings'))
										&nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
									@endif
								</h6>
							</a>
						</div>
					@endforeach
				@endif
				
			@elseif (in_array($catDisplayType, ['cc_normal_list', 'cc_normal_list_s']))
				
				<div style="clear: both;"></div>
				<?php $styled = ($catDisplayType == 'cc_normal_list_s') ? ' styled' : ''; ?>
				
				@if (!empty($categories))
					<div class="col-xl-14">
						<div class="list-categories-children{{ $styled }}">
							<div class="row px-3">
								@foreach ($categories as $key => $cols)
									<div class="col-md-4 col-sm-4 {{ (count($categories) == $key+1) ? 'last-column' : '' }}">
										@foreach ($cols as $iCat)
											
											<?php
												$randomId = '-' . substr(uniqid(rand(), true), 5, 5);
											?>
										
											<div class="cat-list">
												<h3 class="cat-title rounded">
													@if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
														<i class="{{ data_get($iCat, 'icon_class') ?? 'fas fa-check' }}"></i>&nbsp;
													@endif
													<a href="{{ \App\Helpers\UrlGen::category($iCat) }}">
														{{ data_get($iCat, 'name') }}
														@if (config('settings.list.count_categories_listings'))
															&nbsp;({{ $countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0 }})
														@endif
													</a>
													<span class="btn-cat-collapsed collapsed"
														  data-bs-toggle="collapse"
														  data-bs-target=".cat-id-{{ data_get($iCat, 'id') . $randomId }}"
														  aria-expanded="false"
													>
														<span class="icon-down-open-big"></span>
													</span>
												</h3>
												<ul class="cat-collapse collapse show cat-id-{{ data_get($iCat, 'id') . $randomId }} long-list-home">
													@if (isset($subCategories[data_get($iCat, 'id')]))
														<?php $catSubCats = $subCategories[data_get($iCat, 'id')]; ?>
														@foreach ($catSubCats as $iSubCat)
															<li>
																<a href="{{ \App\Helpers\UrlGen::category($iSubCat) }}">
																	{{ data_get($iSubCat, 'name') }}
																</a>
																@if (config('settings.list.count_categories_listings'))
																	&nbsp;({{ $countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0 }})
																@endif
															</li>
														@endforeach
													@endif
												</ul>
											</div>
										@endforeach
									</div>
								@endforeach
							</div>
						</div>
						<div style="clear: both;"></div>
					</div>
				@endif
				
			@else
				
				<?php
				$listTab = [
					'c_border_list' => 'list-border',
				];
				$catListClass = (isset($listTab[$catDisplayType])) ? 'list ' . $listTab[$catDisplayType] : 'list';
				?>
				@if (!empty($categories))
					<div class="col-xl-14">
						<div class="list-categories">
							<div class="row">
								@foreach ($categories as $key => $items)
									<ul class="cat-list {{ $catListClass }} col-md-4 {{ (count($categories) == $key+1) ? 'cat-list-border' : '' }}">
										@foreach ($items as $k => $cat)
											<li>
												@if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
													<i class="{{ data_get($cat, 'icon_class') ?? 'fas fa-check' }}"></i>&nbsp;
												@endif
												<a href="{{ \App\Helpers\UrlGen::category($cat) }}">
													{{ data_get($cat, 'name') }}
												</a>
												@if (config('settings.list.count_categories_listings'))
													&nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
												@endif
											</li>
										@endforeach
									</ul>
								@endforeach
							</div>
						</div>
					</div>
				@endif
				
			@endif
	
		</div>
	</div>
</div>



@section('before_scripts')
	@parent
	@if ($maxSubCats >= 0)
		<script>
			var maxSubCats = {{ $maxSubCats }};
		</script>
	@endif
@endsection
