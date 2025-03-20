<?php if(socialLoginIsEnabled()): ?>
	<?php if(isset($boxedCol) && !empty($boxedCol) && is_numeric($boxedCol)): ?>
		<div class="col-12">
			<div class="row d-flex justify-content-center">
				<div class="col-<?php echo e($boxedCol); ?>"> 
					<?php endif; ?>
					
					<?php
						$sGutter = 'gx-2 gy-2';
						if (isset($socialCol) && !empty($socialCol) && is_numeric($socialCol)) {
							if ($socialCol >= 10) {
								$sGutter = 'gx-2 gy-1';
							}
							$sCol = 'col-xl-6 col-lg-6 col-md-6';
							$sCol = str_replace('-6', '-' . $socialCol, $sCol);
						} else {
							$sCol = 'col-xl-6 col-lg-6 col-md-6';
						}
						
						// Twitter API Versions Selection
						$twitterOauth2IsEnabled = (
							config('settings.social_auth.twitter_oauth_2_client_id')
							&& config('settings.social_auth.twitter_oauth_2_client_secret')
						);
						$twitterOauth1IsEnabled = (
							config('settings.social_auth.twitter_client_id')
							&& config('settings.social_auth.twitter_client_secret')
						);
						$twitterOauth1IsEnabled = !($twitterOauth2IsEnabled && $twitterOauth1IsEnabled) && $twitterOauth1IsEnabled;
					?>
					<div class="row mb-3 d-flex justify-content-center <?php echo e($sGutter); ?>">
						<?php if(config('settings.social_auth.facebook_client_id') && config('settings.social_auth.facebook_client_secret')): ?>
							<div class="<?php echo e($sCol); ?> col-sm-12 col-12">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-fb">
									<a href="<?php echo e(url('auth/facebook')); ?>" title="<?php echo strip_tags(t('Login with Facebook')); ?>">
										<i class="fab fa-facebook"></i> <?php echo t('Login with Facebook'); ?>

									</a>
								</div>
							</div>
						<?php endif; ?>
						<?php if(config('settings.social_auth.linkedin_client_id') && config('settings.social_auth.linkedin_client_secret')): ?>
							<div class="<?php echo e($sCol); ?> col-sm-12 col-12">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lkin">
									<a href="<?php echo e(url('auth/linkedin')); ?>" title="<?php echo strip_tags(t('Login with LinkedIn')); ?>">
										<i class="fab fa-linkedin"></i> <?php echo t('Login with LinkedIn'); ?>

									</a>
								</div>
							</div>
						<?php endif; ?>
						<?php if($twitterOauth2IsEnabled): ?>
							<div class="<?php echo e($sCol); ?> col-sm-12 col-12">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-tw">
									<a href="<?php echo e(url('auth/twitter-oauth-2')); ?>" title="<?php echo strip_tags(t('Login with Twitter')); ?>">
										<i class="fab fa-twitter"></i> <?php echo t('Login with Twitter'); ?>

									</a>
								</div>
							</div>
						<?php endif; ?>
						<?php if($twitterOauth1IsEnabled): ?>
							<div class="<?php echo e($sCol); ?> col-sm-12 col-12">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-tw">
									<a href="<?php echo e(url('auth/twitter')); ?>" title="<?php echo strip_tags(t('Login with Twitter')); ?>">
										<i class="fab fa-twitter"></i> <?php echo t('Login with Twitter'); ?>

									</a>
								</div>
							</div>
						<?php endif; ?>
						<?php if(config('settings.social_auth.google_client_id') && config('settings.social_auth.google_client_secret')): ?>
							<div class="<?php echo e($sCol); ?> col-sm-12 col-12">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-ggl">
									<a href="<?php echo e(url('auth/google')); ?>" title="<?php echo strip_tags(t('Login with Google')); ?>">
										<i class="fab fa-google"></i> <?php echo t('Login with Google'); ?>

									</a>
								</div>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="row d-flex justify-content-center loginOr my-4">
						<div class="col-xl-12">
							<hr class="hrOr">
							<span class="spanOr rounded"><?php echo e(t('or')); ?></span>
						</div>
					</div>
					
					<?php if(isset($boxedCol) && !empty($boxedCol) && is_numeric($boxedCol)): ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/auth/login/inc/social.blade.php ENDPATH**/ ?>