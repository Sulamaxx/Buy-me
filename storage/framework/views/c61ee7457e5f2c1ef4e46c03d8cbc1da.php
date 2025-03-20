<?php if($xPanel->reorder): ?>
	<?php if($xPanel->hasAccess('reorder')): ?>
	  <a href="<?php echo e(url($xPanel->route . '/reorder')); ?>" class="btn btn-secondary shadow ladda-button" data-style="zoom-in">
		  <span class="ladda-label">
              <i class="fas fa-arrows-alt" aria-hidden="true"></i> <?php echo e(trans('admin.reorder')); ?> <?php echo $xPanel->entityNamePlural; ?>

          </span>
      </a>
	<?php endif; ?>
<?php endif; ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/buttons/reorder.blade.php ENDPATH**/ ?>