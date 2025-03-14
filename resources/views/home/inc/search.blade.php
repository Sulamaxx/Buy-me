@php
	$sectionOptions = $getSearchFormOp ?? [];
	$sectionData ??= [];
	
	// Get Search Form Options
	$enableFormAreaCustomization = data_get($sectionOptions, 'enable_extended_form_area') ?? '0';
	$hideTitles = data_get($sectionOptions, 'hide_titles') ?? '0';
	
	$headerTitle = data_get($sectionOptions, 'title_' . config('app.locale'));
	$headerTitle = (!empty($headerTitle)) ? replaceGlobalPatterns($headerTitle) : null;
	
	$headerSubTitle = data_get($sectionOptions, 'sub_title_' . config('app.locale'));
	$headerSubTitle = (!empty($headerSubTitle)) ? replaceGlobalPatterns($headerSubTitle) : null;
	
	$parallax = data_get($sectionOptions, 'parallax') ?? '0';
	$hideForm = data_get($sectionOptions, 'hide_form') ?? '0';
	$displayStatesSearchTip = config('settings.list.display_states_search_tip');
	
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';
@endphp
@if (isset($enableFormAreaCustomization) && $enableFormAreaCustomization == '1')
	
	@if (isset($firstSection) && !$firstSection)
		<div class="p-0 mt-lg-4 mt-md-3 mt-3"></div>
	@endif
	
	@php
		$parallax = ($parallax == '1') ? ' parallax' : '';
	@endphp

	@section('before_styles')

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

   @endsection

	<div class="container">
	<div id="carouselHome" class="carousel slide slider" data-ride="carousel" data-interval="2000" data-pause="false">
	<div class="carousel-indicators">
	    @if(isset($slider))
		   @foreach($slider as $key => $node)
		     @if($key === 0)
			   <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="{{$key}}" class="active" aria-current="true" aria-label="Slide {{$key}}"></button>
			 @else
			   <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="{{$key}}" aria-label="Slide {{$key}}"></button>
			 @endif
		   @endforeach
		@endif
	</div>
	<div class="carousel-inner">
	   @if(isset($slider))
		   @foreach($slider as $key => $node)
		     @if($key === 0)
			   <div class="carousel-item active">
			      <img src="{!! url('/uploads/').'/'.$node->image_name !!}" class="d-block w-100 bannar-image" alt="banner">
			   </div>
			 @else
			   <div class="carousel-item">
			      <img src="{!! url('/uploads/').'/'.$node->image_name !!}" class="d-block w-100 bannar-image" alt="banner">
			   </div>
			 @endif
		   @endforeach
		@endif
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Next</span>
	</button>
	</div>
	</div>
	

    <!-- <div class="d-none"> -->
	<!-- <div class="d-none d-md-block d-lg-block d-xl-block"> -->
		<!-- <div class="top-post my-4 d-flex">
			<div class="col-6 d-none d-md-block d-lg-block d-xl-block"> 
				<h1 style="font-weight: bold;">SellSmart, BuyBetter Your Ultimate Marketplace</h1>
				<h5>Buyme.lk: Simplifying Buying and Selling. Your go-to platform for seamless transactions and smart commerce.</h5>  
			</div>
			<div class="col-6">
			    <img alt="homepage" class="d-none d-md-block d-lg-block d-xl-block" src="{{ asset('images/homepage-image1.png') }}" >
			</div>
		</div>
	</div> -->
	
@else
	
	@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'])
	<div class="intro only-search-bar{{ $hideOnMobile }}">
		<div class="container text-center">
			
			@if ($hideForm != '1')
				<form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
					<div class="row search-row animated fadeInUp">
						
						<div class="col-md-5 col-sm-12 search-col relative mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
							<div class="search-col-inner">
								<i class="fas {{ (config('lang.direction')=='rtl') ? 'fa-angle-double-left' : 'fa-angle-double-right' }} icon-append"></i>
								<div class="search-col-input">
									<input class="form-control has-icon" name="q" placeholder="{{ t('what') }}" type="text" value="">
								</div>
							</div>
						</div>
						
						<input type="hidden" id="lSearch" name="l" value="">
						
						<div class="col-md-5 col-sm-12 search-col relative locationicon mb-1 mb-xxl-0 mb-xl-0 mb-lg-0 mb-md-0">
							<div class="search-col-inner">
								<i class="fas fa-map-marker-alt icon-append"></i>
								<div class="search-col-input">
									@if ($displayStatesSearchTip)
										<input class="form-control locinput input-rel searchtag-input has-icon"
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
										<input class="form-control locinput input-rel searchtag-input has-icon"
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
						
						<div class="col-md-2 col-sm-12 search-col">
							<div class="search-btn-border bg-primary">
								<button class="btn btn-primary btn-search btn-block btn-gradient" >
									<i class="fas fa-search"></i> <strong>{{ t('find') }}</strong>
								</button>
							</div>
						</div>
					
					</div>
				</form>
			@endif
		
		</div>
	</div>
	
@endif


@section('after_scripts')
<script type="text/javascript">
	$(document).ready(function(){
		document.getElementById('carouselHome').focus();
	
			
// Function to click the button
function clickButton() {
    // Select the button using a query selector
    const button = document.querySelector('.carousel-control-next');
    if (button) {
        button.click();
    } else {
        console.error('Button not found!');
    }
}

// Call clickButton every 10 seconds (5000 milliseconds)
setInterval(clickButton, 10000);

 
 
 
    
    });	
</script>

@endsection
