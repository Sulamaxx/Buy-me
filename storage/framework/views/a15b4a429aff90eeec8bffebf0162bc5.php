
<?php if(!empty($cats)): ?>
	<?php
		$countPostsPerCat ??= [];
	?>
	<div id="catsList">
		<div class="block-title has-arrow sidebar-header">
			<h5>
				<span class="fw-bold">
					<?php echo e(t('all_categories')); ?>

				</span> <?php echo $clearFilterBtn ?? ''; ?>

			</h5>
		</div>
		<div class="block-content list-filter categories-list">
			<ul class="list-unstyled">
				<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<?php if(isset($cat) && data_get($iCat, 'id') == data_get($cat, 'id')): ?>
							<strong>
								<a href="<?php echo e(\App\Helpers\UrlGen::category($iCat, null, $city ?? null)); ?>" title="<?php echo e(data_get($iCat, 'name')); ?>">
									<span class="title">
										<?php if(in_array(config('settings.list.show_category_icon'), [4, 5, 6, 8])): ?>
											<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
										<?php endif; ?>
										<?php echo e(data_get($iCat, 'name')); ?>

									</span>
									<?php if(config('settings.list.count_categories_listings')): ?>
										<span class="count">&nbsp;<?php echo e($countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0); ?></span>
									<?php endif; ?>
								</a>
							</strong>
						<?php else: ?>
							<a href="<?php echo e(\App\Helpers\UrlGen::category($iCat, null, $city ?? null)); ?>" title="<?php echo e(data_get($iCat, 'name')); ?>">
								<span class="title">
									<?php if(in_array(config('settings.list.show_category_icon'), [4, 5, 6, 8])): ?>
										<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
									<?php endif; ?>
									<?php echo e(data_get($iCat, 'name')); ?>

								</span>
								<?php if(config('settings.list.count_categories_listings')): ?>
									<span class="count">&nbsp;<?php echo e($countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0); ?></span>
								<?php endif; ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	</div>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/sidebar/categories/root.blade.php ENDPATH**/ ?>