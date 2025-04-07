<?php

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
?>
<?php echo $__env->first([
    config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $widgetType,
    'search.inc.posts.widget.' . $widgetType
],
    ['widget' => $widget, 'sectionOptions' => $sectionOptions]
, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/inc/premium.blade.php ENDPATH**/ ?>