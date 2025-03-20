<?php if($xPanel->hasAccess('parent')): ?>
	<a href="<?php echo e(url($xPanel->parentRoute)); ?>" class="btn btn-success shadow ladda-button" data-style="zoom-in">
		<span class="ladda-label">
            <i class="fas fa-reply"></i> <?php echo e(trans('admin.go_to')); ?> <?php echo $xPanel->parentEntityNamePlural; ?>

        </span>
    </a>
<?php endif; ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/buttons/parent.blade.php ENDPATH**/ ?>