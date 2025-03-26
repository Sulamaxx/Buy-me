<?php
    $apiResult ??= [];
	$isPaginable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
	$paginator = data_get($apiResult, 'links');
?>
<?php if($isPaginable): ?>
    <div class="btn-group btn-group-sm">
        
        <?php if(!data_get($apiResult, 'links.prev')): ?>
            <button type="button" class="btn btn-secondary disabled" aria-disabled="true">
                <span class="fas fa-arrow-left"></span>
            </button>
        <?php else: ?>
            <a class="btn btn-secondary" href="<?php echo e(data_get($paginator, 'prev')); ?>" rel="prev">
                <span class="fas fa-arrow-left"></span>
            </a>
        <?php endif; ?>
        
        
        <?php if(data_get($paginator, 'next')): ?>
            <a class="btn btn-secondary" href="<?php echo e(data_get($paginator, 'next')); ?>" rel="next">
                <span class="fas fa-arrow-right"></span>
            </a>
        <?php else: ?>
            <button type="button" class="btn btn-secondary disabled" aria-disabled="true">
                <span class="fas fa-arrow-right"></span>
            </button>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/threads/pagination.blade.php ENDPATH**/ ?>