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
		$rowColsLg = $socialAndAppsLinksAreEnabled ? 'row-cols-lg-4' : 'row-cols-lg-3';
		$rowColsMd = 'row-cols-md-3';
		
		$ptFooterContent = '';
		$mbCopy = ' mb-3';
		if (config('settings.footer.hide_links')) {
			$ptFooterContent = ' pt-sm-5 pt-5';
			$mbCopy = ' mb-4';
		}
	?>
	<div class="footer-content<?php echo e($ptFooterContent); ?>">
		<div class="container d-none d-sm-block d-md-block d-lg-block">
			<div class="row">

			      <div class="col text-center">
					<a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
						<img src="<?php echo e(config('settings.app.logo_url')); ?>"
							alt="<?php echo e(strtolower(config('settings.app.name'))); ?>"
							class="main-logo footer-main-logo"
							data-bs-placement="bottom"
							data-bs-toggle="tooltip"
						/>
					</a>
				  </div>
				
				<?php if(!config('settings.footer.hide_links')): ?>
				
				
				<?php if(isset($pages) && $pages->count() > 0): ?>
					<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$linkTarget = '';
						if ($page->target_blank == 1) {
							$linkTarget = 'target="_blank"';
						}
					?>
							<div class="col">
								<div class="footer-col">
									<h4 class="footer-title">
										<?php if(!empty($page->external_link)): ?>
											<a href="<?php echo $page->external_link; ?>" rel="nofollow" <?php echo $linkTarget; ?> style="color: #000;"> <?php echo e($page->name); ?> </a>
										<?php else: ?>
											<a href="<?php echo e(\App\Helpers\UrlGen::page($page)); ?>" <?php echo $linkTarget; ?> style="color: #000;"> <?php echo e($page->name); ?> </a>
										<?php endif; ?>
									</h4>
									<!-- <ul class="list-unstyled footer-nav">
										<?php if(isset($pages) && $pages->count() > 0): ?>
											<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<li>
													
													<?php if(!empty($page->external_link)): ?>
														<a href="<?php echo $page->external_link; ?>" rel="nofollow" <?php echo $linkTarget; ?>> <?php echo e($page->name); ?> </a>
													<?php else: ?>
														<a href="<?php echo e(\App\Helpers\UrlGen::page($page)); ?>" <?php echo $linkTarget; ?>> <?php echo e($page->name); ?> </a>
													<?php endif; ?>
												</li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</ul> -->
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">Vehicle</h4> -->
							<!-- <ul class="list-unstyled footer-nav">
								<li><a href="<?php echo e(\App\Helpers\UrlGen::contact()); ?>"> <?php echo e(t('Contact')); ?> </a></li>
								<li><a href="<?php echo e(\App\Helpers\UrlGen::sitemap()); ?>"> <?php echo e(t('sitemap')); ?> </a></li>
								<?php if(isset($countries) && $countries->count() > 1): ?>
									<li><a href="<?php echo e(\App\Helpers\UrlGen::countries()); ?>"> <?php echo e(t('countries')); ?> </a></li>
								<?php endif; ?>
							</ul> -->
						<!-- </div>
					</div> -->

					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">Property</h4>
						</div>
					</div> -->

					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">Vendors</h4>
						</div>
					</div> -->
					
					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">About Us</h4> -->
							<!-- <ul class="list-unstyled footer-nav">
								<?php if(!auth()->user()): ?>
									<li>
										<?php if(config('settings.security.login_open_in_modal')): ?>
											<a href="#quickLogin" data-bs-toggle="modal"> <?php echo e(t('log_in')); ?> </a>
										<?php else: ?>
											<a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>"> <?php echo e(t('log_in')); ?> </a>
										<?php endif; ?>
									</li>
									<li><a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>"> <?php echo e(t('register')); ?> </a></li>
								<?php else: ?>
									<li><a href="<?php echo e(url('account')); ?>"> <?php echo e(t('My Account')); ?> </a></li>
									<li><a href="<?php echo e(url('account/posts/list')); ?>"> <?php echo e(t('my_listings')); ?> </a></li>
									<li><a href="<?php echo e(url('account/posts/favourite')); ?>"> <?php echo e(t('favourite_listings')); ?> </a></li>
								<?php endif; ?>
							</ul> -->
						<!-- </div>
					</div> -->

					<div class="col">
						<div class="footer-col">
							<h4 class="footer-title"><a href="<?php echo e(\App\Helpers\UrlGen::contact()); ?>" style="color: #000;"> <?php echo e(t('Contact')); ?> </a></h4>
						</div>
					</div>
					
					<?php if($socialAndAppsLinksAreEnabled): ?>
						<div class="col">
							<div class="footer-col row" style="padding: 17px 0px;">
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
											<!-- <h4 class="footer-title <?php echo $footerSocialTitleClass; ?>"><?php echo e(t('Follow us on')); ?></h4> -->
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
			
  <div class="hotline-center-container">
    <img src="/public/images/hotline.webp" alt="Hotline Image">
  </div>
  
  					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  					<!-- whatsapp  -->
					<a href="https://web.whatsapp.com/send/?phone=94765903535&text&type=phone_number&app_absent=1" class="wafloat"  target="_blank" rel="noopener noreferrer">
                    <i class="fa fa-whatsapp wa-float"></i>
                    </a>
			
			<div class="row">
				<?php
					$mtPay = '';
					$mtCopy = ' mt-md-4 mt-3 pt-2';
				?>
				<div class="col-12">
					<?php if(!config('settings.footer.hide_payment_plugins_logos') && isset($paymentMethods) && $paymentMethods->count() > 0): ?>
						<?php
							if (config('settings.footer.hide_links')) {
								$mtPay = ' mt-0';
							}
						?>
						<div class="text-center payment-method-logo<?php echo e($mtPay); ?>">
							
							<?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if(file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png'))): ?>
									<img src="<?php echo e(url('plugins/' . $paymentMethod->name . '/images/payment.png')); ?>"
									     alt="<?php echo e($paymentMethod->display_name); ?>"
									     title="<?php echo e($paymentMethod->display_name); ?>"
									>
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					<?php else: ?>
						<?php
							$mtCopy = ' mt-0';
						?>
						<?php if(!config('settings.footer.hide_links')): ?>
							<?php
								$mtCopy = ' mt-md-4 mt-3 pt-2';
							?>
							<hr class="bg-secondary border-0">
						<?php endif; ?>
					<?php endif; ?>
					
					<div class="copy-info text-center mb-md-0<?php echo e($mbCopy); ?><?php echo e($mtCopy); ?>">
						© <?php echo e(date('Y')); ?> <?php echo e(config('settings.app.name')); ?>. <?php echo e(t('all_rights_reserved')); ?>.
						<?php if(!config('settings.footer.hide_powered_by')): ?>
							<?php if(config('settings.footer.powered_by_info')): ?>
								<?php echo e(t('Powered by')); ?> <?php echo config('settings.footer.powered_by_info'); ?>

							<?php else: ?>
								<?php echo e(t('Powered by')); ?> 
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

        <!-- mobile view -->
		<div class="container d-block d-sm-none">
			<div class="">

			      <div class="col col-sm-12 text-center">
					<a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
						<img src="<?php echo e(config('settings.app.logo_url')); ?>"
							alt="<?php echo e(strtolower(config('settings.app.name'))); ?>"
							class="main-logo footer-main-logo"
							data-bs-placement="bottom"
							data-bs-toggle="tooltip"
						/>
					</a>
				  </div>
				
				<?php if(!config('settings.footer.hide_links')): ?>
				
				
				<?php if(isset($pages) && $pages->count() > 0): ?>
					<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$linkTarget = '';
						if ($page->target_blank == 1) {
							$linkTarget = 'target="_blank"';
						}
					?>
							<div class="col col-sm-12">
								<div class="footer-col">
									<h4 class="footer-title">
										<?php if(!empty($page->external_link)): ?>
											<a href="<?php echo $page->external_link; ?>" rel="nofollow" <?php echo $linkTarget; ?> style="color: #000;"> <?php echo e($page->name); ?> </a>
										<?php else: ?>
											<a href="<?php echo e(\App\Helpers\UrlGen::page($page)); ?>" <?php echo $linkTarget; ?> style="color: #000;"> <?php echo e($page->name); ?> </a>
										<?php endif; ?>
									</h4>
									<!-- <ul class="list-unstyled footer-nav">
										<?php if(isset($pages) && $pages->count() > 0): ?>
											<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<li>
													
													<?php if(!empty($page->external_link)): ?>
														<a href="<?php echo $page->external_link; ?>" rel="nofollow" <?php echo $linkTarget; ?>> <?php echo e($page->name); ?> </a>
													<?php else: ?>
														<a href="<?php echo e(\App\Helpers\UrlGen::page($page)); ?>" <?php echo $linkTarget; ?>> <?php echo e($page->name); ?> </a>
													<?php endif; ?>
												</li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</ul> -->
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">Vehicle</h4> -->
							<!-- <ul class="list-unstyled footer-nav">
								<li><a href="<?php echo e(\App\Helpers\UrlGen::contact()); ?>"> <?php echo e(t('Contact')); ?> </a></li>
								<li><a href="<?php echo e(\App\Helpers\UrlGen::sitemap()); ?>"> <?php echo e(t('sitemap')); ?> </a></li>
								<?php if(isset($countries) && $countries->count() > 1): ?>
									<li><a href="<?php echo e(\App\Helpers\UrlGen::countries()); ?>"> <?php echo e(t('countries')); ?> </a></li>
								<?php endif; ?>
							</ul> -->
						<!-- </div>
					</div> -->

					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">Property</h4>
						</div>
					</div> -->

					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">Vendors</h4>
						</div>
					</div> -->
					
					<!-- <div class="col">
						<div class="footer-col">
							<h4 class="footer-title">About Us</h4> -->
							<!-- <ul class="list-unstyled footer-nav">
								<?php if(!auth()->user()): ?>
									<li>
										<?php if(config('settings.security.login_open_in_modal')): ?>
											<a href="#quickLogin" data-bs-toggle="modal"> <?php echo e(t('log_in')); ?> </a>
										<?php else: ?>
											<a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>"> <?php echo e(t('log_in')); ?> </a>
										<?php endif; ?>
									</li>
									<li><a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>"> <?php echo e(t('register')); ?> </a></li>
								<?php else: ?>
									<li><a href="<?php echo e(url('account')); ?>"> <?php echo e(t('My Account')); ?> </a></li>
									<li><a href="<?php echo e(url('account/posts/list')); ?>"> <?php echo e(t('my_listings')); ?> </a></li>
									<li><a href="<?php echo e(url('account/posts/favourite')); ?>"> <?php echo e(t('favourite_listings')); ?> </a></li>
								<?php endif; ?>
							</ul> -->
						<!-- </div>
					</div> -->

					<div class="col col-sm-12 ">
						<div class="footer-col">
							<h4 class="footer-title"><a href="<?php echo e(\App\Helpers\UrlGen::contact()); ?>" style="color: #000;"> <?php echo e(t('Contact')); ?> </a></h4>
						</div>
					</div>
					
					<?php if($socialAndAppsLinksAreEnabled): ?>
						<div class="col col-sm-12 ">
							<div class="footer-col row" style="padding: 17px 0px;">
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
											<!-- <h4 class="footer-title <?php echo $footerSocialTitleClass; ?>"><?php echo e(t('Follow us on')); ?></h4> -->
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
			
			  <div class="hotline-center-container">
    <img src="/public/images/hotline.webp" alt="Hotline Image">
  </div>
  
  					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  					 
					<a href="https://wa.me/94765903535" class="wafloat"  target="_blank" rel="noopener noreferrer">
                    <i class="fa fa-whatsapp wa-float"></i>
                    </a>
			
			<div class="row">
				<?php
					$mtPay = '';
					$mtCopy = ' mt-md-4 mt-3 pt-2';
				?>
				<div class="col-12">
					<?php if(!config('settings.footer.hide_payment_plugins_logos') && isset($paymentMethods) && $paymentMethods->count() > 0): ?>
						<?php
							if (config('settings.footer.hide_links')) {
								$mtPay = ' mt-0';
							}
						?>
						<div class="text-center payment-method-logo<?php echo e($mtPay); ?>">
							
							<?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if(file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png'))): ?>
									<img src="<?php echo e(url('plugins/' . $paymentMethod->name . '/images/payment.png')); ?>"
									     alt="<?php echo e($paymentMethod->display_name); ?>"
									     title="<?php echo e($paymentMethod->display_name); ?>"
									>
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					<?php else: ?>
						<?php
							$mtCopy = ' mt-0';
						?>
						<?php if(!config('settings.footer.hide_links')): ?>
							<?php
								$mtCopy = ' mt-md-4 mt-3 pt-2';
							?>
							<hr class="bg-secondary border-0">
						<?php endif; ?>
					<?php endif; ?>
					
					<div class="copy-info text-center mb-md-0<?php echo e($mbCopy); ?><?php echo e($mtCopy); ?>">
						© <?php echo e(date('Y')); ?> <?php echo e(config('settings.app.name')); ?>. <?php echo e(t('all_rights_reserved')); ?>.
						<?php if(!config('settings.footer.hide_powered_by')): ?>
							<?php if(config('settings.footer.powered_by_info')): ?>
								<?php echo e(t('Powered by')); ?> <?php echo config('settings.footer.powered_by_info'); ?>

							<?php else: ?>
								<?php echo e(t('Powered by')); ?>

							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/layouts/inc/footer.blade.php ENDPATH**/ ?>