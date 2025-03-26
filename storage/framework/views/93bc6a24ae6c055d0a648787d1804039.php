<?php
	$apiResult ??= [];
	$from = (int)data_get($apiResult, 'meta.from', 0);
	$to = (int)data_get($apiResult, 'meta.to', 0);
	$totalEntries = (int)data_get($apiResult, 'meta.total', 0);
?>
<?php if($totalEntries > 0): ?>
	<span class="text-muted count-message">
		<strong>
			<?php echo e($from); ?>

		</strong> - <strong>
			<?php echo e($to); ?>

		</strong> <?php echo e(t('of')); ?> <strong>
			<?php echo e($totalEntries); ?>

		</strong>
	</span>
	<?php echo $__env->make('account.messenger.threads.pagination', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/threads/links.blade.php ENDPATH**/ ?>