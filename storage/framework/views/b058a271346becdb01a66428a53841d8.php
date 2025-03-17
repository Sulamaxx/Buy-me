<?php $__currentLoopData = $feeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $feed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link rel="alternate" type="<?php echo e(\Spatie\Feed\Helpers\FeedContentType::forLink($feed['format'] ?? 'atom')); ?>" href="<?php echo e(route("feeds.{$name}")); ?>" title="<?php echo e($feed['title']); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/vendor/feed/links.blade.php ENDPATH**/ ?>