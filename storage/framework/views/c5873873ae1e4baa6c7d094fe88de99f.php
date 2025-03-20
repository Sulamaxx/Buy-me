


<?php
	$authUserIsAdmin ??= false;
	$stats ??= [];
	$countThreads = data_get($stats, 'threads.all') ?? 0;
	$postsVisits = data_get($stats, 'posts.visits') ?? 0;
	$countPosts = (data_get($stats, 'posts.published') ?? 0)
		+ (data_get($stats, 'posts.archived') ?? 0)
		+ (data_get($stats, 'posts.pendingApproval') ?? 0);
	$countFavoritePosts = data_get($stats, 'posts.favourite') ?? 0;
	
	$fiTheme = config('larapen.core.fileinput.theme', 'bs5');
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-3 page-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>

				<div class="col-md-9 page-content">

					<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<?php if(isset($errors) && $errors->any()): ?>
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
							<h5><strong><?php echo e(t('oops_an_error_has_occurred')); ?></strong></h5>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo $error; ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					<?php endif; ?>
					
					<div id="avatarUploadError" class="center-block" style="width:100%; display:none"></div>
					<div id="avatarUploadSuccess" class="alert alert-success fade show" style="display:none;"></div>
					
					<div class="inner-box default-inner-box">
						<div class="row">
							<div class="col-md-5 col-sm-4 col-12">
								<h3 class="no-padding text-center-480 useradmin">
									<a href="">
										<img id="userImg" class="userImg" src="<?php echo e($authUser->photo_url); ?>" alt="user">&nbsp;
										<?php echo e($authUser->name); ?>

									</a>
								</h3>
							</div>
							<div class="col-md-7 col-sm-8 col-12">
								<div class="header-data text-center-xs">
									
									<div class="hdata">
										<div class="mcol-left">
											<i class="fas fa-envelope ln-shadow"></i>
										</div>
										<div class="mcol-right">
											
											<p>
												<a href="<?php echo e(url('account/messages')); ?>">
													<?php echo e(\App\Helpers\Number::short($countThreads ?? 0)); ?>

													<em><?php echo e(trans_choice('global.count_mails', getPlural($countThreads ?? 0), [], config('app.locale'))); ?></em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
									
									
									<div class="hdata">
										<div class="mcol-left">
											<i class="fa fa-eye ln-shadow"></i>
										</div>
										<div class="mcol-right">
											
											<p>
												<a href="<?php echo e(url('account/posts/list')); ?>">
													<?php echo e(\App\Helpers\Number::short($postsVisits ?? 0)); ?>

													<em><?php echo e(trans_choice('global.count_visits', getPlural($postsVisits ?? 0), [], config('app.locale'))); ?></em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>

									
									<div class="hdata">
										<div class="mcol-left">
											<i class="fas fa-bullhorn ln-shadow"></i>
										</div>
										<div class="mcol-right">
											
											<p>
												<a href="<?php echo e(url('account/posts/list')); ?>">
													<?php echo e(\App\Helpers\Number::short($countPosts ?? 0)); ?>

													<em><?php echo e(trans_choice('global.count_listings', getPlural($countPosts ?? 0), [], config('app.locale'))); ?></em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>

									
									<div class="hdata">
										<div class="mcol-left">
											<i class="fa fa-user ln-shadow"></i>
										</div>
										<div class="mcol-right">
											
											<p>
												<a href="<?php echo e(url('account/posts/favourite')); ?>">
													<?php echo e(\App\Helpers\Number::short($countFavoritePosts ?? 0)); ?>

													<em>
														<?php echo e(trans_choice(
																'global.count_favorites',
																getPlural($countFavoritePosts ?? 0),
																[],
																config('app.locale')
														)); ?>

													</em>
												</a>
											</p>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="inner-box default-inner-box" style="overflow: visible;">
						<div class="welcome-msg">
							<h3 class="page-sub-header2 clearfix no-padding"><?php echo e(t('Hello')); ?> <?php echo e($authUser->name); ?> ! </h3>
							<span class="page-sub-header-sub small">
                                <?php echo e(t('You last logged in at')); ?>: <?php echo e(\App\Helpers\Date::format($authUser->last_login_at, 'datetime')); ?>

                            </span>
						</div>
						
						<div id="accordion" class="panel-group">
						    <!-- disbaled avatar #000
							
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title">
										<a href="#photoPanel" data-bs-toggle="collapse" data-parent="#accordion"><?php echo e(t('Photo or Avatar')); ?></a>
									</h4>
								</div>
								<?php
									$photoPanelClass = '';
									$photoPanelClass = request()->filled('panel')
										? (request()->query('panel') == 'photo' ? 'show' : $photoPanelClass)
										: ((old('panel')=='' || old('panel') =='photo') ? 'show' : $photoPanelClass);
								?>
								<div class="panel-collapse collapse <?php echo e($photoPanelClass); ?>" id="photoPanel">
									<div class="card-body">
										<form name="photoUpdate" class="form-horizontal" role="form" method="POST" action="<?php echo e(url('account/photo')); ?>">
											<div class="row">
												<div class="col-xl-12 text-center">
													
													<?php
														$photoError = (isset($errors) && $errors->has('photo')) ? ' is-invalid' : '';
													?>
													<div class="photo-field">
														<div class="file-loading">
															<input id="photoField" name="photo" type="file" class="file <?php echo e($photoError); ?>">
														</div>
													</div>
												
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							-->
							
							
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title">
										<a href="#userPanel" aria-expanded="true" data-bs-toggle="collapse" data-parent="#accordion">
											<?php echo e(t('Account Details')); ?>

										</a>
									</h4>
								</div>
								<?php
									$userPanelClass = '';
									$userPanelClass = request()->filled('panel')
										? (request()->query('panel') == 'user' ? 'show' : $userPanelClass)
										: ((old('panel') == '' || old('panel') == 'user') ? 'show' : $userPanelClass);
								?>
								<div class="panel-collapse collapse <?php echo e($userPanelClass); ?>" id="userPanel">
									<div class="card-body">
										<form name="details"
											  class="form-horizontal"
											  role="form"
											  method="POST"
											  action="<?php echo e(url('account')); ?>"
											  enctype="multipart/form-data"
										>
											<?php echo csrf_field(); ?>

											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="user">

											
											<?php $genderIdError = (isset($errors) && $errors->has('gender_id')) ? ' is-invalid' : ''; ?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label" for="gender_id"><?php echo e(t('gender')); ?></label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<select name="gender_id" id="genderId" class="form-control selecter<?php echo e($genderIdError); ?>">
														<option value="0" <?php if(empty(old('gender_id'))): echo 'selected'; endif; ?>>
															<?php echo e(t('Select')); ?>

														</option>
														<?php if($genders->count() > 0): ?>
															<?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<option value="<?php echo e($gender->id); ?>"
																		<?php if(old('gender_id', $authUser->gender_id) == $gender->id): echo 'selected'; endif; ?>
																>
																	<?php echo e($gender->name); ?>

																</option>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<?php endif; ?>
													</select>
												</div>
											</div>
											
											
											<?php $nameError = (isset($errors) && $errors->has('name')) ? ' is-invalid' : ''; ?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label<?php echo e($nameError); ?>" for="name"><?php echo e(t('Name')); ?> <sup>*</sup></label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<input name="name"
													       type="text"
													       class="form-control<?php echo e($nameError); ?>"
													       placeholder=""
													       value="<?php echo e(old('name', $authUser->name)); ?>"
													>
												</div>
											</div>
											
											
											<?php $usernameError = (isset($errors) && $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label<?php echo e($usernameError); ?>" for="username"><?php echo e(t('Username')); ?></label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<div class="input-group">
														<span class="input-group-text"><i class="far fa-user"></i></span>
														<input id="username" name="username"
															   type="text"
															   class="form-control<?php echo e($usernameError); ?>"
															   placeholder="<?php echo e(t('Username')); ?>"
															   value="<?php echo e(old('username', $authUser->username)); ?>"
														>
													</div>
												</div>
											</div>
											
										
											
											<?php
												$forceToDisplay = isBothAuthFieldsCanBeDisplayed() ? ' force-to-display' : '';
											?>
											
											
											<?php
												$emailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : '';
											?>
											<div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
												<label class="col-md-3 col-form-label<?php echo e($emailError); ?>" for="email"><?php echo e(t('email')); ?>

													<?php if(getAuthField() == 'email'): ?>
														<sup>*</sup>
													<?php endif; ?>
												</label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<div class="input-group">
														<span class="input-group-text"><i class="far fa-envelope"></i></span>
														<input id="email" name="email"
															   type="email"
															   readonly
															   class="form-control<?php echo e($emailError); ?>"
															   placeholder="<?php echo e(t('email_address')); ?>"
															   value="<?php echo e(old('email', $authUser->email)); ?>"
														>
													</div>
												</div>
											</div>
											
											
											<?php
												$phoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : '';
												$phoneValue = $authUser->phone ?? null;
												$phoneCountryValue = $authUser->phone_country ?? config('country.code');
												$phoneValue = phoneE164($phoneValue, $phoneCountryValue);
												$phoneValueOld = phoneE164(old('phone', $phoneValue), old('phone_country', $phoneCountryValue));
											?>
											<div class="row mb-3 auth-field-item required<?php echo e($forceToDisplay); ?>">
												<label class="col-md-3 col-form-label<?php echo e($phoneError); ?>" for="phone"><?php echo e(t('phone')); ?>

													<?php if(getAuthField() == 'phone'): ?>
														<sup>*</sup>
													<?php endif; ?>
												</label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<div class="input-group">
														<input id="phone" name="phone"
															   type="tel"
															   class="form-control<?php echo e($phoneError); ?>"
															   value="<?php echo e($phoneValueOld); ?>"
														>
														<span class="input-group-text iti-group-text">
															<input name="phone_hidden" id="phoneHidden" type="checkbox"
																   value="1" <?php if(old('phone_hidden', $authUser->phone_hidden) == '1'): echo 'checked'; endif; ?>>&nbsp;
															<small><?php echo e(t('Hide')); ?></small>
														</span>
													</div>
													<input name="phone_country" type="hidden" value="<?php echo e(old('phone_country', $phoneCountryValue)); ?>">
												</div>
											</div>
											
											
											<input name="country_code" type="hidden" value="<?php echo e($authUser->country_code); ?>">

											<div class="row mb-3">
												<div class="offset-md-3 col-md-9"></div>
											</div>
											
												
											<?php
												$authFields = getAuthFields(true);
												$authFieldError = (isset($errors) && $errors->has('auth_field')) ? ' is-invalid' : '';
												$usersCanChooseNotifyChannel = isUsersCanChooseNotifyChannel(true);
												$authFieldValue = $authUser->auth_field ?? getAuthField();
												$authFieldValue = ($usersCanChooseNotifyChannel) ? old('auth_field', $authFieldValue) : $authFieldValue;
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
											
											
											<div class="row">
												<div class="offset-md-3 col-md-9">
													<button type="submit" class="btn btn-primary"><?php echo e(t('Update')); ?></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							
							
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title"><a href="#settingsPanel" data-bs-toggle="collapse" data-parent="#accordion"><?php echo e(t('Settings')); ?></a></h4>
								</div>
								<?php
									$settingsPanelClass = '';
									$settingsPanelClass = request()->filled('panel')
										? (request()->query('panel') == 'settings' ? 'show' : $settingsPanelClass)
										: ((old('panel') == 'settings') ? 'show' : $settingsPanelClass);
								?>
								<div class="panel-collapse collapse <?php echo e($settingsPanelClass); ?>" id="settingsPanel">
									<div class="card-body">
										<form name="settings"
											  class="form-horizontal"
											  role="form"
											  method="POST"
											  action="<?php echo e(url('account/settings')); ?>"
											  enctype="multipart/form-data"
										>
											<?php echo csrf_field(); ?>

											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="settings">
											
											<input name="gender_id" type="hidden" value="<?php echo e($authUser->gender_id); ?>">
											<input name="name" type="hidden" value="<?php echo e($authUser->name); ?>">
											<input name="phone" type="hidden" value="<?php echo e($authUser->phone); ?>">
											<input name="phone_country" type="hidden" value="<?php echo e($authUser->phone_country); ?>">
											<input name="email" type="hidden" value="<?php echo e($authUser->email); ?>">
										
											<?php if(config('settings.single.activation_facebook_comments') && config('services.facebook.client_id')): ?>
												
												<div class="row mb-3">
													<label class="col-md-3 col-form-label"></label>
													<div class="col-md-9">
														<div class="form-check pt-2">
															<input id="disableComments" name="disable_comments"
																   class="form-check-input"
																   value="1"
																   type="checkbox" <?php if($authUser->disable_comments == 1): echo 'checked'; endif; ?>
															>
															<label class="form-check-label" for="disable_comments" style="font-weight: normal;">
																<?php echo e(t('Disable comments on my listings')); ?>

															</label>
														</div>
													</div>
												</div>
											<?php endif; ?>
											
											
											<?php $passwordError = (isset($errors) && $errors->has('password')) ? ' is-invalid' : ''; ?>
											<div class="row mb-2">
												<label class="col-md-3 col-form-label<?php echo e($passwordError); ?>"><?php echo e(t('New Password')); ?></label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<input id="password" name="password"
														   type="password"
														   class="form-control<?php echo e($passwordError); ?>"
														   placeholder="<?php echo e(t('password')); ?>"
														   autocomplete="new-password"
													>
												</div>
											</div>
											
											
											<?php $passwordError = (isset($errors) && $errors->has('password')) ? ' is-invalid' : ''; ?>
											<div class="row mb-3">
												<label class="col-md-3 col-form-label<?php echo e($passwordError); ?>"><?php echo e(t('Confirm Password')); ?></label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<input id="password_confirmation" name="password_confirmation"
														   type="password"
														   class="form-control<?php echo e($passwordError); ?>"
														   placeholder="<?php echo e(t('Confirm Password')); ?>"
													>
												</div>
											</div>
											
											<?php if($authUser->accept_terms != 1): ?>
												
												<?php $acceptTermsError = (isset($errors) && $errors->has('accept_terms')) ? ' is-invalid' : ''; ?>
												<div class="row mb-1 required">
													<label class="col-md-3 col-form-label"></label>
													<div class="col-md-9">
														<div class="form-check">
															<input name="accept_terms" id="acceptTerms"
																   class="form-check-input<?php echo e($acceptTermsError); ?>"
																   value="1"
																   type="checkbox" <?php if(old('accept_terms', $authUser->accept_terms) == '1'): echo 'checked'; endif; ?>
															>
															<label class="form-check-label" for="acceptTerms" style="font-weight: normal;">
																<?php echo t('accept_terms_label', ['attributes' => getUrlPageByType('terms')]); ?>

															</label>
														</div>
														<div style="clear:both"></div>
													</div>
												</div>
												
												<input type="hidden" name="user_accept_terms" value="<?php echo e((int)$authUser->accept_terms); ?>">
											<?php endif; ?>
											
											
											<?php $acceptMarketingOffersError = (isset($errors) && $errors->has('accept_marketing_offers')) ? ' is-invalid' : ''; ?>
											<div class="row mb-3 required">
												<label class="col-md-3 col-form-label"></label>
												<div class="col-md-9">
													<div class="form-check">
														<input name="accept_marketing_offers" id="acceptMarketingOffers"
															   class="form-check-input<?php echo e($acceptMarketingOffersError); ?>"
															   value="1"
															   type="checkbox" <?php if(old('accept_marketing_offers', $authUser->accept_marketing_offers) == '1'): echo 'checked'; endif; ?>
														>
														<label class="form-check-label" for="acceptMarketingOffers" style="font-weight: normal;">
															<?php echo t('accept_marketing_offers_label'); ?>

														</label>
													</div>
													<div style="clear:both"></div>
												</div>
											</div>
											
											
											<?php $timeZoneError = (isset($errors) && $errors->has('time_zone')) ? ' is-invalid' : ''; ?>
											<div class="row mb-4 required">
												<label class="col-md-3 col-form-label<?php echo e($timeZoneError); ?>" for="time_zone">
													<?php echo e(t('preferred_time_zone_label')); ?>

												</label>
												<div class="col-md-9 col-lg-8 col-xl-6">
													<select name="time_zone" class="form-control large-data-selecter<?php echo e($timeZoneError); ?>">
														<option value="" <?php if(empty(old('time_zone'))): echo 'selected'; endif; ?>>
															<?php echo e(t('select_a_time_zone')); ?>

														</option>
														<?php
															$tz = !empty($authUser->time_zone) ? $authUser->time_zone : '';
														?>
														<?php $__currentLoopData = \App\Helpers\Date::getTimeZones(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($key); ?>" <?php if(old('time_zone', $tz) == $key): echo 'selected'; endif; ?>>
																<?php echo e($item); ?>

															</option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
													<div class="form-text text-muted">
														<?php if($authUserIsAdmin): ?>
														<?php echo t('admin_preferred_time_zone_info', [
																'frontTz' => config('country.time_zone'),
																'country' => config('country.name'),
																'adminTz' => config('app.timezone'),
															]); ?>

														<?php else: ?>
															<?php echo t('preferred_time_zone_info', [
																'frontTz' => config('country.time_zone'),
																'country' => config('country.name'),
															]); ?>

														<?php endif; ?>
													</div>
												</div>
											</div>
											
											
											<div class="row">
												<div class="offset-md-3 col-md-9">
													<button type="submit" class="btn btn-primary"><?php echo e(t('Update')); ?></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
	<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<?php if(str_starts_with($fiTheme, 'explorer')): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.file-loading:before {
			content: " <?php echo e(t('loading_wd')); ?>";
		}
	</style>
	<style>
		/* Avatar Upload */
		.photo-field {
			display: inline-block;
			vertical-align: middle;
		}
		.photo-field .krajee-default.file-preview-frame,
		.photo-field .krajee-default.file-preview-frame:hover {
			margin: 0;
			padding: 0;
			border: none;
			box-shadow: none;
			text-align: center;
		}
		.photo-field .file-input {
			display: table-cell;
			width: 150px;
		}
		.photo-field .krajee-default.file-preview-frame .kv-file-content {
			width: 150px;
			height: 160px;
		}
		.kv-reqd {
			color: red;
			font-family: monospace;
			font-weight: normal;
		}
		
		.file-preview {
			padding: 2px;
		}
		.file-drop-zone {
			margin: 2px;
			min-height: 100px;
		}
		.file-drop-zone .file-preview-thumbnails {
			cursor: pointer;
		}
		
		.krajee-default.file-preview-frame .file-thumbnail-footer {
			height: 30px;
		}
		
		/* Allow clickable uploaded photos (Not possible) */
		.file-drop-zone {
			padding: 20px;
		}
		.file-drop-zone .kv-file-content {
			padding: 0
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/' . $fiTheme . '/theme.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('common/js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>
	<script>
		phoneCountry = '<?php echo e(old('phone_country', ($phoneCountryValue ?? ''))); ?>';
		
		let defaultAvatarUrl = '<?php echo e(imgUrl(config('larapen.core.avatar.default'))); ?>';
		let defaultAvatarAlt = '<?php echo e(t('Your Photo or Avatar')); ?>';
		let uploadHint = '<h6 class="text-muted pb-0"><?php echo e(t('Click to select')); ?></h6>';
		
		let options = {};
		options.theme = '<?php echo e($fiTheme); ?>';
		options.language = '<?php echo e(config('app.locale')); ?>';
		options.rtl = <?php echo e((config('lang.direction') == 'rtl') ? 'true' : 'false'); ?>;
		options.overwriteInitial = true;
		options.showCaption = false;
		options.showPreview = true;
		options.allowedFileExtensions = <?php echo getUploadFileTypes('image', true); ?>;
		options.uploadUrl = '<?php echo e(url('account/photo')); ?>';
		options.uploadExtraData = {
			_token:'<?php echo e(csrf_token()); ?>',
			_method:'PUT'
		};
		options.showClose = false;
		options.showBrowse = true;
		options.browseClass = 'btn btn-primary';
		options.minFileSize = <?php echo e((int)config('settings.upload.min_image_size', 0)); ?>;
		options.maxFileSize = <?php echo e((int)config('settings.upload.max_image_size', 1000)); ?>;
		options.uploadAsync = false;
		options.browseOnZoneClick = true;
		options.minFileCount = 0;
		options.maxFileCount = 1;
		options.validateInitialCount = true;
		options.defaultPreviewContent = '<img src="' + defaultAvatarUrl + '" alt="' + defaultAvatarAlt + '">' + uploadHint;
		options.initialPreview = [];
		options.initialPreviewAsData = true;
		options.initialPreviewFileType = 'image';
		options.initialPreviewConfig = [];
		options.fileActionSettings = {
			showDrag: false,
			showRemove: true,
			removeClass: 'btn btn-outline-danger btn-sm',
			showZoom: true,
			zoomClass: 'btn btn-outline-secondary btn-sm'
		};
		options.elErrorContainer = '#avatarUploadError';
		options.msgErrorClass = 'alert alert-block alert-danger';
		options.layoutTemplates = {
			main2: '{preview}\n<div class="kv-upload-progress hide"></div>\n{browse}',
			footer: '<div class="file-thumbnail-footer pt-2">\n{actions}\n</div>',
			actions: '<div class="file-actions">\n'
				+ '<div class="file-footer-buttons">\n{delete} {zoom}</div>\n'
				+ '<div class="clearfix"></div>\n'
				+ '</div>'
		};
		
		<?php if(!empty($authUser->photo) && !empty($authUser->photo_url)): ?>
			<?php
				try {
					$fileSize = (isset($disk) && $disk->exists($authUser->photo)) ? (int)$disk->size($authUser->photo) : 0;
				} catch (\Throwable $e) {
					$fileSize = 0;
				}
			?>
			options.initialPreview[0] = '<?php echo e($authUser->photo_url); ?>';
			options.initialPreviewConfig[0] = {};
			options.initialPreviewConfig[0].key = <?php echo e((int)$authUser->id); ?>;
			options.initialPreviewConfig[0].caption = '<?php echo e(basename($authUser->photo)); ?>';
			options.initialPreviewConfig[0].size = <?php echo e($fileSize); ?>;
			options.initialPreviewConfig[0].url = '<?php echo e(url('account/photo/delete')); ?>';
			options.initialPreviewConfig[0].extra = options.uploadExtraData;
		<?php endif; ?>
		
		
		let photoFieldEl = $('#photoField');
		photoFieldEl.fileinput(options);
		
		/* Auto-upload added file */
		photoFieldEl.on('filebatchselected', function(event, files) {
			$(this).fileinput('upload');
		});
		
		/* Show the upload status message */
		photoFieldEl.on('filebatchpreupload', function(event, data) {
			$('#avatarUploadSuccess').html('<ul></ul>').hide();
		});
		
		/* Show the success upload message */
		photoFieldEl.on('filebatchuploadsuccess', function(event, data) {
			/* Show uploads success messages */
			let out = '';
			$.each(data.files, function(key, file) {
				if (typeof file !== 'undefined') {
					let fname = file.name;
					out = out + <?php echo t('fileinput_file_uploaded_successfully'); ?>;
				}
			});
			let avatarUploadSuccessEl = $('#avatarUploadSuccess');
			avatarUploadSuccessEl.find('ul').append(out);
			avatarUploadSuccessEl.fadeIn('slow');
			
			$('#userImg').attr({'src':$('.photo-field .kv-file-content .file-preview-image').attr('src')});
		});
		
		/* Delete picture */
		photoFieldEl.on('filepredelete', function(event, key, jqXHR, data) {
			let abort = true;
			if (confirm("<?php echo e(t('Are you sure you want to delete this picture')); ?>")) {
				abort = false;
			}
			
			return abort;
		});
		
		photoFieldEl.on('filedeleted', function(event, key, jqXHR, data) {
			$('#userImg').attr({'src': defaultAvatarUrl});
			
			let out = "<?php echo e(t('Your photo or avatar has been deleted')); ?>";
			let avatarUploadSuccessEl = $('#avatarUploadSuccess');
			avatarUploadSuccessEl.html('<ul><li></li></ul>').hide();
			avatarUploadSuccessEl.find('ul li').append(out);
			avatarUploadSuccessEl.fadeIn('slow');
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/edit.blade.php ENDPATH**/ ?>