@php
    $countries ??= collect();
    $userMenu ??= collect();
    $displayStatesSearchTip = config('settings.list.display_states_search_tip');

    // Search parameters
    $queryString = request()->getQueryString() ? '?' . request()->getQueryString() : '';

    $showCountryFlagNextLogo = config('settings.localization.show_country_flag') == 'in_next_logo';

    $multiCountryIsEnabled = false;
    $multiCountryLabel = '';
    if ($showCountryFlagNextLogo && !empty(config('country.code')) && $countries->count() > 1) {
        $multiCountryIsEnabled = true;
        $multiCountryLabel = 'title="' . t('select_country') . '"';
    }

    $countryName = config('country.name');
    $countryFlag24Url = config('country.flag24_url');
    $countryFlag32Url = config('country.flag32_url');

    $logoLabel = $multiCountryIsEnabled ? config('settings.app.name') . (!empty($countryName) ? ' ' . $countryName : '') : '';

    $addListingUrl = \App\Helpers\UrlGen::addPost();
    $addListingAttr = '';
    if (!auth()->check() && config('settings.single.guest_can_submit_listings') != '1') {
        $addListingUrl = '#quickLogin';
        $addListingAttr = ' data-bs-toggle="modal"';
    }
    if (config('settings.single.pricing_page_enabled') == '1') {
        $addListingUrl = \App\Helpers\UrlGen::pricing();
        $addListingAttr = '';
    }


    $cats = App\Models\Category::where('parent_id', null)->get();


    $city ??= null;
	
	$keywords = request()->query('q');
	$keywords = (is_string($keywords)) ? $keywords : null;
	$keywords = rawurldecode($keywords);

	// Location
	$qLocationId = 0;
	if (!empty($city)) {
		$qLocationId = data_get($city, 'id') ?? 0;
		$qLocation = data_get($city, 'name');
	} else {
		$qLocationId = request()->query('l');
		$qLocation = request()->query('location');
		
		$qLocationId = (is_numeric($qLocationId)) ? $qLocationId : null;
		$qLocation = (is_string($qLocation)) ? $qLocation : null;
	
	}

    $minPrice = request()->query('minPrice');

    $maxPrice = request()->query('maxPrice');

    $qCategory = request()->query('c');

    $cities = App\Models\City::all();
                   
@endphp

<div class="header">
    <nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md flex-nowrap" role="navigation" style="z-index:13000;">
        <div class="container">
            <div class="navbar-identity d-flex align-items-center justify-content-between p-sm-0">
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="navbar-brand logo logo-title">
                    <img src="{{ config('settings.app.logo_url') }}"
                         alt="{{ strtolower(config('settings.app.name')) }}"
                         class="main-logo"
                         data-bs-placement="bottom"
                         data-bs-toggle="tooltip"
                         title="{!! $logoLabel !!}"
                         loading="lazy"
                    />
                </a>

                {{-- Mobile Elements --}}
                <div class="d-md-none d-flex align-items-center" style="margin-bottom: 20px">
                    <a id="btnPostAdlink1" class="btn btn-block btn-border btn-listing border-null me-2"
                       style="background-image: linear-gradient(to bottom, #FE9000 0, #FE9000 100%); padding: 0; width: 25vw; display: flex; align-items: center; justify-content: center;"
                       href="{{ $addListingUrl }}"{!! $addListingAttr !!}>
                        {{ t('Create Listing') }}
                    </a>
                    @if ($showCountryFlagNextLogo && $multiCountryIsEnabled && !empty($countryFlag24Url))
                        <button class="flag-menu country-flag btn btn-default me-2"
                                data-bs-toggle="modal"
                                data-bs-target="#selectCountry">
                            <img src="{{ $countryFlag24Url }}" alt="{{ $countryName }}" style="float: left;" loading="lazy">
                            <span class="caret d-none"></span>
                        </button>
                    @endif
                    <button class="navbar-toggler -toggler"
                    style="color: white; margin-bottom: 2.5px;margin-top: 35px;"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarsDefault"
                    aria-controls="navbarsDefault"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
            
               
                <span class="menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false" style="color: white">
                        <title>{{ t('Menu') }}</title>
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
                    </svg>
                </span>
            
               
                <span class="close-icon">
                     
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false" style="color: white">
                      <title>{{ t('Close') }}</title> 
                      <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M7 7 L23 23 M7 23 L23 7"></path>
                    </svg>
                </span>
            
            </button>
                </div>
            </div>
      {{--   max-width: 30.75vw --}}
            <div class="container search-container d-none d-md-block margin-l-null width-search-xl" style="max-width: 30.75vw; margin-left: 1.5vw;">
                <form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
                    <div class="row search-row animated fadeInUp border-null">
                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
                            <div class="search-col-inner" style="border-radius: 7.5px 0px 0px 7.5px !important;">
                                <div class="search-col-input" style="margin-left: 0px; width: 100%;">
                                    <input class="form-control font-size-d" name="q" placeholder="{{ t('what') }}" type="text" value="{{ $keywords }}" style="border-radius: 7.5px 0px 0px 7.5px !important;">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="lSearch" name="l" value="">
                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 search-col" style="border-left: 1px solid black;">
                            <div class="search-btn-border">
        
                                <button class="btn btn-primary btn-search" style="width: 100%; border-radius: 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" style="width: 1.5em; height: 1.5em;">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 search-col" style="border-left: 1px solid black;">
                            <div class="search-btn-border">
                                <button type="button" id="toggleFilter" class="btn btn-primary btn-search" style="width: 100%; border-radius: 0px 7.5px 7.5px 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" style="width: 1.5em; height: 1.5em;">
                                        <path d="M3 6h18v2H3V6zm4 4h10v2H7v-2zm4 4h6v2h-6v-2z"/>
                                    </svg>
                                </button>
                            
                            </div>
                        </div>
                    </div>

                    {{-- Filter Panel --}}
                    <div id="filterPanel" class="filter-panel" style="display: none;">
                        <div class="filter-section">
                            <h5>Price Range</h5>
                            <input type="number" name="minPrice" placeholder="Min Price" class="form-control mb-2" value="{{$minPrice}}">
                            <input type="number" name="maxPrice" placeholder="Max Price" class="form-control" value="{{$maxPrice}}">
                        </div>
                        <div class="filter-section">
                            <h5>Categories</h5>
                            <div class="category-options">
                            @foreach ($cats as $cat)
                            <label class="category-item">
                                <input type="checkbox" name="c[]" value="{{ $cat['id'] }}"
                                    {{ in_array($cat['id'], request()->query('c', [])) ? 'checked' : '' }}>
                                {{ $cat['name'] }}
                            </label>
                            @endforeach
                            </div>
                        </div>
                        <input type="hidden" id="nearLocation" name="location" value="">
                        <div class="filter-section">
                            <h5>Location</h5>
                            <select id="locationSelect" name="l[]" multiple placeholder="Select locations...">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ in_array($city->id, (array)request()->query('l', [])) ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-section">
                            <button class="btn btn-primary btn-search submit-button" style="width: 12.5%; border-radius: 7.5px !important; background-color: #FE9000 !important; padding: 0px;color:black !important;text-shadow: none !important;border:none;height:auto;padding-block:3px;">
                                Submit
                            </button>
                            <button type="button" id="toggleFilterClose" class="btn btn-primary btn-search submit-button" style="width: 12.5%; border-radius: 7.5px !important; background-color: #FE9000 !important; padding: 0px;color:black !important;text-shadow: none !important;border:none;height:auto;padding-block:3px;">
                                Close
                            </button>
                        </div>
                        
                    </div>
                </form>
            </div>

            <div class="navbar-collapse collapse navbar-desktop" id="navbarsDefault">
                <ul class="nav navbar-nav me-md-auto navbar-left d-md-none d-sm-block d-block" style="margin-inline: 0px !important">
                    <div class="btn-group btn-group-xs" style="padding: 0px;">
                        <button type="button" id="btn-en-lang-mobile" class="btn-primary me-1" onclick="navigateTo('/locale/en')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">A</button>
                        <button type="button" id="btn-si-lang-mobile" class="btn-primary me-1" onclick="navigateTo('/locale/si_LK')" style="background-color: transparent; border-color: transparent; border-left: 1px solid #666; border-right: 1px solid #666; padding: 0 5px;">අ</button>
                        <button type="button" id="btn-ta-lang-mobile" class="btn-primary" onclick="navigateTo('/locale/ta_LK')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">அ</button>
                    </div>
                    @if ($showCountryFlagNextLogo && !empty($countryFlag32Url))
                        <li class="flag-menu country-flag d-md-none d-sm-block d-block nav-item"
                            data-bs-toggle="tooltip"
                            data-bs-placement="{{ config('lang.direction') == 'rtl' ? 'bottom' : 'right' }}" {!! $multiCountryLabel !!}
                        >
                            @if ($multiCountryIsEnabled)
                                <a class="nav-link p-0" data-bs-toggle="modal" data-bs-target="#selectCountry">
                                    <img class="flag-icon mt-1" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}" loading="lazy">
                                    <span class="caret d-lg-block d-md-none d-sm-none d-none float-end mt-3 mx-1"></span>
                                </a>
                            @else
                                <a class="p-0" style="cursor: default;">
                                    <img class="flag-icon" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}" loading="lazy">
                                </a>
                            @endif
                        </li>
                    @endif
                </ul>

                <ul class="nav navbar-nav ms-auto navbar-right" style="margin-inline: 0px !important">
                    <li><a href="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" class="nav-link" style="color: white"><i class=""></i> {{ t('Browse Listings') }}</a></li>
                    <li><a href="{{ \App\Helpers\UrlGen::sitemap() }}" class="nav-link" style="color: white"><i class=""></i> {{ t('all_categories') }}</a></li>
                    <li class="nav-item d-none d-md-block" style="margin-inline: 0px !important; margin-left: 10px; margin-block: auto;">
                        <div class="btn-group btn-group-xs" style="padding: 0px;">
                            <button type="button" id="btn-en-lang-desktop" class="btn-primary me-1" onclick="navigateTo('/locale/en')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">A</button>
                            <button type="button" id="btn-si-lang-desktop" class="btn-primary me-1" onclick="navigateTo('/locale/si_LK')" style="background-color: transparent; border-color: transparent; border-left: 1px solid #666; border-right: 1px solid #666; padding: 0 5px;">අ</button>
                            <button type="button" id="btn-ta-lang-desktop" class="btn-primary" onclick="navigateTo('/locale/ta_LK')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">அ</button>
                        </div>
                    </li>
                    @if ($showCountryFlagNextLogo && !empty($countryFlag32Url))
                        <li class="flag-menu country-flag d-none d-md-block nav-item"
                            data-bs-toggle="tooltip"
                            data-bs-placement="{{ config('lang.direction') == 'rtl' ? 'bottom' : 'right' }}" {!! $multiCountryLabel !!}
                            style="margin-left: 5px;"
                        >
                            @if ($multiCountryIsEnabled)
                                <a class="nav-link p-0" data-bs-toggle="modal" data-bs-target="#selectCountry">
                                    <img class="flag-icon mt-1" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}" loading="lazy">
                                    <span class="caret d-lg-block d-md-none d-sm-none d-none float-end mt-3 mx-1"></span>
                                </a>
                            @else
                                <a class="p-0" style="cursor: default;">
                                    <img class="flag-icon" src="{{ $countryFlag32Url }}" alt="{{ $countryName }}" loading="lazy">
                                </a>
                            @endif
                        </li>
                    @endif
                    @if (!auth()->check())
                        <li class="nav-item dropdown no-arrow open-on-hover d-md-block d-sm-none d-none">
                            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" style="color: white">
                                <i class="fas fa-user"></i> <span>{{ t('log_in') }}</span> <i class="bi bi-chevron-down"></i>
                            </a>
                            <ul id="authDropdownMenu" class="dropdown-menu user-menu shadow-sm">
                                <li class="dropdown-item">
                                    @if (config('settings.security.login_open_in_modal'))
                                        <a href="#quickLogin" class="nav-link" data-bs-toggle="modal" style="color: white"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                                    @else
                                        <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link" style="color: white"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                                    @endif
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link" style="color: white"><i class="far fa-user"></i> {{ t('sign_up') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-md-none d-sm-block d-block">
                            {{-- @if (config('settings.security.login_open_in_modal'))
                                <a href="#quickLogin" class="nav-link" data-bs-toggle="modal" style="color: white"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @else
                                <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link" style="color: white"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @endif --}}
                            <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link" style="color: white"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                           
                        </li>
                        <li class="nav-item d-md-none d-sm-block d-block">
                            <a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link" style="color: white"><i class="far fa-user"></i> {{ t('sign_up') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown no-arrow open-on-hover">
                            <a href="#" class="dropdown-toggle nav-link text-nowrap" data-bs-toggle="dropdown" style="color: white">
                                <i class="fas fa-user-circle"></i> <span>{{ auth()->user()->name }}</span>
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
                                                @if ($value['name'] == 'Messenger')
                                                <span class="badge badge-pill badge-important count-threads-with-new-messages d-lg-inline-block d-md-none">0</span>
                                                @endif
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
                    <li class="nav-item postadd d-none d-md-block" style="min-width: fit-content">
                        <a id="btnPostAdlink1" class="btn btn-block btn-border btn-listing border-null" href="{{ $addListingUrl }}"{!! $addListingAttr !!}>
                            {{ t('Create Listing') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="container search-container d-md-none" style="width: 100vw;padding:0%;margin:0%">
    <form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
        <div class="row search-row animated fadeInUp border-null">
            <div class="col-6 col-xl-8 col-lg-8 col-md-8 col-sm-8 search-col relative mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
                <div class="search-col-inner">
                    <div class="search-col-input" style="margin-left: 0px; width: 100%;">
                        <input class="form-control font-size-d" value="{{ $keywords }}" name="q" placeholder="{{ t('what') }}"
                            type="text" value="" style="border-radius:0% !important;padding-right:0% !important;font-size:13px">
                    </div>
                </div>
            </div>
            <input type="hidden" id="lSearch2" name="l" value="">
            <input type="hidden" id="nearLocation2" name="location" value="">
            <div class="col-4 col-md-5 col-sm-12 search-col relative mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0 d-md-none">
                <div class="search-col-inner">
                    <div class="search-col-input" style="margin-left: 0px; width: 100%;"
     @if ($displayStatesSearchTip)
         data-bs-placement="top"
         data-bs-toggle="tooltipHover"
         title="{{ t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name') }}"
     @endif>
    <select class="form-control font-size-d" id="locSearch" name="l[]" multiple placeholder="{{ t('where') }}" style="border-radius:0% !important;padding-right:0% !important;font-size:13px">
        @foreach ($cities as $city)
            <option value="{{ $city->id }}"
                {{ in_array($city->id, (array)request()->query('l', [])) ? 'selected' : '' }}>
                {{ $city->name }}
            </option>
        @endforeach
    </select>
</div>
                </div>
            </div>

            <div class="col-1 col-xl-2 col-lg-2 col-md-2 col-sm-2 search-col"">
                <div class="search-btn-border">

                    <button class="btn btn-primary btn-search"
                        style="width: 100%; border-radius: 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black"
                            style="width: 1.5em; height: 1.5em;">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="col-1 col-xl-2 col-lg-2 col-md-2 col-sm-2 search-col"">
                <div class="search-btn-border">
                    <button type="button" id="toggleFilter2" class="btn btn-primary btn-search"
                        style="width: 100%; border-radius: 0px 7.5px 7.5px 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black"
                            style="width: 1.5em; height: 1.5em;">
                            <path d="M3 6h18v2H3V6zm4 4h10v2H7v-2zm4 4h6v2h-6v-2z" />
                        </svg>
                    </button>

                </div>
            </div>
        </div>

        {{-- Filter Panel --}}
        <div id="filterPanel2" class="filter-panel d-md-none" style="display: none">
            <div class="filter-section">
                <h5>Price Range</h5>
                <input type="number" name="minPrice" placeholder="Min Price" class="form-control mb-2" value="{{$minPrice}}">
                <input type="number" name="maxPrice" placeholder="Max Price" class="form-control" value="{{$maxPrice}}">
            </div>
            <div class="filter-section">
                <h5>Categories</h5>
                <div class="category-options">
                    @foreach ($cats as $cat)
                    <label class="category-item">
                        <input type="checkbox" name="c[]" value="{{ $cat['id'] }}"
                            {{ in_array($cat['id'], request()->query('c', [])) ? 'checked' : '' }}>
                        {{ $cat['name'] }}
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="filter-section">
                            <button class="btn btn-primary btn-search submit-button" style="width: 25%; border-radius: 7.5px !important; background-color: #FE9000 !important; padding: 0px;color:black !important;text-shadow: none !important;border:none;height:auto;padding-block:3px;">
                                Submit
                            </button>
                            <button type="button" id="toggleFilterClose2" class="btn btn-primary btn-search submit-button" style="width: 25%; border-radius: 7.5px !important; background-color: #FE9000 !important; padding: 0px;color:black !important;text-shadow: none !important;border:none;height:auto;padding-block:3px;">
                                Close
                            </button>
                        </div>
            {{-- <div class="filter-section">
                <h5>Location</h5>
                <input type="text" id="locationFilter2" name="location" class="form-control mb-2"
                    placeholder="Filter locations...">
            </div> --}}
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
    function navigateTo(url) {
        window.location.href = url;
    }

    $(document).ready(function() {
        // Toggle filter panel
        $('#toggleFilter').click(function() {
            $('#filterPanel').slideToggle(300);
        });

        $('#toggleFilterClose').click(function() {
            $('#filterPanel').slideToggle(300);
        });

        // Filter locations dynamically
        $('#locationFilter').on('input', function() {
            let filter = $(this).val().toLowerCase();
            $('#locationList .location-item').each(function() {
                let locationText = $(this).text().toLowerCase();
                $(this).toggle(locationText.includes(filter));
            });
            if (!filter) {
                $('#lSearch').val('');
            }
        });

        $('#toggleFilter2').click(function() {
            $('#filterPanel2').slideToggle(300);
        });

         $('#toggleFilterClose2').click(function() {
            $('#filterPanel2').slideToggle(300);
        });

        // Filter locations dynamically
        $('#locationFilter2').on('input', function() {
            let filter = $(this).val().toLowerCase();
            $('#locationList2 .location-item').each(function() {
                let locationText = $(this).text().toLowerCase();
                $(this).toggle(locationText.includes(filter));
            });
            if (!filter) {
                $('#lSearch2').val('');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        let locationTomSelect = new TomSelect('#locationSelect', {
            plugins: ['remove_button'],
            maxItems: null,
            valueField: 'name',
            labelField: 'name',
            searchField: ['name'],
            placeholder: 'Select locations...',
            render: {
                option: function(item, escape) {
                    return `<div>${escape(item.name)}</div>`;
                },
                item: function(item, escape) {
                    return `<div>${escape(item.name)}</div>`;
                }
            }
        });

        locationTomSelect.on('change', function(values) {
        

        let nearLocationInput = $('#nearLocation'); // Get the hidden input element

        // Check if exactly one item is selected
        if (values && values.length === 1) {
            // If exactly one item is selected, set the hidden input value to that item's value
            let selectedValue = values[0];
            nearLocationInput.val(selectedValue);
            console.log('Tom Select value changed. Exactly one item selected:', selectedValue);
        } else {
            // If zero or more than one item is selected, clear the hidden input
            nearLocationInput.val('');
            console.log('Tom Select selection changed. Zero or multiple items selected. Hidden input value cleared.');
        }
    });
    
    let initialSelectedValues = locationTomSelect.getValue(); // Get initial values from Tom Select

    // Apply the same logic as the change event handler to the initial state
    if (initialSelectedValues && initialSelectedValues.length === 1) {
        $('#nearLocation').val(initialSelectedValues[0]);
        console.log('Initial Tom Select value set. Exactly one item initially selected:', initialSelectedValues[0]);
    } else {
        $('#nearLocation').val('');
        console.log('No initial Tom Select value or multiple items initially selected.');
    }

    let locationTomSelect2 = new TomSelect('#locSearch', {
        plugins: ['remove_button'],
        maxItems: null,
        valueField: 'name',
        labelField: 'name',
        searchField: ['name'],
        placeholder: '{{ t('where') }}',
        /* load: function(query, callback) {
            fetch(`/api/cities?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    callback(data);
                })
                .catch(() => {
                    callback();
                });
        }, */
        render: {
            option: function(item, escape) {
                return `<div>${escape(item.name)}</div>`;
            },
            item: function(item, escape) {
                return `<div>${escape(item.name)}</div>`;
            }
        }
    });

    locationTomSelect2.on('change', function(values) {
        

        let nearLocationInput2 = $('#nearLocation2'); // Get the hidden input element

        // Check if exactly one item is selected
        if (values && values.length === 1) {
            // If exactly one item is selected, set the hidden input value to that item's value
            let selectedValue2 = values[0];
            nearLocationInput2.val(selectedValue2);
            console.log('Tom Select value changed. Exactly one item selected:', selectedValue2);
        } else {
            // If zero or more than one item is selected, clear the hidden input
            nearLocationInput2.val('');
            console.log('Tom Select selection changed. Zero or multiple items selected. Hidden input value cleared.');
        }
    });

    let initialSelectedValues2 = locationTomSelect2.getValue(); // Get initial values from Tom Select

    // Apply the same logic as the change event handler to the initial state
    if (initialSelectedValues2 && initialSelectedValues2.length === 1) {
        $('#nearLocation2').val(initialSelectedValues2[0]);
        console.log('Initial Tom Select value set. Exactly one item initially selected:', initialSelectedValues2[0]);
    } else {
        $('#nearLocation2').val('');
        console.log('No initial Tom Select value or multiple items initially selected.');
    }

    });

    

</script>

<style>

@media (max-width: 767px) {
    #locSearch + .ts-wrapper .ts-control {
        display: flex;
        flex-wrap: nowrap; 
        overflow-x: auto; 
        white-space: nowrap; 
        min-height: 45px;
        max-height: 45px; 
        align-items: center; 
        padding: 0px;
        padding-left: 3px;
        border-radius: 0px !important;
        font-size: 13px;
        border: none !important;
    }

    #locSearch + .ts-wrapper .ts-control > .item {
        display: inline-flex;
        align-items: center;
        margin-right: 5px; 
        white-space: nowrap;
        flex-shrink: 0; 
    }

    #locSearch + .ts-wrapper .ts-control > .item .remove {
        margin-left: 5px;
    }

   
    #locSearch + .ts-wrapper .ts-control::-webkit-scrollbar {
        display: none;
    }
    #locSearch + .ts-wrapper .ts-control {
        -ms-overflow-style: none;
        scrollbar-width: none; 
    }

    .ts-wrapper{
        padding: 0px !important;
        z-index: 9999 !important;
    }

    .ts-dropdown{
        margin-top:0px !important;
        border: none !important;
        border-radius: 0px !important;
        z-index: 10000 !important; 
    }

    
.search-container {
    position: relative;
    z-index: 2000; 
}

.search-col.relative {
    position: relative;
    z-index: 2010; 
}

.search-col-inner {
    position: relative;
    z-index: 2020; 
}

.search-col-input {
    position: relative;
    z-index: 2030; 
}

}

    @media (min-width: 768px) {
        .navbar-desktop {
            justify-content: end;
        }
        .category-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; 
        }
        .category-item {
            margin-right: 0; 
        }
        
    }
    @media (min-width: 1024px) {

        .width-search-xl {
            max-width:314.88px !important;
        }

        .margin-l-null {
            margin-left: 1.5% !important;
            padding-left: 0px;
            padding-right: 0px;
        }
        .font-size-d {
            font-size: 13px !important;
        }
        .filter-panel {
        position: absolute;
        left: 13% !important;
        width: 74% !important;
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        padding-top: 15px !important;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-top:19px;
    }
    }
    @media (min-width: 1440px) {

        .width-search-xl {
            max-width:442.8px !important;
        }
        .margin-l-null {
            margin-left: 1.5vw !important;
        }
        .font-size-d {
            font-size: 16px !important;
        }
        .filter-panel {
        position: absolute;
        left: 13% !important;
        width: 74% !important;
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        padding-top: 15px !important;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-top:19px;
    }
    }

    @media (min-width: 2560px) {
        .width-search-xl {
            max-width:401.6px !important;
        }
        .margin-l-null {
            margin-left: 0vw !important;
        }
        .filter-panel {
        position: absolute;
        left: 13% !important;
        width: 74% !important;
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        padding-top: 15px !important;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-top:19px;
    }
    .submit-button{
        width:6.25% !important;
    }
    }
    .filter-panel {
        position: absolute;
        left: 0;
        width: 100%;
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .filter-section {
        margin-bottom: 20px;
    }
    .filter-section h5 {
        margin-bottom: 10px;
        font-size: 16px;
    }
    details {
        margin-bottom: 10px;
    }
    summary {
        cursor: pointer;
        padding: 5px;
    }
    label {
        display: block;
        margin: 5px 0;
    }
    .category-item {
        display: block;
        margin: 5px 0; 
    }
    .category-item input[type="radio"] {
        margin-right: 5px;
    }

    .navbar-toggler .menu-icon,
    .navbar-toggler .close-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        /* Optional: Set a fixed size for the span if needed, e.g., width: 30px; height: 30px; */
    }

    
    .navbar-toggler .close-icon {
        display: none;
    }

    
    .navbar-toggler[aria-expanded="true"] .menu-icon {
        display: none;
    }

    .navbar-toggler[aria-expanded="true"] .close-icon {
        display: inline-flex; 
    }

    .category-options {
        max-height: 200px;
        overflow-y: auto;
    }
    .category-item {
        display: block;
        margin: 5px 0;
    }
    .category-item input[type="checkbox"] {
        margin-right: 5px;
    }
    .ts-wrapper {
        width: 100%;
    }
    .ts-control {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
        min-height: 38px;
    }
    .ts-control input {
        border: none !important;
    }
    .ts-dropdown {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        z-index: 1000;
    }

</style>