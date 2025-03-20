<?php
	$paymentMethods ??= collect();
	$payment ??= [];
?>
<div class="row mb-3 mb-0">
	<?php
		$paymentMethodIdError = (isset($errors) && $errors->has('payment_method_id')) ? ' is-invalid' : '';
	?>
	<div class="col-md-10 col-sm-12 p-0">
		<select class="form-control selecter<?php echo e($paymentMethodIdError); ?>" name="payment_method_id" id="paymentMethodId">
			<?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(view()->exists('payment::' . $paymentMethod->name)): ?>
					<?php
						$paymentMethodCheckedAttr = (
								old(
									'payment_method_id',
									data_get($payment, 'paymentMethod.id', 0)
								) == $paymentMethod->id
							)
								? 'selected="selected"'
								: '';
					?>
            <?php
            //start of code hide online payment if package type is subscription
            if ($packageType=='subscription')
            {
                if ($paymentMethod->name == 'offlinepayment')
                {
                    ?>
            <option value="<?php echo e($paymentMethod->id); ?>" data-name="<?php echo e($paymentMethod->name); ?>"<?php echo e($paymentMethodCheckedAttr); ?>>
						<?php if($paymentMethod->name == 'offlinepayment'): ?>
							<?php echo e(trans('offlinepayment::messages.offline_payment')); ?>

						<?php else: ?>
							<?php echo e($paymentMethod->display_name); ?>

						<?php endif; ?>
					</option>
            
            
            <?php
                }
            }
            else
            {
	    // end of code hide online payment if package type is subscription
            ?>
            
					<option value="<?php echo e($paymentMethod->id); ?>" data-name="<?php echo e($paymentMethod->name); ?>"<?php echo e($paymentMethodCheckedAttr); ?>>
						<?php if($paymentMethod->name == 'offlinepayment'): ?>
							<?php echo e(trans('offlinepayment::messages.offline_payment')); ?>

						<?php else: ?>
							<?php echo e($paymentMethod->display_name); ?>

						<?php endif; ?>
					</option>
            <?php }   ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/payment/payment-methods.blade.php ENDPATH**/ ?>