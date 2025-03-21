<?php if($xPanel->hasAccess('update')): ?>
	<?php if(!$xPanel->model->translationEnabled()): ?>
		
		
		<a href="<?php echo e(url($xPanel->route . '/' . $entry->getKey() . '/edit')); ?>" class="btn btn-xs btn-primary">
			<i class="far fa-edit"></i> <?php echo e(trans('admin.edit')); ?>

		</a>
	
	<?php else: ?>
		
		
		<div class="btn-group">
			<a href="<?php echo e(url($xPanel->route . '/' . $entry->getKey() . '/edit')); ?>" class="btn btn-xs btn-primary">
				<i class="far fa-edit"></i> <?php echo e(trans('admin.edit')); ?>

			</a>
			<a class="btn btn-xs btn-primary dropdown-toggle dropdown-toggle-split text-white" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="sr-only">Toggle</span>
			</a>
			<ul class="dropdown-menu dropdown-menu-end">
				<li class="dropdown-header"><?php echo e(trans('admin.edit_translations')); ?>:</li>
				<?php $__currentLoopData = $xPanel->model->getAvailableLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale => $localeName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<a class="dropdown-item ps-3 pe-3 pt-1 pb-1" href="<?php echo e(url($xPanel->route . '/' . $entry->getKey() . '/edit')); ?>?locale=<?php echo e($locale); ?>">
						<?php echo e($localeName); ?>

					</a>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	
	<?php endif; ?>
<?php endif; ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/buttons/update.blade.php ENDPATH**/ ?>