<?php
	$countPostsPerCat ??= [];
	
	// Clear Filter Button
	$clearFilterBtn = \App\Helpers\UrlGen::getCategoryFilterClearLink($cat ?? null, $city ?? null);
?>
<?php if(!empty($cat)): ?>
	<?php
		$catParentUrl = \App\Helpers\UrlGen::getCatParentUrl(data_get($cat, 'parent') ?? null, $city ?? null);
	?>
	
	
	<div id="subCatsList">
		<?php if(!empty(data_get($cat, 'children'))): ?>
			
			<div class="block-title has-arrow sidebar-header">
				<h5>
				<span class="fw-bold">
					<?php if(!empty(data_get($cat, 'parent'))): ?>
						<a href="<?php echo e(\App\Helpers\UrlGen::category(data_get($cat, 'parent'), null, $city ?? null)); ?>">
							<i class="fas fa-reply"></i> <?php echo e(data_get($cat, 'parent.name')); ?>

						</a>
					<?php else: ?>
						<a href="<?php echo e($catParentUrl); ?>">
							<i class="fas fa-reply"></i> <?php echo e(t('all_categories')); ?>

						</a>
					<?php endif; ?>
				</span> <?php echo $clearFilterBtn; ?>

				</h5>
			</div>
			<div class="block-content list-filter categories-list">
				<ul class="list-unstyled">
					<li>
						<a href="<?php echo e(\App\Helpers\UrlGen::category($cat, null, $city ?? null)); ?>" title="<?php echo e(data_get($cat, 'name')); ?>">
							<span class="title fw-bold">
								<?php if(in_array(config('settings.list.show_category_icon'), [4, 5, 6, 8])): ?>
									<i class="<?php echo e(data_get($cat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
								<?php endif; ?>
								<?php echo e(data_get($cat, 'name')); ?>

							</span>
							<?php if(config('settings.list.count_categories_listings')): ?>
								<span class="count">&nbsp;(<?php echo e($countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0); ?>)</span>
							<?php endif; ?>
						</a>
						<ul class="list-unstyled long-list">
							<?php $__currentLoopData = data_get($cat, 'children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li>
									<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat, null, $city ?? null)); ?>" title="<?php echo e(data_get($iSubCat, 'name')); ?>">
										<?php if(in_array(config('settings.list.show_category_icon'), [4, 5, 6, 8])): ?>
											<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
										<?php endif; ?>
										<?php echo e(str(data_get($iSubCat, 'name'))->limit(100)); ?>

										<?php if(config('settings.list.count_categories_listings')): ?>
											<span class="count">&nbsp;(<?php echo e($countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0); ?>)</span>
										<?php endif; ?>
									</a>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</li>
				</ul>
			</div>
			
		<?php else: ?>
			
			<?php if(!empty(data_get($cat, 'parent.children'))): ?>
				<div class="block-title has-arrow sidebar-header">
					<h5>
						<span class="fw-bold">
							<?php if(!empty(data_get($cat, 'parent.parent'))): ?>
								<a href="<?php echo e(\App\Helpers\UrlGen::category(data_get($cat, 'parent.parent'), null, $city ?? null)); ?>">
									<i class="fas fa-reply"></i> <?php echo e(data_get($cat, 'parent.parent.name')); ?>

								</a>
							<?php elseif(!empty(data_get($cat, 'parent'))): ?>
								<a href="<?php echo e(\App\Helpers\UrlGen::category(data_get($cat, 'parent'), null, $city ?? null)); ?>">
									<i class="fas fa-reply"></i> <?php echo e(data_get($cat, 'name')); ?>

								</a>
							<?php else: ?>
								<a href="<?php echo e($catParentUrl); ?>">
									<i class="fas fa-reply"></i> <?php echo e(t('all_categories')); ?>

								</a>
							<?php endif; ?>
						</span> <?php echo $clearFilterBtn; ?>

					</h5>
				</div>
				<div class="block-content list-filter categories-list">
					<ul class="list-unstyled">
						<?php $__currentLoopData = data_get($cat, 'parent.children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li>
								<?php if(data_get($iSubCat, 'id') == data_get($cat, 'id')): ?>
									<strong>
										<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat, null, $city ?? null)); ?>" title="<?php echo e(data_get($iSubCat, 'name')); ?>">
											<?php if(in_array(config('settings.list.show_category_icon'), [4, 5, 6, 8])): ?>
												<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
											<?php endif; ?>
											<?php echo e(str(data_get($iSubCat, 'name'))->limit(100)); ?>

											<?php if(config('settings.list.count_categories_listings')): ?>
												<span class="count">&nbsp;(<?php echo e($countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0); ?>)</span>
											<?php endif; ?>
										</a>
									</strong>
								<?php else: ?>
									<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat, null, $city ?? null)); ?>" title="<?php echo e(data_get($iSubCat, 'name')); ?>">
										<?php if(in_array(config('settings.list.show_category_icon'), [4, 5, 6, 8])): ?>
											<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
										<?php endif; ?>
										<?php echo e(str(data_get($iSubCat, 'name'))->limit(100)); ?>

										<?php if(config('settings.list.count_categories_listings')): ?>
											<span class="count">&nbsp;(<?php echo e($countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0); ?>)</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			<?php else: ?>
				
				<?php echo $__env->first(
					[config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories.root', 'search.inc.sidebar.categories.root'],
					['countPostsPerCat' => $countPostsPerCat]
				, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			
			<?php endif; ?>
			
		<?php endif; ?>
	</div>
	
<?php else: ?>
	
	<?php echo $__env->first(
		[config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories.root', 'search.inc.sidebar.categories.root'],
		['countPostsPerCat' => $countPostsPerCat]
	, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
<?php endif; ?>
<div style="clear:both"></div>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/search/inc/sidebar/categories.blade.php ENDPATH**/ ?>