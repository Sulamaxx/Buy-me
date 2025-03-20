<div id="recoverform">
	<div class="logo">
		<h3 class="fw-medium mb-3"><?php echo e(trans('admin.reset_password')); ?></h3>
		
	</div>
	
	<div class="row mt-3">
		<form class="col-12" action="<?php echo e(url('password/email')); ?>" method="post">
			<?php echo csrf_field(); ?>

			<?php echo view('honeypot::honeypot'); ?>
			<input type="hidden" name="language_code" value="<?php echo e(config('app.locale')); ?>">
			
			
			<?php
				if (isset($errors)) {
					$emailHasError = $errors->has('email');
					$emailRowError = $emailHasError ? ' has-danger' : '';
					$emailFieldError = $emailHasError ? ' form-control-danger' : '';
					$emailError = $errors->first('email');
				}
			?>
			<div class="row mb-3 auth-field-item<?php echo e($emailRowError ?? ''); ?>">
				<?php if(config('settings.sms.enable_phone_as_auth_field') == '1'): ?>
					<div class="col-12 pb-1">
						<a href="" class="auth-field text-muted" data-auth-field="phone"><?php echo e(t('use_phone')); ?></a>
					</div>
				<?php endif; ?>
				<div class="input-group">
					<span class="input-group-text"><i class="fas fa-user"></i></span>
					<input id="mEmail" name="email"
						   type="text"
						   placeholder="<?php echo e(trans('admin.email_address')); ?>"
						   class="form-control<?php echo e($emailFieldError ?? ''); ?>"
						   value="<?php echo e(old('email')); ?>"
					>
				</div>
				<?php if(isset($emailHasError) && $emailHasError): ?>
					<div class="invalid-feedback"><?php echo e($emailError ?? ''); ?></div>
				<?php endif; ?>
			</div>
			
			
			<?php if(config('settings.sms.enable_phone_as_auth_field') == '1'): ?>
				<?php
					if (isset($errors)) {
						$phoneHasError = $errors->has('phone');
						$phoneRowError = $emailHasError ? ' has-danger' : '';
						$phoneFieldError = $emailHasError ? ' form-control-danger' : '';
						$phoneError = $errors->first('email');
					}
				?>
				<div class="row mb-3 auth-field-item<?php echo e($phoneHasError ?? ''); ?>">
					<div class="col-12 pb-1">
						<a href="" class="auth-field text-muted" data-auth-field="email"><?php echo e(t('use_email')); ?></a>
					</div>
					<div class="">
						<input id="mPhone" name="phone"
							   type="tel"
							   class="form-control m-phone<?php echo e($phoneRowError ?? ''); ?>"
							   value="<?php echo e(phoneE164(old('phone'), old('phone_country', 'us'))); ?>"
						>
						<input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', 'us')); ?>">
					</div>
					<?php if(isset($phoneHasError) && $phoneHasError): ?>
						<div class="invalid-feedback"><?php echo e($phoneError ?? ''); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			
			
			<input name="auth_field" type="hidden" value="<?php echo e(old('auth_field', getAuthField())); ?>">
			
			<?php echo $__env->make('layouts.inc.tools.captcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			
			
			<div class="row mb-3">
				<div class="d-flex">
					<div class="ms-auto">
						<a href="javascript:void(0)" id="to-login" class="text-muted float-end">
							<i class="fas fa-sign-in-alt me-1"></i> <?php echo e(trans('admin.login')); ?>

						</a>
					</div>
				</div>
			</div>
			
			
			<div class="row mb-3 text-center mt-4">
				<div class="col-12 d-grid">
					<button class="btn btn-lg btn-primary" type="submit" name="action"><?php echo e(trans('admin.reset')); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/auth/passwords/inc/recover-form.blade.php ENDPATH**/ ?>