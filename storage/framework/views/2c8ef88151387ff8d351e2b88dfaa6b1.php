


<?php $__env->startSection('title', t('Bad request')); ?>

<?php $__env->startSection('search'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('search'); ?>
	<?php echo $__env->make('errors.layouts.inc.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('common.spacer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						
						<div class="error-page mt-5 mb-5 ms-0 me-0 pt-5">
							<h1 class="headline text-center" style="font-size: 180px;">400</h1>
							<div class="text-center m-l-0 mt-5">
								<h3 class="m-t-0 color-danger">
									<i class="fas fa-exclamation-triangle"></i> <?php echo e(t('Bad request')); ?>

								</h3>
								<p>
									<?php
										$defaultErrorMessage = t('Meanwhile, you may return to homepage', ['url' => url('/')]);
										$extractedMessage = null;
										
										if (isset($exception)) {
											if (is_object($exception) && method_exists($exception, 'getMessage')) {
												$extractedMessage = $exception->getMessage();
												$extractedMessage = str_replace(base_path(), '', $extractedMessage);
											}
										}
										
										echo !empty($extractedMessage) ? $extractedMessage : $defaultErrorMessage;
									?>
								</p>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/errors/400.blade.php ENDPATH**/ ?>