<div id="saveActions">
	
	<input type="hidden" name="save_action" value="<?php echo e($saveAction['active']['value']); ?>">
	
	<div class="btn-group">
		
		<button type="submit" class="btn btn-primary shadow">
			<span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
			<span data-value="<?php echo e($saveAction['active']['value']); ?>"><?php echo e($saveAction['active']['label']); ?></span>
		</button>
		
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-primary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true">
				<span class="caret"></span>
				<span class="sr-only">Toggle Save Dropdown</span>
			</button>
			
			<ul class="dropdown-menu">
				<?php $__currentLoopData = $saveAction['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li><a class="dropdown-item" href="javascript:void(0);" data-value="<?php echo e($value); ?>"><?php echo e($label); ?></a></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	
	</div>
	
	<a href="<?php echo e(url($xPanel->route)); ?>" class="btn btn-secondary shadow"><span class="fa fa-ban"></span> &nbsp;<?php echo e(trans('admin.cancel')); ?></a>
</div><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/inc/form_save_buttons.blade.php ENDPATH**/ ?>