<?php
	$customFields ??= [];
?>
<?php if(!empty($customFields)): ?>
	<div class="row gx-1 gy-1 mt-3">
		<div class="col-12">
			<div class="row mb-3">
				<div class="col-12">
					<h4 class="p-0"><i class="fas fa-bars"></i> <?php echo e(t('Additional Details')); ?></h4>
				</div>
			</div>
		</div>
		
		<div class="col-12">
			<div class="row gx-1 gy-1">
				<?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$fieldType = data_get($field, 'type');
						$fieldName = data_get($field, 'name');
						$fieldValue = data_get($field, 'value');
					?>
					<?php if(is_array($fieldValue)): ?>
						<?php if(count($fieldValue) > 0): ?>
							<div class="col-12">
								<div class="row bg-light rounded py-2 mx-0">
									<div class="col-12 mb-2 fw-bolder"><?php echo e($fieldName); ?>:</div>
									<div class="row">
										<?php $__currentLoopData = $fieldValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valueItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="col-sm-4 col-6 py-2">
												<i class="fa fa-check"></i> <?php echo e($valueItem); ?>

											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php else: ?>
						<?php if(is_string($fieldValue) || is_numeric($fieldValue) || is_bool($fieldValue)): ?>
							<?php if($fieldType == 'file'   ): ?>
								<div class="col-12"  style="display: <?php echo e(auth()->user()->is_admin == 1 ? 'block' : 'none'); ?>;">
									<div class="row bg-light rounded py-2 mx-0">
										<div class="col-6 fw-bolder"><?php echo e($fieldName); ?></div>
										<div class="col-6 text-sm-end text-start">
											<a class="btn btn-default" href="<?php echo e($fieldValue); ?>" target="_blank">
												<i class="fas fa-paperclip"></i> <?php echo e(t('Download')); ?>

											</a>
										</div>
									</div>
								</div>
							<?php elseif($fieldType == 'video'): ?>
								<div class="col-12">
									<div class="row bg-light rounded py-2 mx-0">
										<div class="col-12 fw-bolder"><?php echo e($fieldName); ?>:</div>
										<div class="col-12 text-center embed-responsive embed-responsive-16by9">
											<?php echo $fieldValue; ?>

										</div>
									</div>
								</div>
							<?php else: ?>
								<div class="col-sm-6 col-12">
									<div class="row bg-light rounded py-2 mx-0">
										<div class="col-6 fw-bolder"><?php echo e($fieldName); ?></div>
										<div class="col-6 text-sm-end text-start">
											<?php if($fieldType == 'url'): ?>
												<a href="<?php echo e($fieldValue); ?>" target="_blank" rel="nofollow"><?php echo e($fieldValue); ?></a>
											<?php else: ?>
												<?php echo e($fieldValue); ?>

											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/post/show/inc/details/fields-values.blade.php ENDPATH**/ ?>