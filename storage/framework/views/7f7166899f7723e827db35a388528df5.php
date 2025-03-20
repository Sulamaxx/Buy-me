<?php if($xPanel->hasAccess('revisions') && count($entry->revisionHistory)): ?>
    <a href="<?php echo e(url($xPanel->route.'/'.$entry->getKey().'/revisions')); ?>" class="btn btn-xs btn-secondary">
        <i class="fas fa-history"></i> <?php echo e(trans('admin.revisions')); ?>

    </a>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/buttons/revisions.blade.php ENDPATH**/ ?>