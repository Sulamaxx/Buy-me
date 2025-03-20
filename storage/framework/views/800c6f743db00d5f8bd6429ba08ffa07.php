<?php
	$hideOnMobile ??= '';
?>
<?php if(isset($paddingTopExists)): ?>
	<?php if(isset($firstSection) && !$firstSection): ?>
		<div class="p-0 mt-lg-4 mt-md-3 mt-3<?php echo e($hideOnMobile); ?>">
			
		</div>
	<?php else: ?>
		<?php if(!$paddingTopExists): ?>
			<div class="p-0 mt-lg-4 mt-md-3 mt-3<?php echo e($hideOnMobile); ?>">
				
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php else: ?>
	<div class="p-0 mt-lg-4 mt-md-3 mt-3<?php echo e($hideOnMobile); ?>">
		
	</div>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/inc/spacer.blade.php ENDPATH**/ ?>