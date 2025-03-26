<?php
    $apiResult ??= [];
	$isPaginable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
	$paginator = data_get($apiResult, 'links');
?>
<?php if($isPaginable): ?>
    
    <?php if(data_get($paginator, 'next')): ?>
        <span class="text-muted">
            <a class="btn btn-sm btn-secondary rounded mb-3" href="<?php echo e(data_get($paginator, 'next')); ?>" rel="next">
                <?php echo e(t('Load old messages')); ?>

            </a>
        </span>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/messages/pagination.blade.php ENDPATH**/ ?>