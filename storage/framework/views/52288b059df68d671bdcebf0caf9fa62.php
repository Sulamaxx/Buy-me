<?php
$sectionOptions = $getTextAreaOp ?? [];
$sectionData ??= [];

// Fallback Language
$textTitle = data_get($sectionOptions, 'title_' . config('appLang.abbr'));
$textTitle = replaceGlobalPatterns($textTitle);

$textBody = data_get($sectionOptions, 'body_' . config('appLang.abbr'));
$textBody = replaceGlobalPatterns($textBody);

// Current Language
if (!empty(data_get($sectionOptions, 'title_' . config('app.locale')))) {
	$textTitle = data_get($sectionOptions, 'title_' . config('app.locale'));
	$textTitle = replaceGlobalPatterns($textTitle);
}

if (!empty(data_get($sectionOptions, 'body_' . config('app.locale')))) {
	$textBody = data_get($sectionOptions, 'body_' . config('app.locale'));
	$textBody = replaceGlobalPatterns($textBody);
}

$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';
?>
<?php if(!empty($textTitle) || !empty($textBody)): ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="container<?php echo e($hideOnMobile); ?>">
		<div class="card">
			<div class="card-body">
				<?php if(!empty($textTitle)): ?>
					<h2 class="card-title"><?php echo e($textTitle); ?></h2>
				<?php endif; ?>
				<?php if(!empty($textBody)): ?>
					<div><?php echo $textBody; ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/home/inc/text-area.blade.php ENDPATH**/ ?>