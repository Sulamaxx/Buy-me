<?php
	$countries ??= collect();
	
	// Search parameters
	$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');
	
	$showCountryFlagNextLogo = (config('settings.localization.show_country_flag') == 'in_next_logo');
	
	// Check if the Multi-Countries selection is enabled
	$multiCountryIsEnabled = false;
	$multiCountryLabel = '';
	if ($showCountryFlagNextLogo) {
		if (!empty(config('country.code'))) {
			if ($countries->count() > 1) {
				$multiCountryIsEnabled = true;
				$multiCountryLabel = 'title="' . t('select_country') . '"';
			}
		}
	}
	
	// Country
	$countryName = config('country.name');
	$countryFlag24Url = config('country.flag24_url');
	$countryFlag32Url = config('country.flag32_url');
	
	// Logo Label
	$logoLabel = '';
	if ($multiCountryIsEnabled) {
		$logoLabel = config('settings.app.name') . (!empty($countryName) ? ' ' . $countryName : '');
	}
	
	// User Menu
	$userMenu ??= collect();
?>
<div class="header">
	<nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
		<div class="container">
			
			<div class="navbar-identity p-sm-0">
				
				<a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
					<img src="<?php echo e(config('settings.app.logo_url')); ?>"
				 
						 alt="<?php echo e(strtolower(config('settings.app.name'))); ?>"
						 class="main-logo"
						 data-bs-placement="bottom"
						 data-bs-toggle="tooltip"
						 title="<?php echo $logoLabel; ?>"
					/>
				</a>
				
				<button class="navbar-toggler -toggler float-end"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#navbarsDefault"
						aria-controls="navbarsDefault"
						aria-expanded="false"
						aria-label="Toggle navigation"
				>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false">
						<title><?php echo e(t('Menu')); ?></title>
						<path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
					</svg>
				</button>
				
				<?php if($showCountryFlagNextLogo): ?>
					<?php if($multiCountryIsEnabled): ?>
						<?php if(!empty($countryFlag24Url)): ?>
							<button class="flag-menu country-flag d-md-none d-sm-block d-none btn btn-default float-end"
							        href="#selectCountry"
							        data-bs-toggle="modal"
							>
								<img src="<?php echo e($countryFlag24Url); ?>" alt="<?php echo e($countryName); ?>" style="float: left;">
								<span class="caret d-none"></span>
							</button>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			
			<div class="navbar-collapse collapse" id="navbarsDefault">
				<ul class="nav navbar-nav me-md-auto navbar-left">
				    	 <!-- Language Bar #001 -->
				    	 <div class="btn-group btn-group-xs">
                            <button type="button" id="btn-en-lang" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/en')">A</button>
                            <button type="button" id="btn-si-lang" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/si_LK')">අ</button>
                            <button type="button" id="btn-ta-lang" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/ta_LK')">அ</button>
                    
                        </div>
                           <script>
                            function navigateTo(url) {
                                window.location.href = url;
                            }
                        </script>
					
					<?php if($showCountryFlagNextLogo): ?>
						<?php if(!empty($countryFlag32Url)): ?>
							<li class="flag-menu country-flag d-md-block d-sm-none d-none nav-item"
							    data-bs-toggle="tooltip"
							    data-bs-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>" <?php echo $multiCountryLabel; ?>

							>
								<?php if($multiCountryIsEnabled): ?>
									<a class="nav-link p-0" data-bs-toggle="modal" data-bs-target="#selectCountry">
										<img class="flag-icon mt-1" src="<?php echo e($countryFlag32Url); ?>" alt="<?php echo e($countryName); ?>">
										<span class="caret d-lg-block d-md-none d-sm-none d-none float-end mt-3 mx-1"></span>
									</a>
								<?php else: ?>
									<a class="p-0" style="cursor: default;">
										<img class="flag-icon" src="<?php echo e($countryFlag32Url); ?>" alt="<?php echo e($countryName); ?>">
									</a>
								<?php endif; ?>
							</li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>
				
				<ul class="nav navbar-nav ms-auto navbar-right">
				    <!-- Home Menus #001 -->
				    <li>
				        <a href="<?php echo e(url('/')); ?>" class="nav-link"><i class=""></i> <?php echo e(t('home')); ?></a>
				    </li>
				    <li>
				        <a href="<?php echo e(\App\Helpers\UrlGen::sitemap()); ?>" class="nav-link"><i class=""></i> <?php echo e(t('all_categories')); ?></a>
				    </li>
					<?php if(config('settings.list.display_browse_listings_link')): ?>
						<li class="nav-item d-lg-block d-md-none d-sm-block d-block">
							<?php
								$currDisplay = config('settings.list.display_mode');
								$browseListingsIconClass = 'fas fa-th-large';
								if ($currDisplay == 'make-list') {
									$browseListingsIconClass = 'fas fa-th-list';
								}
								if ($currDisplay == 'make-compact') {
									$browseListingsIconClass = 'fas fa-bars';
								}
							?>
							<a href="<?php echo e(\App\Helpers\UrlGen::searchWithoutQuery()); ?>" class="nav-link">
								<i class="<?php echo e($browseListingsIconClass); ?>"></i> <?php echo e(t('Browse Listings')); ?>

							</a>
						</li>
					<?php endif; ?>
					<?php if(!auth()->check()): ?>
						<li class="nav-item dropdown no-arrow open-on-hover d-md-block d-sm-none d-none">
							<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
								<i class="fas fa-user"></i>
								<span><?php echo e(t('log_in')); ?></span>
								<i class="bi bi-chevron-down"></i>
							</a>
							<ul id="authDropdownMenu" class="dropdown-menu user-menu shadow-sm">
								<li class="dropdown-item">
									<?php if(config('settings.security.login_open_in_modal')): ?>
										<a href="#quickLogin" class="nav-link" data-bs-toggle="modal"><i class="fas fa-user"></i> <?php echo e(t('log_in')); ?></a>
									<?php else: ?>
										<a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>" class="nav-link"><i class="fas fa-user"></i> <?php echo e(t('log_in')); ?></a>
									<?php endif; ?>
								</li>
								<li class="dropdown-item">
									<a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>" class="nav-link"><i class="far fa-user"></i> <?php echo e(t('sign_up')); ?></a>
								</li>
							</ul>
						</li>
						<li class="nav-item d-md-none d-sm-block d-block">
							<?php if(config('settings.security.login_open_in_modal')): ?>
								<a href="#quickLogin" class="nav-link" data-bs-toggle="modal"><i class="fas fa-user"></i> <?php echo e(t('log_in')); ?></a>
							<?php else: ?>
								<a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>" class="nav-link"><i class="fas fa-user"></i> <?php echo e(t('log_in')); ?></a>
							<?php endif; ?>
						</li>
						<li class="nav-item d-md-none d-sm-block d-block">
							<a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>" class="nav-link"><i class="far fa-user"></i> <?php echo e(t('sign_up')); ?></a>
						</li>
					<?php else: ?>
						<li class="nav-item dropdown no-arrow open-on-hover">
							<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
								<i class="fas fa-user-circle"></i>
								<span><?php echo e(auth()->user()->name); ?></span>
								<span class="badge badge-pill badge-important count-threads-with-new-messages d-lg-inline-block d-md-none">0</span>
								<i class="bi bi-chevron-down"></i>
							</a>
							<ul id="userMenuDropdown" class="dropdown-menu user-menu shadow-sm">
								<?php if($userMenu->count() > 0): ?>
									<?php
										$menuGroup = '';
										$dividerNeeded = false;
									?>
									<?php $__currentLoopData = $userMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if(!$value['inDropdown']) continue; ?>
										<?php
											if ($menuGroup != $value['group']) {
												$menuGroup = $value['group'];
												if (!empty($menuGroup) && !$loop->first) {
													$dividerNeeded = true;
												}
											} else {
												$dividerNeeded = false;
											}
										?>
										<?php if($dividerNeeded): ?>
											<li class="dropdown-divider"></li>
										<?php endif; ?>
										<li class="dropdown-item<?php echo e((isset($value['isActive']) && $value['isActive']) ? ' active' : ''); ?>">
											<a href="<?php echo e($value['url']); ?>">
												<i class="<?php echo e($value['icon']); ?>"></i> <?php echo e($value['name']); ?>

												<?php if(!empty($value['countVar']) && !empty($value['countCustomClass'])): ?>
													<span class="badge badge-pill badge-important<?php echo e($value['countCustomClass']); ?>">0</span>
												<?php endif; ?>
											</a>
										</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>
					
					<?php if(config('plugins.currencyexchange.installed')): ?>
						<?php echo $__env->make('currencyexchange::select-currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php endif; ?>
					
					<?php if(config('settings.single.pricing_page_enabled') == '2'): ?>
						<li class="nav-item pricing">
							<a href="<?php echo e(\App\Helpers\UrlGen::pricing()); ?>" class="nav-link">
								<i class="fas fa-tags"></i> <?php echo e(t('pricing_label')); ?>

							</a>
						</li>
					<?php endif; ?>
					
					<?php
						$addListingUrl = \App\Helpers\UrlGen::addPost();
						$addListingAttr = '';
						if (!auth()->check()) {
							if (config('settings.single.guest_can_submit_listings') != '1') {
								$addListingUrl = '#quickLogin';
								$addListingAttr = ' data-bs-toggle="modal"';
							}
						}
						if (config('settings.single.pricing_page_enabled') == '1') {
							$addListingUrl = \App\Helpers\UrlGen::pricing();
							$addListingAttr = '';
						}
					?>
					<li class="nav-item postadd">
						<a id="btnPostAdlink1" class="btn btn-block btn-border btn-listing" href="<?php echo e($addListingUrl); ?>"<?php echo $addListingAttr; ?>>
							<i class="far fa-edit"></i> <?php echo e(t('Create Listing')); ?>

						</a>
					</li>
					
					<!-- Lang bar drop #001 -->
				 	<!-- 
				 	<?php echo $__env->first([
						config('larapen.core.customizedViewPath') . 'layouts.inc.menu.select-language',
						'layouts.inc.menu.select-language'
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> -->
				
				</ul>
			</div>
		
		
		</div>
	</nav>
</div>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/header.blade.php ENDPATH**/ ?>