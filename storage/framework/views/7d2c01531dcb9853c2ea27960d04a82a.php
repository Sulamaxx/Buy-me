<?php
	// Search parameters
	$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');
	
	$showCountryFlagNextLogo = (config('settings.localization.show_country_flag') == 'in_next_logo');
	
	// Check if the Multi-Countries selection is enabled
	$multiCountryIsEnabled = false;
	$multiCountryLabel = '';
	
	// Country
	$countryName = config('country.name');
	$countryFlag24Url = config('country.flag24_url');
	$countryFlag32Url = config('country.flag32_url');
	
	// Logo Label
	$logoLabel = '';
	if (request()->segment(1) != 'countries') {
		if ($multiCountryIsEnabled) {
			$logoLabel = config('settings.app.name') . (!empty($countryName) ? ' ' . $countryName : '');
		}
	}
?>
<div class="header">
	<nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
		<div class="container">
			
			<div class="navbar-identity p-sm-0">
				
				<a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
					<img src="<?php echo e(config('settings.app.logo_url')); ?>" class="main-logo" style="height: 40px;" alt="<?php echo e($countryName); ?>"/>
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
				
				<?php if(request()->segment(1) != 'countries'): ?>
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
				<?php endif; ?>
			</div>
			
			<div class="navbar-collapse collapse" id="navbarsDefault">
				<ul class="nav navbar-nav me-md-auto navbar-left">
					
					<?php if(request()->segment(1) != 'countries'): ?>
						<?php if($showCountryFlagNextLogo): ?>
							<?php if(!empty($countryFlag32Url)): ?>
								<li class="flag-menu country-flag d-md-block d-sm-none d-none nav-item"
								    data-bs-toggle="tooltip"
								    data-bs-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>"
								>
									<?php if($multiCountryIsEnabled): ?>
										<a class="nav-link p-0" data-bs-toggle="modal" data-bs-target="#selectCountry">
											<img class="flag-icon" src="<?php echo e($countryFlag32Url); ?>" alt="<?php echo e($countryName); ?>">
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
					<?php endif; ?>
				</ul>
				
				<ul class="nav navbar-nav ms-auto navbar-right">
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
					
					<li class="nav-item dropdown no-arrow open-on-hover d-md-block d-sm-none d-none">
						<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<i class="fas fa-user"></i>
							<span><?php echo e(t('log_in')); ?></span>
							<i class="fas fa-chevron-down"></i>
						</a>
						<ul id="authDropdownMenu" class="dropdown-menu user-menu shadow-sm">
							<li class="dropdown-item">
								<a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>" class="nav-link"><i class="fas fa-user"></i> <?php echo e(t('log_in')); ?></a>
							</li>
							<li class="dropdown-item">
								<a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>" class="nav-link"><i class="far fa-user"></i> <?php echo e(t('sign_up')); ?></a>
							</li>
						</ul>
					</li>
					<li class="nav-item d-md-none d-sm-block d-block">
						<a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>" class="nav-link"><i class="fas fa-user"></i> <?php echo e(t('log_in')); ?></a>
					</li>
					<li class="nav-item d-md-none d-sm-block d-block">
						<a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>" class="nav-link"><i class="far fa-user"></i> <?php echo e(t('sign_up')); ?></a>
					</li>
					
					<?php if(config('settings.single.pricing_page_enabled') == '2'): ?>
						<li class="nav-item pricing">
							<a href="<?php echo e(\App\Helpers\UrlGen::pricing()); ?>" class="nav-link">
								<i class="fas fa-tags"></i> <?php echo e(t('pricing_label')); ?>

							</a>
						</li>
					<?php endif; ?>
					
					<li class="nav-item postadd">
						<?php if(config('settings.single.guest_can_submit_listings') != '1'): ?>
							<a class="btn btn-block btn-border btn-post btn-listing" href="#quickLogin" data-bs-toggle="modal">
								<i class="far fa-edit"></i> <?php echo e(t('Create Listing')); ?>

							</a>
						<?php else: ?>
							<a class="btn btn-block btn-border btn-post btn-listing" href="<?php echo e(\App\Helpers\UrlGen::addPost(true)); ?>">
								<i class="far fa-edit"></i> <?php echo e(t('Create Listing')); ?>

							</a>
						<?php endif; ?>
					</li>
					
					<?php if(!empty(config('lang.code'))): ?>
						<?php echo $__env->first([
							config('larapen.core.customizedViewPath') . 'layouts.inc.menu.select-language',
							'layouts.inc.menu.select-language'
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
</div>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/errors/layouts/inc/header.blade.php ENDPATH**/ ?>