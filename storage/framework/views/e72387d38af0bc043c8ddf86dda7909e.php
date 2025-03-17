<?php $__env->startSection('title', t('Internal Server Error')); ?>

<?php $__env->startSection('search'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('search'); ?>
	<?php echo $__env->make('errors.layouts.inc.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						
						<div class="error-page mt-5 mb-5 ms-0 me-0 pt-5">
							<h1 class="headline text-center" style="font-size: 180px;">500</h1>
							<div class="text-center m-l-0 mt-5">
								<h3 class="m-t-0 color-danger">
									<i class="fas fa-exclamation-triangle"></i> <?php echo e(t('Internal Server Error')); ?>

								</h3>
								<p>
									<?php
										$isDebugEnabled = config('app.debug');
										$defaultErrorMessage = t('An internal server error has occurred');
										$extractedMessage = null;
										
										if (isset($exception)) {
											if (is_object($exception) && method_exists($exception, 'getMessage')) {
												$extractedMessage = $exception->getMessage();
												$extractedMessage = str_replace(base_path(), '', $extractedMessage);
												
												if (!empty($extractedMessage) && $isDebugEnabled) {
													if (method_exists($exception, 'getFile')) {
														$filePath = $exception->getFile();
														$filePath = str_replace(base_path(), '', $filePath);
														$extractedMessage .= "\n" . 'In the: <code>' . $filePath . '</code> file';
														if (method_exists($exception, 'getLine')) {
															$extractedMessage .= ' at line: <code>' . $exception->getLine() . '</code>';
														}
													}
													$extractedMessage = nl2br($extractedMessage);
												}
											}
										}
										
										echo (!empty($extractedMessage)) ? $extractedMessage : $defaultErrorMessage;
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

<?php echo $__env->make('errors.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/errors/500.blade.php ENDPATH**/ ?>