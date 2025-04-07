@php
    $sectionOptions = $getLatestListingsOp ?? [];
    $sectionData ??= [];
    $widget = (array)data_get($sectionData, 'latest');
    $widgetType = 'home'; 
	$widget['title'] = 'Latest Ads';
	$widget['link_text'] = 'See All Latest Ads';
@endphp
@includeFirst([
    config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $widgetType,
    'search.inc.posts.widget.' . $widgetType
],
    ['widget' => $widget, 'sectionOptions' => $sectionOptions]
)