<?php
	$sectionOptions = $getLatestListingsOp ?? [];
	$sectionData ??= [];
	$widget = (array)data_get($sectionData, 'latest');
	$widgetType = (data_get($sectionOptions, 'items_in_carousel') == '1') ? 'carousel' : 'normal';
?>
<?php echo $__env->first([
		config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $widgetType,
		'search.inc.posts.widget.' . $widgetType
	],
	['widget' => $widget, 'sectionOptions' => $sectionOptions]
, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/inc/latest.blade.php ENDPATH**/ ?>