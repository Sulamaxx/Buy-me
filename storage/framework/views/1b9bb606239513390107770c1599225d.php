<div class="modal fade" id="quickLogin" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title"><i class="fas fa-sign-in-alt"></i> <?php echo e(t('log_in')); ?> </h4>
				
				<button type="button" class="close" data-bs-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<form role="form" method="POST" action="<?php echo e(\App\Helpers\UrlGen::login()); ?>">
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							
							<?php echo csrf_field(); ?>

							<input type="hidden" name="language_code" value="<?php echo e(config('app.locale')); ?>">
							
							<?php if(isset($errors) && $errors->any() && old('quickLoginForm')=='1'): ?>
								<div class="alert alert-danger alert-dismissible">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
									<ul class="list list-check">
										<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li><?php echo $error; ?></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								</div>
							<?php endif; ?>
							
							<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'auth.login.inc.social', 'auth.login.inc.social'], ['socialCol' => 12], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php $mtAuth = !socialLoginIsEnabled() ? ' mt-3' : ''; ?>
							
							
							<?php
								$emailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : '';
								$emailValue = (session()->has('email')) ? session('email') : old('email');
							?>
							<div class="mb-3 auth-field-item<?php echo e($mtAuth); ?>">
								<div class="row">
									<?php
										$col = (config('settings.sms.enable_phone_as_auth_field') == '1') ? 'col-6' : 'col-12';
									?>
									<label class="form-label <?php echo e($col); ?> m-0 py-2 text-left" for="email"><?php echo e(t('email')); ?>:</label>
									<?php if(config('settings.sms.enable_phone_as_auth_field') == '1'): ?>
										<div class="col-6 py-2 text-right">
											<a href="" class="auth-field" data-auth-field="phone"><?php echo e(t('login_with_phone')); ?></a>
										</div>
									<?php endif; ?>
								</div>
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
									<input id="mEmail" name="email"
										   type="text"
										   placeholder="<?php echo e(t('email_or_username')); ?>"
										   class="form-control<?php echo e($emailError); ?>"
										   value="<?php echo e($emailValue); ?>"
									>
								</div>
							</div>
							
							
							<?php if(config('settings.sms.enable_phone_as_auth_field') == '1'): ?>
								<?php
									$phoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : '';
									$phoneValue = (session()->has('phone')) ? session('phone') : old('phone');
									$phoneCountryValue = config('country.code');
								?>
								<div class="mb-3 auth-field-item<?php echo e($mtAuth); ?>">
									<div class="row">
										<label class="form-label col-6 m-0 py-2 text-left" for="phone"><?php echo e(t('phone_number')); ?>:</label>
										<div class="col-6 py-2 text-right">
											<a href="" class="auth-field" data-auth-field="email"><?php echo e(t('login_with_email')); ?></a>
										</div>
									</div>
									<input id="mPhone" name="phone"
										   type="tel"
										   class="form-control m-phone<?php echo e($phoneError); ?>"
										   value="<?php echo e(phoneE164($phoneValue, old('phone_country', $phoneCountryValue))); ?>"
									>
									<input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
								</div>
							<?php endif; ?>
							
							
							<input name="auth_field" type="hidden" value="<?php echo e(old('auth_field', getAuthField())); ?>">
							
							
							<?php $passwordError = (isset($errors) && $errors->has('password')) ? ' is-invalid' : ''; ?>
							<div class="mb-3">
								<label for="password" class="control-label"><?php echo e(t('password')); ?></label>
								<div class="input-group show-pwd-group">
									<span class="input-group-text"><i class="fas fa-lock"></i></span>
									<input id="mPassword" name="password"
										   type="password"
										   class="form-control<?php echo e($passwordError); ?>"
										   placeholder="<?php echo e(t('password')); ?>"
										   autocomplete="new-password"
									>
									<span class="icon-append show-pwd">
										<button type="button" class="eyeOfPwd">
											<i class="far fa-eye-slash"></i>
										</button>
									</span>
								</div>
							</div>
							
							
							<?php $rememberError = (isset($errors) && $errors->has('remember')) ? ' is-invalid' : ''; ?>
							<div class="mb-3">
								<label class="checkbox form-check-label float-start mt-2" style="font-weight: normal;">
									<input type="checkbox" value="1" name="remember_me" id="rememberMe2" class="<?php echo e($rememberError); ?>"> <?php echo e(t('keep_me_logged_in')); ?>

								</label>
								<p class="float-end mt-2">
									<a href="<?php echo e(url('password/reset')); ?>">
										<?php echo e(t('lost_your_password')); ?>

									</a> / <a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>">
										<?php echo e(t('register')); ?>

									</a>
								</p>
								<div style=" clear:both"></div>
							</div>
							
							<?php echo $__env->make('layouts.inc.tools.captcha', ['label' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							
							<input type="hidden" name="quickLoginForm" value="1">
							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary float-end"><?php echo e(t('log_in')); ?></button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo e(t('Cancel')); ?></button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/auth/login/inc/modal.blade.php ENDPATH**/ ?>