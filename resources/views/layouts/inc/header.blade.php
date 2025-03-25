@php
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
@endphp
<div class="header">
    <nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
        <div class="container">

            <div class="navbar-identity p-sm-0">
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="navbar-brand logo logo-title">
                    <img src="{{ config('settings.app.logo_url') }}"


                         alt="{{ strtolower(config('settings.app.name')) }}"
                         class="main-logo"
                         data-bs-placement="bottom"
                         data-bs-toggle="tooltip"
                         title="{!! $logoLabel !!}"
                    />
                </a>
                {{-- Toggle Nav (Mobile) --}}
                <button class="navbar-toggler -toggler float-end d-none"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarsDefault"
                        aria-controls="navbarsDefault"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false">
                        <title>{{ t('Menu') }}</title>
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
                    </svg>
                </button>
				@php
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
                    @endphp
				 {{-- Post Ad Button (Mobile) --}}
				 <li class="nav-item postadd float-end d-md-none align-items-center" style="min-width: fit-content;padding-block: auto">
					<a id="btnPostAdlink1" class="btn btn-block btn-border btn-listing border-null align-items-center" style="background-image:linear-gradient(to bottom, #FE9000 0, #FE9000 100%);padding:0%;padding-block: auto;width:40vw;display: flex;align-items: center;justify-content: center;" href="{{ $addListingUrl }}"{!! $addListingAttr !!}>
						{{ t('Create Listing') }}
					</a>
				</li>
                {{-- Country Flag (Mobile) --}}
                @if ($showCountryFlagNextLogo)
                    @if ($multiCountryIsEnabled)
                        @if (!empty($countryFlag24Url))
                            <button class="flag-menu country-flag d-md-none d-sm-block d-none btn btn-default float-end"
                                    href="#selectCountry"
                                    data-bs-toggle="modal"
                            >
                                <img src="{{ $countryFlag24Url }}" alt="{{ $countryName }}" style="float: left;">
                                <span class="caret d-none"></span>
                            </button>
                        @endif
                    @endif
                @endif
            </div>

            <div class="container search-container d-none d-md-block" style="width: 30.75vw;margin-left:5vw">
                <form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
                    <div class="row search-row animated fadeInUp border-null" >

                        <div class="col-lg-6 col-md-5 col-sm-12 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
                            <div class="search-col-inner">
                                <div class="search-col-input" style="margin-left: 0px;width: 100%;">
                                    <input class="form-control" name="q" placeholder="{{ t('what') }}" type="text" value="" style="border-radius:0% !important;">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="lSearch" name="l" value="">

                        <div class="col-lg-4 col-md-5 col-sm-12 search-col relative locationicon mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0 d-none d-md-block d-lg-block d-xl-block">
                            <div class="search-col-inner">
                                <div class="search-col-input" style="margin-left: 0px; width: 100%;">
                                    @if ($displayStatesSearchTip)
                                        <input class="form-control locinput input-rel searchtag-input"
                                               id="locSearch"
                                               name="location"
                                               placeholder="{{ t('where') }}"
                                               type="text"
                                               value=""
                                               data-bs-placement="top"
                                               data-bs-toggle="tooltipHover"
                                               title="{{ t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name') }}"
                                        >
                                    @else
                                        <input class="form-control locinput input-rel searchtag-input"
                                               id="locSearch"
                                               name="location"
                                               placeholder="{{ t('where') }}"
                                               type="text"
                                               value=""
                                        >
                                    @endif
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
                    {{-- Country Flag (Mobile) --}}
                    @if ($showCountryFlagNextLogo)
                        @if (!empty($countryFlag32Url))
                            <li class="flag-menu country-flag d-md-none d-sm-block d-block nav-item"
                                data-bs-toggle="tooltip"
                                data-bs-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountryLabel !!}
                            >
                                @if ($multiCountryIsEnabled)
                                    <a class="nav-link p-0" data-bs-toggle="modal" data-bs-target="#selectCountry">
                                        <img class="flag-icon mt-1" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}">
                                        <span class="caret d-lg-block d-md-none d-sm-none d-none float-end mt-3 mx-1"></span>
                                    </a>
                                @else
                                    <a class="p-0" style="cursor: default;">
                                        <img class="flag-icon" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}">
                                    </a>
                                @endif
                            </li>
                        @endif
                    @endif
                </ul>

                <ul class="nav navbar-nav ms-auto navbar-right" style="margin-inline: 0px !important">
                    {{-- <li>
                        <a href="{{ url('/') }}" class="nav-link"><i class=""></i> {{ t('home') }}</a>
                    </li> --}}
                    <li>
                        <a href="{{ \App\Helpers\UrlGen::sitemap() }}" class="nav-link"><i class=""></i> {{ t('all_categories') }}</a>
                    </li>
                    {{-- @if (config('settings.list.display_browse_listings_link'))
                        <li class="nav-item d-lg-block d-md-none d-sm-block d-block">
                            @php
                                $currDisplay = config('settings.list.display_mode');
                                $browseListingsIconClass = 'fas fa-th-large';
                                if ($currDisplay == 'make-list') {
                                    $browseListingsIconClass = 'fas fa-th-list';
                                }
                                if ($currDisplay == 'make-compact') {
                                    $browseListingsIconClass = 'fas fa-bars';
                                }
                            @endphp
                            <a href="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" class="nav-link">
                                <i class="{{ $browseListingsIconClass }}"></i> {{ t('Browse Listings') }}
                            </a>
                        </li>
                    @endif --}}

					<li class="nav-item d-none d-md-block" style="margin-inline: 0px !important; margin-left: 10px;margin-block:auto;">
                        <div class="btn-group btn-group-xs" style="padding: 0px;">
                            <button type="button" id="btn-en-lang-desktop" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/en')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important; padding: 0px;padding-inline: 2px;margin-right: 10px;">English</button>
                            <button type="button" id="btn-si-lang-desktop" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/si_LK')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important;border-left: 1px solid #ccc !important; border-right: 1px solid #ccc !important;padding: 0px;padding-inline: 2px;margin-right: 2.5px;">සිංහල</button>
                            <button type="button" id="btn-ta-lang-desktop" class="btn btn-primary border btn-sm-2" onclick="navigateTo('/locale/ta_LK')" style="background-color: transparent; border-color: #ccc;border-color: transparent !important;padding: 0px;padding-inline: 2px;margin-right: 5px;">தமிழ்</button>
                        </div>
                    </li>

                    {{-- Country Flag (Desktop) --}}
                    @if ($showCountryFlagNextLogo)
                        @if (!empty($countryFlag32Url))
                            <li class="flag-menu country-flag d-none d-md-block nav-item"
                                data-bs-toggle="tooltip"
                                data-bs-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountryLabel !!}
                                style="margin-left: 5px;"
                            >
                                @if ($multiCountryIsEnabled)
                                    <a class="nav-link p-0" data-bs-toggle="modal" data-bs-target="#selectCountry">
                                        <img class="flag-icon mt-1" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}">
                                        <span class="caret d-lg-block d-md-none d-sm-none d-none float-end mt-3 mx-1"></span>
                                    </a>
                                @else
                                    <a class="p-0" style="cursor: default;">
                                        <img class="flag-icon" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}">
                                    </a>
                                @endif
                            </li>
                        @endif
                    @endif

                    @if (!auth()->check())
                        <li class="nav-item dropdown no-arrow open-on-hover d-md-block d-sm-none d-none">
                            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                                <span>{{ t('log_in') }}</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <ul id="authDropdownMenu" class="dropdown-menu user-menu shadow-sm">
                                <li class="dropdown-item">
                                    @if (config('settings.security.login_open_in_modal'))
                                        <a href="#quickLogin" class="nav-link" data-bs-toggle="modal"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                                    @else
                                        <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                                    @endif
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link"><i class="far fa-user"></i> {{ t('sign_up') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-md-none d-sm-block d-block">
                            @if (config('settings.security.login_open_in_modal'))
                                <a href="#quickLogin" class="nav-link" data-bs-toggle="modal"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @else
                                <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @endif
                        </li>
                        <li class="nav-item d-md-none d-sm-block d-block">
                            <a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link"><i class="far fa-user"></i> {{ t('sign_up') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown no-arrow open-on-hover">
                            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ auth()->user()->name }}</span>
                                <span class="badge badge-pill badge-important count-threads-with-new-messages d-lg-inline-block d-md-none">0</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <ul id="userMenuDropdown" class="dropdown-menu user-menu shadow-sm">
                                @if ($userMenu->count() > 0)
                                    @php
                                        $menuGroup = '';
                                        $dividerNeeded = false;
                                    @endphp
                                    @foreach($userMenu as $key => $value)
                                        @continue(!$value['inDropdown'])
                                        @php
                                            if ($menuGroup != $value['group']) {
                                                $menuGroup = $value['group'];
                                                if (!empty($menuGroup) && !$loop->first) {
                                                    $dividerNeeded = true;
                                                }
                                            } else {
                                                $dividerNeeded = false;
                                            }
                                        @endphp
                                        @if ($dividerNeeded)
                                            <li class="dropdown-divider"></li>
                                        @endif
                                        <li class="dropdown-item{{ (isset($value['isActive']) && $value['isActive']) ? ' active' : '' }}">
                                            <a href="{{ $value['url'] }}">
                                                <i class="{{ $value['icon'] }}"></i> {{ $value['name'] }}
                                                @if (!empty($value['countVar']) && !empty($value['countCustomClass']))
                                                    <span class="badge badge-pill badge-important{{ $value['countCustomClass'] }}">0</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (config('plugins.currencyexchange.installed'))
                        @include('currencyexchange::select-currency')
                    @endif

                    @if (config('settings.single.pricing_page_enabled') == '2')
                        <li class="nav-item pricing">
                            <a href="{{ \App\Helpers\UrlGen::pricing() }}" class="nav-link">
                                <i class="fas fa-tags"></i> {{ t('pricing_label') }}
                            </a>
                        </li>
                    @endif

                    @php
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
                    @endphp
                    <li class="nav-item postadd" style="min-width: fit-content">
                        <a id="btnPostAdlink1" class="btn btn-block btn-border btn-listing border-null" href="{{ $addListingUrl }}"{!! $addListingAttr !!}>
                            {{ t('Create Listing') }}
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
</script>