


<?php
	$authUserIsAdmin ??= true;
?>
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
				
				<div class="col-md-3 page-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>

				<div class="col-md-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="fas fa-times-circle"></i> <?php echo e(t('Close account')); ?> </h2>
						<p><?php echo e(t('you_are_sure_you_want_to_close_your_account')); ?></p>

						<?php if($authUserIsAdmin): ?>
							<div class="alert alert-danger" role="alert">
								<?php echo e(t('Admin users can not be deleted by this way')); ?>

							</div>
						<?php else: ?>
							<form role="form" method="POST" action="<?php echo e(url('account/close')); ?>">
								<?php echo csrf_field(); ?>

								
								<div class="form-group row">
									<div class="col-md-12">
										<div class="form-check form-check-inline pt-2">
											<label class="form-check-label">
												<input class="form-check-input"
													   type="radio"
													   name="close_account_confirmation"
													   id="closeAccountConfirmation1"
													   value="1"
												> <?php echo e(t('Yes')); ?>

											</label>
										</div>
										<div class="form-check form-check-inline pt-2">
											<label class="form-check-label">
												<input class="form-check-input"
													   type="radio"
													   name="close_account_confirmation"
													   id="closeAccountConfirmation0"
													   value="0" checked
												> <?php echo e(t('No')); ?>

											</label>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary"><?php echo e(t('submit')); ?></button>
									</div>
								</div>
							</form>
						<?php endif; ?>

					</div>
					<!--/.inner-box-->
				</div>
				<!--/.page-content-->

			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/close.blade.php ENDPATH**/ ?>