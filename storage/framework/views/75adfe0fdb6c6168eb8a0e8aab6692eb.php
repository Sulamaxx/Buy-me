<?php if(!empty($cats)): ?>
	<div class="row row-cols-lg-4 row-cols-md-3 p-2 g-2" id="categoryBadge">
		<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="col">
				<?php if(!empty($cat) && data_get($iCat, 'id') == data_get($cat, 'id')): ?>
					<span class="fw-bold">
						<?php if(in_array(config('settings.list.show_category_icon'), [3, 5, 7, 8])): ?>
							<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
						<?php endif; ?>
						<?php echo e(data_get($iCat, 'name')); ?>

					</span>
				<?php else: ?>
					<a href="<?php echo e(\App\Helpers\UrlGen::category($iCat, null, $city ?? null)); ?>">
						<?php if(in_array(config('settings.list.show_category_icon'), [3, 5, 7, 8])): ?>
							<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
						<?php endif; ?>
						<?php echo e(data_get($iCat, 'name')); ?>

					</a>
				<?php endif; ?>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/categories-root.blade.php ENDPATH**/ ?>