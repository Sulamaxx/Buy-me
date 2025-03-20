<?php if(isset($errors) && $errors->any()): ?>
    <div class="col-xl-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
            <h5><strong><?php echo e(t('oops_an_error_has_occurred')); ?></strong></h5>
            <ul class="list list-check">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?php if(session()->has('flash_notification')): ?>
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/inc/notification.blade.php ENDPATH**/ ?>