<?php
	$paymentMethods ??= collect();
?>
<?php if($paymentMethods->count() > 0): ?>
	
	<?php
		$hasCcBox = 0;
	?>
	<?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php if(view()->exists('payment::' . $paymentMethod->name)): ?>
			<?php echo $__env->make('payment::' . $paymentMethod->name, [$paymentMethod->name . 'PaymentMethod' => $paymentMethod], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
		<?php
			$hasCcBox = ($paymentMethod->has_ccbox == 1 && $hasCcBox == 0) ? 1 : $hasCcBox;
		?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/payment/payment-methods/plugins.blade.php ENDPATH**/ ?>