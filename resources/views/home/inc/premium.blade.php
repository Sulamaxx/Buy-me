@php

	$sectionOptions = $getPremiumListingsOp ?? [];
	//$sectionOptions = $getLatestListingsOp ?? [];
	$sectionData ??= [];
	$widget = (array)data_get($sectionData, 'premium');
	//$widget = (array)data_get($sectionData, 'latest');
	$widgetType = 'home'; 
	//$widget['posts'] = $topPosts;
    //$widget['totalPosts'] = count($topPosts);
	$widget['title'] = 'Top Ads';
	$widget['link_text'] = 'See All Top Ads';
@endphp
@includeFirst([
    config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $widgetType,
    'search.inc.posts.widget.' . $widgetType
],
    ['widget' => $widget, 'sectionOptions' => $sectionOptions]
)
