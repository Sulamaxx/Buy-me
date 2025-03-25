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
    $displayStatesSearchTip = config('settings.list.display_states_search_tip');
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
                
                <button class="navbar-toggler -toggler float-end d-none"
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
				 
				 <li class="nav-item postadd float-end d-md-none align-items-center" style="min-width: fit-content;padding-block: auto">
					<a id="btnPostAdlink1" class="btn btn-block btn-border btn-listing border-null align-items-center" style="background-image:linear-gradient(to bottom, #FE9000 0, #FE9000 100%);padding:0%;padding-block: auto;width:40vw;display: flex;align-items: center;justify-content: center;" href="<?php echo e($addListingUrl); ?>"<?php echo $addListingAttr; ?>>
						<?php echo e(t('Create Listing')); ?>

					</a>
				</li>
                
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

            <div class="container search-container d-none d-md-block" style="width: 30.75vw;margin-left:5vw">
                <form id="search" name="search" action="<?php echo e(\App\Helpers\UrlGen::searchWithoutQuery()); ?>" method="GET">
                    <div class="row search-row animated fadeInUp border-null" >

                        <div class="col-lg-6 col-md-5 col-sm-12 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
                            <div class="search-col-inner">
                                <div class="search-col-input" style="margin-left: 0px;width: 100%;">
                                    <input class="form-control" name="q" placeholder="<?php echo e(t('what')); ?>" type="text" value="" style="border-radius:0% !important;">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="lSearch" name="l" value="">

                        <div class="col-lg-4 col-md-5 col-sm-12 search-col relative locationicon mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0 d-none d-md-block d-lg-block d-xl-block">
                            <div class="search-col-inner">
                                <div class="search-col-input" style="margin-left: 0px; width: 100%;">
                                    <?php if($displayStatesSearchTip): ?>
                                        <input class="form-control locinput input-rel searchtag-input"
                                               id="locSearch"
                                               name="location"
                                               placeholder="<?php echo e(t('where')); ?>"
                                               type="text"
                                               value=""
                                               data-bs-placement="top"
                                               data-bs-toggle="tooltipHover"
                                               title="<?php echo e(t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name')); ?>"
                                        >
                                    <?php else: ?>
                                        <input class="form-control locinput input-rel searchtag-input"
                                               id="locSearch"
                                               name="location"
                                               placeholder="<?php echo e(t('where')); ?>"
                                               type="text"
                                               value=""
                                        >
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 search-col" style="border-left: 1px solid black;">
							<div class="search-btn-border bg-primary">
								<button class="btn btn-primary btn-search btn-block" style="width: 100%;border-radius: 0px !important;background-color: #e5e5e5 !important;padding:0px">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" style="width: 1.5em; height: 1.5em;">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
									</svg>
								</button>
							</div>
						</div>

                    </div>
                </form>
            </div>

            <div class="navbar-collapse collapse" id="navbarsDefault">
                <ul class="nav navbar-nav me-md-auto navbar-left d-md-none d-sm-block d-block" style="margin-inline: 0px !important">
                    <div class="btn-group btn-group-xs" style="padding: 0px;">
                        <button type="button" id="btn-en-lang-mobile" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/en')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important; padding: 0px;padding-inline: 2px;margin-right: 10px;">English</button>
                        <button type="button" id="btn-si-lang-mobile" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/si_LK')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important;border-left: 1px solid #ccc !important; border-right: 1px solid #ccc !important;padding: 0px;padding-inline: 2px;margin-right: 2.5px;">සිංහල</button>
                        <button type="button" id="btn-ta-lang-mobile" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/ta_LK')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important;padding: 0px;padding-inline: 2px;">தமிழ்</button>

                    </div>
                    
                    <?php if($showCountryFlagNextLogo): ?>
                        <?php if(!empty($countryFlag32Url)): ?>
                            <li class="flag-menu country-flag d-md-none d-sm-block d-block nav-item"
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

                <ul class="nav navbar-nav ms-auto navbar-right" style="margin-inline: 0px !important">
                    
                    <li>
                        <a href="<?php echo e(\App\Helpers\UrlGen::sitemap()); ?>" class="nav-link"><i class=""></i> <?php echo e(t('all_categories')); ?></a>
                    </li>
                    

					<li class="nav-item d-none d-md-block" style="margin-inline: 0px !important; margin-left: 10px;margin-block:auto;">
                        <div class="btn-group btn-group-xs" style="padding: 0px;">
                            <button type="button" id="btn-en-lang-desktop" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/en')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important; padding: 0px;padding-inline: 2px;margin-right: 10px;">English</button>
                            <button type="button" id="btn-si-lang-desktop" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/si_LK')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important;border-left: 1px solid #ccc !important; border-right: 1px solid #ccc !important;padding: 0px;padding-inline: 2px;margin-right: 2.5px;">සිංහල</button>
                            <button type="button" id="btn-ta-lang-desktop" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/ta_LK')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important;padding: 0px;padding-inline: 2px;margin-right: 5px;">தமிழ்</button>
                        </div>
                    </li>

                    
                    <?php if($showCountryFlagNextLogo): ?>
                        <?php if(!empty($countryFlag32Url)): ?>
                            <li class="flag-menu country-flag d-none d-md-block nav-item"
                                data-bs-toggle="tooltip"
                                data-bs-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>" <?php echo $multiCountryLabel; ?>

                                style="margin-left: 5px;"
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
                    <li class="nav-item postadd" style="min-width: fit-content">
                        <a id="btnPostAdlink1" class="btn btn-block btn-border btn-listing border-null" href="<?php echo e($addListingUrl); ?>"<?php echo $addListingAttr; ?>>
                            <?php echo e(t('Create Listing')); ?>

                        </a>
                    </li>

                </ul>
            </div>


        </div>
    </nav>
</div>
<script>
    function navigateTo(url) {
        window.location.href = url;
    }
</script><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/layouts/inc/header.blade.php ENDPATH**/ ?>