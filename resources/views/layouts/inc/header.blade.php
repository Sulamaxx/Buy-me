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

    // Sample categories and cities (replace with your actual data)
    $cats = collect([
        ['id' => 1, 'name' => 'Electronics', 'children' => [
            ['id' => 11, 'name' => 'Phones'],
            ['id' => 12, 'name' => 'Laptops'],
        ]],
        ['id' => 2, 'name' => 'Vehicles', 'children' => [
            ['id' => 21, 'name' => 'Cars'],
            ['id' => 22, 'name' => 'Bikes'],
        ]],
    ]);
    $cities = collect([
        ['id' => 1, 'name' => 'New York'],
        ['id' => 2, 'name' => 'Los Angeles'],
        ['id' => 3, 'name' => 'Chicago'],
        ['id' => 4, 'name' => 'Colombo'],
    ]);

    $cats = App\Models\Category::where('parent_id', null)->get();
                   
@endphp

<div class="header">
    <nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md flex-nowrap" role="navigation">
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
                            <img src="{{ $countryFlag24Url }}" alt="{{ $countryName }}" style="float: left;">
                            <span class="caret d-none"></span>
                        </button>
                    @endif
                    <button class="navbar-toggler -toggler"
                            style="color: white; margin-bottom: 2.5px"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarsDefault"
                            aria-controls="navbarsDefault"
                            aria-expanded="false"
                            aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30" focusable="false" style="color: white">
                            <title>{{ t('Menu') }}</title>
                            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path>
                        </svg>
                    </button>
                </div>
            </div>
      {{--   max-width: 30.75vw --}}
            <div class="container search-container d-none d-md-block margin-l-null" style="max-width: 30.75vw; margin-left: 5vw;">
                <form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
                    <div class="row search-row animated fadeInUp border-null">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
                            <div class="search-col-inner">
                                <div class="search-col-input" style="margin-left: 0px; width: 100%;">
                                    <input class="form-control font-size-d" name="q" placeholder="{{ t('what') }}" type="text" value="" style="border-radius:0% !important;">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="lSearch" name="l" value="">
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 search-col" style="border-left: 1px solid black;">
                            <div class="search-btn-border">
        
                                <button class="btn btn-primary btn-search" style="width: 100%; border-radius: 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" style="width: 1.5em; height: 1.5em;">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 search-col" style="border-left: 1px solid black;">
                            <div class="search-btn-border">
                                <button type="button" id="toggleFilter" class="btn btn-primary btn-search" style="width: 100%; border-radius: 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
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
                            <input type="number" name="minPrice" placeholder="Min Price" class="form-control mb-2">
                            <input type="number" name="maxPrice" placeholder="Max Price" class="form-control">
                        </div>
                        <div class="filter-section">
                            <h5>Categories</h5>
                            <div class="category-options">
                            @foreach ($cats as $cat)
                            <label class="category-item">
                                <input type="radio" name="c" value="{{ $cat['id'] }}"> {{ $cat['name'] }}
                            </label>
                            @endforeach
                            </div>
                        </div>
                        <div class="filter-section">
                            <h5>Location</h5>
                            <input type="text" id="locationFilter" name="location" class="form-control mb-2" placeholder="Filter locations...">
                        </div>
                    </div>
                </form>
            </div>

            <div class="navbar-collapse collapse navbar-desktop" id="navbarsDefault">
                <ul class="nav navbar-nav me-md-auto navbar-left d-md-none d-sm-block d-block" style="margin-inline: 0px !important">
                    <div class="btn-group btn-group-xs" style="padding: 0px;">
                        <button type="button" id="btn-en-lang-mobile" class="btn-primary me-1" onclick="navigateTo('/locale/en')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">English</button>
                        <button type="button" id="btn-si-lang-mobile" class="btn-primary me-1" onclick="navigateTo('/locale/si_LK')" style="background-color: transparent; border-color: transparent; border-left: 1px solid #666; border-right: 1px solid #666; padding: 0 5px;">සිංහල</button>
                        <button type="button" id="btn-ta-lang-mobile" class="btn-primary" onclick="navigateTo('/locale/ta_LK')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">தமிழ்</button>
                    </div>
                    @if ($showCountryFlagNextLogo && !empty($countryFlag32Url))
                        <li class="flag-menu country-flag d-md-none d-sm-block d-block nav-item"
                            data-bs-toggle="tooltip"
                            data-bs-placement="{{ config('lang.direction') == 'rtl' ? 'bottom' : 'right' }}" {!! $multiCountryLabel !!}
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
                </ul>

                <ul class="nav navbar-nav ms-auto navbar-right" style="margin-inline: 0px !important">
                    <li><a href="{{ \App\Helpers\UrlGen::sitemap() }}" class="nav-link" style="color: white"><i class=""></i> {{ t('all_categories') }}</a></li>
                    <li class="nav-item d-none d-md-block" style="margin-inline: 0px !important; margin-left: 10px; margin-block: auto;">
                        <div class="btn-group btn-group-xs" style="padding: 0px;">
                            <button type="button" id="btn-en-lang-desktop" class="btn-primary me-1" onclick="navigateTo('/locale/en')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">English</button>
                            <button type="button" id="btn-si-lang-desktop" class="btn-primary me-1" onclick="navigateTo('/locale/si_LK')" style="background-color: transparent; border-color: transparent; border-left: 1px solid #666; border-right: 1px solid #666; padding: 0 5px;">සිංහල</button>
                            <button type="button" id="btn-ta-lang-desktop" class="btn-primary" onclick="navigateTo('/locale/ta_LK')" style="background-color: transparent; border-color: transparent; padding: 0 2.5px;">தமிழ்</button>
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
                            @if (config('settings.security.login_open_in_modal'))
                                <a href="#quickLogin" class="nav-link" data-bs-toggle="modal" style="color: white"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @else
                                <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link" style="color: white"><i class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @endif
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
            <div class="col-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 search-col relative mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
                <div class="search-col-inner">
                    <div class="search-col-input" style="margin-left: 0px; width: 100%;">
                        <input class="form-control font-size-d" name="q" placeholder="{{ t('what') }}"
                            type="text" value="" style="border-radius:0% !important;">
                    </div>
                </div>
            </div>
            <input type="hidden" id="lSearch2" name="l" value="">
            <div class="col-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 search-col"">
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
            <div class="col-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 search-col"">
                <div class="search-btn-border">
                    <button type="button" id="toggleFilter2" class="btn btn-primary btn-search"
                        style="width: 100%; border-radius: 0px !important; background-color: #e5e5e5 !important; padding: 0px;">
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
                <input type="number" name="minPrice" placeholder="Min Price" class="form-control mb-2">
                <input type="number" name="maxPrice" placeholder="Max Price" class="form-control">
            </div>
            <div class="filter-section">
                <h5>Categories</h5>
                <div class="category-options">
                    @foreach ($cats as $cat)
                        <label class="category-item">
                            <input type="radio" name="c" value="{{ $cat['id'] }}"> {{ $cat['name'] }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="filter-section">
                <h5>Location</h5>
                <input type="text" id="locationFilter2" name="location" class="form-control mb-2"
                    placeholder="Filter locations...">
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function navigateTo(url) {
        window.location.href = url;
    }

    $(document).ready(function() {
        // Toggle filter panel
        $('#toggleFilter').click(function() {
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
</script>

<style>
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
        .margin-l-null {
            margin-left: 0% !important;
            padding-left: 0px;
            padding-right: 0px;
        }
        .font-size-d {
            font-size: 13px !important;
        }
    }
    @media (min-width: 1440px) {
        .margin-l-null {
            margin-left: 2.5vw !important;
        }
        .font-size-d {
            font-size: 16px !important;
        }
    }
    .filter-panel {
        position: absolute;
        left: 0;
        width: 100%;
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        padding-top: 0px;
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
</style>