<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<?php if(isset($errors) && $errors->any()): ?>
					<div class="col-12">
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
							<h5><strong><?php echo e(t('oops_an_error_has_occurred')); ?></strong></h5>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if(session()->has('flash_notification')): ?>
					<div class="col-12">
						<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
				<?php endif; ?>
				
				<div class="col-md-8 page-content">
					<div class="inner-box">
						<h2 class="title-2">
							<strong><i class="fas fa-user-plus"></i> <?php echo e(t('create_your_account_it_is_quick')); ?></strong>
						</h2>
						
						<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'auth.login.inc.social', 'auth.login.inc.social'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						
						<?php
							$mtAuth = !socialLoginIsEnabled() ? ' mt-5' : ' mt-4';
						?>
						<div class="row<?php echo e($mtAuth); ?>">
							<div class="col-12">
								<form id="signupForm" class="form-horizontal" method="POST" action="<?php echo e(url()->current()); ?>">
									<?php echo csrf_field(); ?>

									<?php echo view('honeypot::honeypot'); ?>
									<fieldset>
										
										
										<?php $nameError = (isset($errors) && $errors->has('name')) ? ' is-invalid' : ''; ?>
										<div class="row mb-3 required">
											<label class="col-md-3 col-form-label"><?php echo e(t('Name')); ?> <sup>*</sup></label>
											<div class="col-md-9 col-lg-6">
												<input name="name"
												       placeholder="<?php echo e(t('Name')); ?>"
												       class="form-control input-md<?php echo e($nameError); ?>"
												       type="text"
												       value="<?php echo e(old('name')); ?>"
												>
											</div>
										</div>

										
										<?php if(empty(config('country.code'))): ?>
											<?php
												$countryCodeError = (isset($errors) && $errors->has('country_code')) ? ' is-invalid' : '';
												$countryCodeValue = (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0;
											?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label<?php echo e($countryCodeError); ?>" for="country_code">
													<?php echo e(t('your_country')); ?> <sup>*</sup>
												</label>
												<div class="col-md-9 col-lg-6">
													<select id="countryCode"
													        name="country_code"
													        class="form-control large-data-selecter<?php echo e($countryCodeError); ?>"
													>
														<option value="0" <?php if(empty(old('country_code'))): echo 'selected'; endif; ?>>
															<?php echo e(t('Select')); ?>

														</option>
														<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($code); ?>" <?php if(old('country_code', $countryCodeValue) == $code): echo 'selected'; endif; ?>>
																<?php echo e($item->get('name')); ?>

															</option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
												</div>
											</div>
										<?php else: ?>
											<input id="countryCode" name="country_code" type="hidden" value="<?php echo e(config('country.code')); ?>">
										<?php endif; ?>
										
										
										<?php
											$authFields = getAuthFields(true);
											$authFieldError = (isset($errors) && $errors->has('auth_field')) ? ' is-invalid' : '';
											$usersCanChooseNotifyChannel = isUsersCanChooseNotifyChannel();
											$authFieldValue = ($usersCanChooseNotifyChannel) ? (old('auth_field', getAuthField())) : getAuthField();
										?>
										<?php if($usersCanChooseNotifyChannel): ?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label" for="auth_field">
													<?php echo e(t('notifications_channel')); ?> <sup>*</sup>
												</label>
												<div class="col-md-9">
													<?php $__currentLoopData = $authFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iAuthField => $notificationType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<div class="form-check form-check-inline pt-2">
															<input name="auth_field"
																   id="<?php echo e($iAuthField); ?>AuthField"
																   value="<?php echo e($iAuthField); ?>"
																   class="form-check-input auth-field-input<?php echo e($authFieldError); ?>"
																   type="radio" <?php if($authFieldValue == $iAuthField): echo 'checked'; endif; ?>
															>
															<label class="form-check-label mb-0" for="<?php echo e($iAuthField); ?>AuthField">
																<?php echo e($notificationType); ?>

															</label>
														</div>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<div class="form-text text-muted">
														<?php echo e(t('notifications_channel_hint')); ?>

													</div>
												</div>
											</div>
										<?php else: ?>
											<input id="<?php echo e($authFieldValue); ?>AuthField" name="auth_field" type="hidden" value="<?php echo e($authFieldValue); ?>">
										<?php endif; ?>
										
										<?php
											$forceToDisplay = isBothAuthFieldsCanBeDisplayed() ? ' force-to-display' : '';
										?>
										
										
										<?php
											$emailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : '';
										?>
										<div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label pt-0" for="email"><?php echo e(t('email')); ?>

												<?php if(getAuthField() == 'email'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
											<div class="col-md-9 col-lg-6">
												<div class="input-group">
													<span class="input-group-text"><i class="far fa-envelope"></i></span>
													<input id="email" name="email"
														   type="email"
														   class="form-control<?php echo e($emailError); ?>"
														   placeholder="<?php echo e(t('email_address')); ?>"
														   value="<?php echo e(old('email')); ?>"
													>
												</div>
											</div>
										</div>
										
										
										<?php
											$phoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : '';
											$phoneCountryValue = config('country.code');
										?>
										<div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
											<label class="col-md-3 col-form-label pt-0" for="phone"><?php echo e(t('phone_number')); ?>

												<?php if(getAuthField() == 'phone'): ?>
													<sup>*</sup>
												<?php endif; ?>
											</label>
											<div class="col-md-9 col-lg-6">
												<input id="phone" name="phone"
													   class="form-control input-md<?php echo e($phoneError); ?>"
													   type="tel"
													   value="<?php echo e(phoneE164(old('phone'), old('phone_country', $phoneCountryValue))); ?>"
													   autocomplete="off"
												>
												<input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
											</div>
										</div>
										
										
										<?php
											$usernameIsEnabled = !config('larapen.core.disable.username');
										?>
										<?php if($usernameIsEnabled): ?>
											<?php $usernameError = (isset($errors) && $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label" for="username"><?php echo e(t('Username')); ?></label>
												<div class="col-md-9 col-lg-6">
													<div class="input-group">
														<span class="input-group-text"><i class="far fa-user"></i></span>
														<input id="username"
															   name="username"
															   type="text"
															   class="form-control<?php echo e($usernameError); ?>"
															   placeholder="<?php echo e(t('Username')); ?>"
															   value="<?php echo e(old('username')); ?>"
														>
													</div>
												</div>
											</div>
										<?php endif; ?>
										
										
										<?php $passwordError = (isset($errors) && $errors->has('password')) ? ' is-invalid' : ''; ?>
										<div class="row mb-3 required">
											<label class="col-md-3 col-form-label" for="password"><?php echo e(t('password')); ?> <sup>*</sup></label>
											<div class="col-md-9 col-lg-6">
												<div class="input-group show-pwd-group mb-2">
													<input id="password" name="password"
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
												<input id="passwordConfirmation" name="password_confirmation"
													   type="password"
													   class="form-control<?php echo e($passwordError); ?>"
													   placeholder="<?php echo e(t('Password Confirmation')); ?>"
													   autocomplete="off"
												>
												<div class="form-text text-muted">
													<?php echo e(t('at_least_num_characters', ['num' => config('settings.security.password_min_length', 6)])); ?>

												</div>
											</div>
										</div>
										
										<?php echo $__env->make('layouts.inc.tools.captcha', ['colLeft' => 'col-md-3', 'colRight' => 'col-md-6'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										
										
										<?php $acceptTermsError = (isset($errors) && $errors->has('accept_terms')) ? ' is-invalid' : ''; ?>
										<div class="row mb-1 required">
											<label class="col-md-3 col-form-label"></label>
											<div class="col-md-9">
												<div class="form-check">
													<input name="accept_terms" id="acceptTerms"
														   class="form-check-input<?php echo e($acceptTermsError); ?>"
														   value="1"
														   type="checkbox" <?php if(old('accept_terms') == '1'): echo 'checked'; endif; ?>
													>
													<label class="form-check-label" for="acceptTerms" style="font-weight: normal;">
														<?php echo t('accept_terms_label', ['attributes' => getUrlPageByType('terms')]); ?>

													</label>
												</div>
												<div style="clear:both"></div>
											</div>
										</div>
										
										
										<?php $acceptMarketingOffersError = (isset($errors) && $errors->has('accept_marketing_offers')) ? ' is-invalid' : ''; ?>
										<div class="row mb-3 required">
											<label class="col-md-3 col-form-label"></label>
											<div class="col-md-9">
												<div class="form-check">
													<input name="accept_marketing_offers" id="acceptMarketingOffers"
														   class="form-check-input<?php echo e($acceptMarketingOffersError); ?>"
														   value="1"
														   type="checkbox" <?php if(old('accept_marketing_offers') == '1'): echo 'checked'; endif; ?>
													>
													<label class="form-check-label" for="acceptMarketingOffers" style="font-weight: normal;">
														<?php echo t('accept_marketing_offers_label'); ?>

													</label>
												</div>
												<div style="clear:both"></div>
											</div>
										</div>

										
										<div class="row mb-3">
											<label class="col-md-3 col-form-label"></label>
											<div class="col-md-7">
												<button id="signupBtn" class="btn btn-primary btn-lg"> <?php echo e(t('register')); ?> </button>
											</div>
										</div>

										<div class="mb-4"></div>

									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box">
							<i class="far fa-image fa-4x icon-color-1"></i>
							<h3><strong><?php echo e(t('create_new_listing')); ?></strong></h3>
							<p>
								<?php echo e(t('do_you_have_something_text', ['appName' => config('app.name')])); ?>

							</p>
						</div>
						<div class="promo-text-box">
							<i class="fas fa-pen-square fa-4x icon-color-2"></i>
							<h3><strong><?php echo e(t('create_and_manage_items')); ?></strong></h3>
							<p><?php echo e(t('become_a_best_seller_or_buyer_text')); ?></p>
						</div>
						<div class="promo-text-box"><i class="fas fa-heart fa-4x icon-color-3"></i>
							<h3><strong><?php echo e(t('create_your_favorite_listings_list')); ?></strong></h3>
							<p><?php echo e(t('create_your_favorite_listings_list_text')); ?></p>
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
			
			$(document).on('click', '#signupBtn', function(e) {
				e.preventDefault();
				$("#signupForm").submit();
				
				return false;
			});
		});
		
		    const box = document.querySelector("[for='emailAuthField']");
            box.innerHTML = 'Email';
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/auth/register/index.blade.php ENDPATH**/ ?>