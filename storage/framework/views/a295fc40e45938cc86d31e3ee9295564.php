<?php
	$accountMenu ??= collect();
	$accountMenu = ($accountMenu instanceof \Illuminate\Support\Collection) ? $accountMenu : collect();
?>
<aside>
	<div class="inner-box">
		<div class="user-panel-sidebar">
			
			<?php if($accountMenu->isNotEmpty()): ?>
				<?php $__currentLoopData = $accountMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$boxId = str($group)->slug();
					?>
					<div class="collapse-box">
						<h5 class="collapse-title no-border">
							<?php echo e($group); ?>&nbsp;
							<a href="#<?php echo e($boxId); ?>" data-bs-toggle="collapse" class="float-end"><i class="fa fa-angle-down"></i></a>
						</h5>
						<?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="panel-collapse collapse show" id="<?php echo e($boxId); ?>">
								<ul class="acc-list">
									<li>
										<a <?php echo $value['isActive'] ? 'class="active"' : ''; ?> href="<?php echo e($value['url']); ?>">
											<i class="<?php echo e($value['icon']); ?>"></i> <?php echo e($value['name']); ?>

											<?php if(!empty($value['countVar'])): ?>
												<span class="badge badge-pill<?php echo e($value['cssClass'] ?? ''); ?>">
													<?php echo e(\App\Helpers\Number::short($value['countVar'])); ?>

												</span>
											<?php endif; ?>
										</a>
									</li>
								</ul>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			
		</div>
	</div>
</aside>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/account/inc/sidebar.blade.php ENDPATH**/ ?>