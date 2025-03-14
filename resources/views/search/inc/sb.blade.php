@php
@endphp
@if (!empty($userShop))
	@php
		$margin = '';
		
		
	@endphp

	<div class="container{{ $margin }}">
		<div class="row">
			@php
				$responsiveClass = (data_get($topAdvertising, 'is_responsive') != 1) ? ' d-none d-xl-block d-lg-block d-md-none d-sm-none' : '';
			@endphp
			{{-- Desktop --}}
			<div class="col-12 ads-parent-responsive{{ $responsiveClass }}">
				<div class="text-center">
                    <img src="<?php
                             echo("/storage/".$userShop[0]->shop_banner);
                              ?>" />
<!--					{!! data_get($topAdvertising, 'tracking_code_large') !!}-->
				</div>
			</div>
			@if (data_get($topAdvertising, 'is_responsive') != 1)
				{{-- Tablet --}}
				<div class="col-12 ads-parent-responsive d-none d-xl-none d-lg-none d-md-block d-sm-none">
					<div class="text-center">
						<img src="<?php
                             echo("/storage/".$userShop[0]->shop_banner);
                              ?>" />
					</div>
				</div>
				{{-- Mobile --}}
				<div class="col-12 ads-parent-responsive d-block d-xl-none d-lg-none d-md-none d-sm-block">
					<div class="text-center">
						<img src="<?php
                             echo("/storage/".$userShop[0]->shop_banner);
                              ?>" />
					</div>
				</div>
			@endif
		</div>
	</div>
@endif
