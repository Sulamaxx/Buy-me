<div class="list-group">
	
	<?php if(!empty($threads) && $totalThreads > 0): ?>
		<?php $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->make('account.messenger.threads.thread', ['thread' => $thread], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<?php echo $__env->make('account.messenger.threads.no-threads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>

</div><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/threads/threads.blade.php ENDPATH**/ ?>