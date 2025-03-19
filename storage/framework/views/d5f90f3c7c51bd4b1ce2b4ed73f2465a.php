<?php
	$rightAdvertising ??= [];
	$isFromHome ??= false;
	$isFromPostDetails ??= false;
?>
<?php if(!empty($rightAdvertising)): ?>
	<?php
		$margin = '';
		if (!$isFromHome) {
			$margin = ' mb-3';
		}
		if ($isFromPostDetails) {
			$margin = ' mt-3 mb-3';
		}
	?>
	<?php if($isFromHome): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<!--
	<div class="container<?php echo e($margin); ?>">
		<div class="row">
-->
			<?php
				$responsiveClass = (data_get($rightAdvertising, 'is_responsive') != 1) ? ' d-none d-xl-block d-lg-block d-md-none d-sm-none' : '';
			?>
			
<!--			<div class="col-2 ads-parent-responsive<?php echo e($responsiveClass); ?>">-->
			<div class="col-md-2 col-sm-12 page-sidebar">
				<div class="text-center">
					<?php echo data_get($rightAdvertising, 'tracking_code_large'); ?>

				</div>
			</div>
			<?php if(data_get($rightAdvertising, 'is_responsive') != 1): ?>
				
				<div class="col-12 ads-parent-responsive d-none d-xl-none d-lg-none d-md-block d-sm-none">
					<div class="text-center">
						<?php echo data_get($rightAdvertising, 'tracking_code_medium'); ?>

					</div>
				</div>
				
				<div class="col-12 ads-parent-responsive d-block d-xl-none d-lg-none d-md-none d-sm-block">
					<div class="text-center">
						<?php echo data_get($rightAdvertising, 'tracking_code_small'); ?>

					</div>
				</div>
			<?php endif; ?>
<!--
		</div>
	</div>
-->
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/advertising/right.blade.php ENDPATH**/ ?>