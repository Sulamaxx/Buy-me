<div class="alert alert-info" role="alert">
	<?php if(request()->query('filter') == 'unread'): ?>
		<?php echo e(t('No new thread or with new messages')); ?>

	<?php elseif(request()->query('filter') == 'started'): ?>
		<?php echo e(t('No thread started by you')); ?>

	<?php elseif(request()->query('filter') == 'important'): ?>
		<?php echo e(t('No message marked as important')); ?>

	<?php else: ?>
		<?php echo e(t('No message received')); ?>

	<?php endif; ?>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/threads/no-threads.blade.php ENDPATH**/ ?>