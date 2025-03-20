<?php
    $apiResult = $apiResult ?? [];
	$isPagingable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
	$paginator = (array)data_get($apiResult, 'links');
	$totalEntries = (int)data_get($apiResult, 'meta.total');
	$currentPage = (int)data_get($apiResult, 'meta.current_page');
	$elements = data_get($apiResult, 'meta.links');
?>
<?php if($totalEntries > 0 && $isPagingable): ?>
    <style>
        .pagination {
            display: -ms-flexbox;
            flex-wrap: wrap;
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }
    </style>
    <ul class="pagination justify-content-center" role="navigation">
        
        <?php if(!data_get($paginator, 'prev')): ?>
            <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li>
        <?php else: ?>
            <li class="page-item">
                <a class="page-link" href="" rel="prev" data-url="<?php echo e(data_get($paginator, 'prev')); ?>" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&lsaquo;</a>
            </li>
        <?php endif; ?>

        
        <?php if(is_array($elements) && count($elements) > 0): ?>
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($loop->first || $loop->last) continue; ?>
                
                
                <?php if(!data_get($element, 'url')): ?>
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link"><?php echo e(data_get($element, 'label')); ?></span></li>
                <?php else: ?>
                    
                    <?php if((int)data_get($element, 'label') == $currentPage): ?>
                        <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e(data_get($element, 'label')); ?></span></li>
                    <?php else: ?>
                        <li class="page-item"><a class="page-link" href="" data-url="<?php echo e(data_get($element, 'url')); ?>"><?php echo e(data_get($element, 'label')); ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        
        <?php if(data_get($paginator, 'next')): ?>
            <li class="page-item">
                <a class="page-link" href="" rel="next" data-url="<?php echo e(data_get($paginator, 'next')); ?>" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">&rsaquo;</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                <span class="page-link" aria-hidden="true">&rsaquo;</span>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/vendor/pagination/api/ajax/bootstrap-4.blade.php ENDPATH**/ ?>