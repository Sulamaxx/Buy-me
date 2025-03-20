


<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">

				<?php if(isset($errors) && $errors->any()): ?>
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo $error; ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>

				<?php if(session('code')): ?>
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<p><?php echo e(session('code')); ?></p>
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
				
				<div class="col-xl-12">
					<div class="alert alert-info">
						<?php echo e(getTokenMessage()); ?>:
					</div>
				</div>

				<div class="col-lg-5 col-md-8 col-sm-10 col-12 login-box mt-2">
					<div class="card card-default">
						
						<div class="panel-intro">
							<div class="d-flex justify-content-center">
								<h2 class="logo-title"><strong><?php echo e(t('Code')); ?></strong></h2>
							</div>
						</div>
						
						<div class="card-body">
							<form id="tokenForm" role="form" method="POST" action="<?php echo e(url(getRequestPath('.*/verify/.*'))); ?>">
								<?php echo csrf_field(); ?>

								<?php echo view('honeypot::honeypot'); ?>
								
								
								<?php $codeError = (isset($errors) && $errors->has('code')) ? ' is-invalid' : ''; ?>
								<div class="mb-3">
									<label for="code" class="col-form-label"><?php echo e(getTokenLabel()); ?>:</label>
									<div class="input-group">
										<span class="input-group-text">
											<i class="bi bi-envelope-exclamation"></i>
										</span>
										<input id="code" name="code"
											   type="text"
											   placeholder="<?php echo e(t('Enter the validation code')); ?>"
											   class="form-control<?php echo e($codeError); ?>"
											   value="<?php echo e(old('code')); ?>"
											   autocomplete="one-time-code"
										>
									</div>
								</div>
								
								<div class="mb-3">
									<button id="tokenBtn" type="submit" class="btn btn-primary btn-lg btn-block"><?php echo e(t('submit')); ?></button>
								</div>
							</form>
						</div>
						
						<div class="card-footer text-center">
							&nbsp;
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		$(document).ready(function () {
			$("#tokenBtn").click(function () {
				$("#tokenForm").submit();
				return false;
			});
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/token.blade.php ENDPATH**/ ?>