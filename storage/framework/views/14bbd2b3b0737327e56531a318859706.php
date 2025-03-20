<?php $__currentLoopData = session('flash_notification', collect())->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if($message['overlay']): ?>
		<?php echo $__env->make('flash::modal', [
			'modalClass' => 'flash-modal',
			'title'      => $message['title'],
			'body'       => $message['message']
		], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php else: ?>
		<div class="alert alert-<?php echo e($message['level']); ?> <?php echo e($message['important'] ? 'alert-dismissible' : ''); ?>" role="alert">
			<?php if($message['important']): ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
			<?php endif; ?>
			
			<?php echo $message['message']; ?>

		</div>
	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php echo e(session()->forget('flash_notification')); ?>

<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/vendor/flash/message.blade.php ENDPATH**/ ?>