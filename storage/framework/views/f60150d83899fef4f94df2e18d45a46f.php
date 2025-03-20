<?php
$socialLinksAreEnabled = (
	config('settings.social_link.facebook_page_url')
	|| config('settings.social_link.twitter_url')
	|| config('settings.social_link.tiktok_url')
	|| config('settings.social_link.linkedin_url')
	|| config('settings.social_link.pinterest_url')
	|| config('settings.social_link.instagram_url')
);
$appsLinksAreEnabled = (
	config('settings.other.ios_app_url')
	|| config('settings.other.android_app_url')
);
$socialAndAppsLinksAreEnabled = ($socialLinksAreEnabled || $appsLinksAreEnabled);
?>
<footer class="main-footer">
	<?php
	$rowColsLg = $socialAndAppsLinksAreEnabled ? 'row-cols-lg-3' : 'row-cols-lg-2';
	$rowColsMd = $rowColsLg;
	
	$ptFooterContent = '';
	$mbCopy = ' mb-3';
	if (config('settings.footer.hide_links')) {
		$ptFooterContent = ' pt-sm-5 pt-5';
		$mbCopy = ' mb-4';
	}
	?>
	<div class="footer-content<?php echo e($ptFooterContent); ?>">
		<div class="container">
			<div class="row <?php echo e($rowColsLg); ?> <?php echo e($rowColsMd); ?> row-cols-sm-2 row-cols-2 g-3">
				
				<?php if(!config('settings.footer.hide_links')): ?>
					<div class="col">
						<div class="footer-col">
							<h4 class="footer-title"><?php echo e(t('Contact and Sitemap')); ?></h4>
							<ul class="list-unstyled footer-nav">
								<li><a href="<?php echo e(\App\Helpers\UrlGen::contact()); ?>"> <?php echo e(t('Contact')); ?> </a></li>
								<?php if(!empty(config('lang.code')) && !empty(config('country.icode'))): ?>
									<li><a href="<?php echo e(\App\Helpers\UrlGen::sitemap()); ?>"> <?php echo e(t('sitemap')); ?> </a></li>
								<?php endif; ?>
								<li><a href="<?php echo e(\App\Helpers\UrlGen::countries()); ?>"> <?php echo e(t('countries')); ?> </a></li>
							</ul>
						</div>
					</div>
					
					<div class="col">
						<div class="footer-col">
							<h4 class="footer-title"><?php echo e(t('My Account')); ?></h4>
							<ul class="list-unstyled footer-nav">
								<?php if(!auth()->user()): ?>
									<li><a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>"> <?php echo e(t('log_in')); ?> </a></li>
									<li><a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>"> <?php echo e(t('register')); ?> </a></li>
								<?php else: ?>
									<li><a href="<?php echo e(url('account')); ?>"> <?php echo e(t('My Account')); ?> </a></li>
									<li><a href="<?php echo e(url('account/posts/list')); ?>"> <?php echo e(t('my_listings')); ?> </a></li>
									<li><a href="<?php echo e(url('account/posts/favourite')); ?>"> <?php echo e(t('favourite_listings')); ?> </a></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
					
					<?php if($socialAndAppsLinksAreEnabled): ?>
						<div class="col">
							<div class="footer-col row">
								<?php
								$footerSocialClass = '';
								$footerSocialTitleClass = '';
								?>
								<?php if($appsLinksAreEnabled): ?>
									<div class="col-sm-12 col-12 p-lg-0">
										<div class="mobile-app-content">
											<h4 class="footer-title"><?php echo e(t('Mobile Apps')); ?></h4>
											<div class="row">
												<?php if(config('settings.other.ios_app_url')): ?>
													<div class="col-12 col-sm-6">
														<a class="app-icon" target="_blank" href="<?php echo e(config('settings.other.ios_app_url')); ?>">
															<span class="hide-visually"><?php echo e(t('iOS app')); ?></span>
															<img src="<?php echo e(url('images/site/app-store-badge.svg')); ?>" alt="<?php echo e(t('Available on the App Store')); ?>">
														</a>
													</div>
												<?php endif; ?>
												<?php if(config('settings.other.android_app_url')): ?>
													<div class="col-12 col-sm-6">
														<a class="app-icon" target="_blank" href="<?php echo e(config('settings.other.android_app_url')); ?>">
															<span class="hide-visually"><?php echo e(t('Android App')); ?></span>
															<img src="<?php echo e(url('images/site/google-play-badge.svg')); ?>" alt="<?php echo e(t('Available on Google Play')); ?>">
														</a>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php
									$footerSocialClass = 'hero-subscribe';
									$footerSocialTitleClass = 'm-0';
									?>
								<?php endif; ?>
								
								<?php if($socialLinksAreEnabled): ?>
									<div class="col-sm-12 col-12 p-lg-0">
										<div class="<?php echo $footerSocialClass; ?>">
											<h4 class="footer-title <?php echo $footerSocialTitleClass; ?>"><?php echo e(t('Follow us on')); ?></h4>
											<ul class="list-unstyled list-inline mx-0 footer-nav social-list-footer social-list-color footer-nav-inline">
												<?php if(config('settings.social_link.facebook_page_url')): ?>
													<li>
														<a class="icon-color fb"
														   data-bs-placement="top"
														   data-bs-toggle="tooltip"
														   href="<?php echo e(config('settings.social_link.facebook_page_url')); ?>"
														   title="Facebook"
														>
															<i class="fab fa-facebook"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.twitter_url')): ?>
													<li>
														<a class="icon-color tw"
														   data-bs-placement="top"
														   data-bs-toggle="tooltip"
														   href="<?php echo e(config('settings.social_link.twitter_url')); ?>"
														   title="Twitter"
														>
															<i class="fab fa-twitter"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.instagram_url')): ?>
													<li>
														<a class="icon-color pin"
														   data-bs-placement="top"
														   data-bs-toggle="tooltip"
														   href="<?php echo e(config('settings.social_link.instagram_url')); ?>"
														   title="Instagram"
														>
															<i class="fab fa-instagram"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.linkedin_url')): ?>
													<li>
														<a class="icon-color lin"
														   data-bs-placement="top"
														   data-bs-toggle="tooltip"
														   href="<?php echo e(config('settings.social_link.linkedin_url')); ?>"
														   title="LinkedIn"
														>
															<i class="fab fa-linkedin"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.pinterest_url')): ?>
													<li>
														<a class="icon-color pin"
														   data-bs-placement="top"
														   data-bs-toggle="tooltip"
														   href="<?php echo e(config('settings.social_link.pinterest_url')); ?>"
														   title="Pinterest"
														>
															<i class="fab fa-pinterest-p"></i>
														</a>
													</li>
												<?php endif; ?>
												<?php if(config('settings.social_link.tiktok_url')): ?>
													<li>
														<a class="icon-color tt"
														   data-bs-placement="top"
														   data-bs-toggle="tooltip"
														   href="<?php echo e(config('settings.social_link.tiktok_url')); ?>"
														   title="Tiktok"
														>
															<i class="fab fa-tiktok"></i>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					
					<div style="clear: both"></div>
				<?php endif; ?>
			
			</div>
			<div class="row">
				
				<?php
					$mtPay = '';
					$mtCopy = ' mt-md-4 mt-3 pt-2';
				?>
				<div class="col-12">
					<?php if(!config('settings.footer.hide_payment_plugins_logos') && isset($paymentMethods) && $paymentMethods->count() > 0): ?>
						<?php if(config('settings.footer.hide_links')): ?>
							<?php $mtPay = ' mt-0'; ?>
						<?php endif; ?>
						<div class="text-center payment-method-logo<?php echo e($mtPay); ?>">
							
							<?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if(file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png'))): ?>
									<img src="<?php echo e(url('images/' . $paymentMethod->name . '/payment.png')); ?>" alt="<?php echo e($paymentMethod->display_name); ?>" title="<?php echo e($paymentMethod->display_name); ?>">
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					<?php else: ?>
						<?php $mtCopy = ' mt-0'; ?>
						<?php if(!config('settings.footer.hide_links')): ?>
							<?php $mtCopy = ' mt-md-4 mt-3 pt-2'; ?>
							<hr class="border-0 bg-secondary">
						<?php endif; ?>
					<?php endif; ?>
					
					<div class="copy-info text-center mb-md-0<?php echo e($mbCopy); ?><?php echo e($mtCopy); ?>">
						© <?php echo e(date('Y')); ?> <?php echo e(config('settings.app.name')); ?>. <?php echo e(t('all_rights_reserved')); ?>.
						<?php if(!config('settings.footer.hide_powered_by')): ?>
							<?php if(config('settings.footer.powered_by_info')): ?>
								<?php echo e(t('Powered by')); ?> <?php echo config('settings.footer.powered_by_info'); ?>

							<?php else: ?>
								<?php echo e(t('Powered by')); ?> <a href="https://laraclassifier.com" title="LaraClassifier">LaraClassifier</a>.
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</footer>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/errors/layouts/inc/footer.blade.php ENDPATH**/ ?>