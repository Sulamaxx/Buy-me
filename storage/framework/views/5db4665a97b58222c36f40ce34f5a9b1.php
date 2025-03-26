<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => config('app.url')]); ?>
	<img width="200px" height="auto" src="<?php echo e(config('settings.app.logo_url')); ?>">
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>


<?php echo e($slot); ?>



<?php if(isset($subcopy)): ?>
<?php $__env->slot('subcopy'); ?>
<?php $__env->startComponent('mail::subcopy'); ?>
<?php echo e($subcopy); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php endif; ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
© <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. <?php echo app('translator')->get('mail.All rights reserved.'); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/vendor/mail/html/message.blade.php ENDPATH**/ ?>