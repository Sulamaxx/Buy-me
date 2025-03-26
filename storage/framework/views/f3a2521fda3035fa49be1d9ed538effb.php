<?php
	$thread ??= [];
	$messages ??= [];
	$totalMessages = (int)($totalMessages ?? 0);
?>
<?php if(!empty($messages) && $totalMessages > 0): ?>
	<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $__env->make('account.messenger.messages.message', ['thread' => $thread, 'message' => $message], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/messages/messages.blade.php ENDPATH**/ ?>