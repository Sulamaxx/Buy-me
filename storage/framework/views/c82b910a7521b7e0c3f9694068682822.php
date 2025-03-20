<?php if(isset($wizardMenu) && !empty($wizardMenu)): ?>
<div id="stepWizard" class="container">
    <div class="row">
        <div class="col-12">
            <section>
                <div class="wizard">
                    
                    <ul class="nav nav-wizard">
						<?php $__currentLoopData = $wizardMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(!$menu['condition']) continue; ?>
							<li class="<?php echo e($menu['class']); ?>">
								<?php if(!empty($menu['url'])): ?>
									<a href="<?php echo e($menu['url']); ?>"><?php echo e($menu['name']); ?></a>
								<?php else: ?>
									<a><?php echo e($menu['name']); ?></a>
								<?php endif; ?>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    
                </div>
            </section>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startSection('after_styles'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
	<?php if(config('lang.direction') == 'rtl'): ?>
    	<link href="<?php echo e(url('assets/css/rtl/wizard.css')); ?>" rel="stylesheet">
	<?php else: ?>
		<link href="<?php echo e(url('assets/css/wizard.css')); ?>" rel="stylesheet">
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
<?php $__env->stopSection(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/createOrEdit/multiSteps/inc/wizard.blade.php ENDPATH**/ ?>