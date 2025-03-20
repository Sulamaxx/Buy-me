


<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">

				<?php if(session()->has('flash_notification')): ?>
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="col-md-12 page-content">

					<?php if(session()->has('message')): ?>
						<div class="inner-box">
							<div class="row">
								<div class="col-xl-12">
									<div class="alert alert-success pgray alert-lg mb-0" role="alert">
										<h2 class="no-padding mb20">&#10004; <?php echo e(t('congratulations')); ?></h2>
										<p class="mb-0">
											<?php echo e(session('message')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(t('Homepage')); ?></a>
										</p>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php
	if (!session()->has('emailVerificationSent') && !session()->has('phoneVerificationSent')) {
		if (session()->has('message')) {
			session()->forget('message');
		}
	}
?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/auth/register/finish.blade.php ENDPATH**/ ?>