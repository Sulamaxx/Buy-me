@php
	$post ??= [];
	$user ??= [];
	$countPackages ??= 0;
	$countPaymentMethods ??= 0
    
@endphp
<aside>
	<div class="card card-user-info sidebar-card">
		@if (auth()->check() && auth()->id() == data_get($post, 'user_id'))
			<div class="card-header">{{ t('Manage Listing') }}</div>
		@else
        <?php
        $joindate=date_create($userName[0]->created_at);
        ?>
			<div class="block-cell user">
				<div class="cell-content">
					
					<span class="name">
				    {{ $userName[0]->name }} 
					</span>
                    <h5 class="title">{{ $UsrType }} Since {{ date_format($joindate,"F Y") }}</h5>
                    
                    <svg width="18" height="18" viewBox="0 0 18 18" class="svg-wrapper--8ky9e"><defs><path d="M7.535 7.535c.463-.463 1.011-.695 1.645-.695.634 0 1.182.232 1.645.695.463.463.695 1.011.695 1.645 0 .634-.232 1.182-.695 1.645-.463.463-1.011.695-1.645.695-.634 0-1.182-.232-1.645-.695-.463-.463-.695-1.011-.695-1.645 0-.634.232-1.182.695-1.645zm-1.04 4.33c.754.73 1.649 1.095 2.685 1.095s1.925-.37 2.667-1.113c.742-.742 1.113-1.63 1.113-2.667 0-1.036-.37-1.925-1.113-2.667C11.105 5.77 10.217 5.4 9.18 5.4c-1.036 0-1.925.37-2.667 1.113C5.77 7.255 5.4 8.143 5.4 9.18c0 1.036.365 1.931 1.095 2.685zM4.032 4.824C5.568 3.768 7.284 3.24 9.18 3.24s3.612.528 5.148 1.584A8.857 8.857 0 0 1 17.64 9a8.857 8.857 0 0 1-3.312 4.176c-1.536 1.056-3.252 1.584-5.148 1.584s-3.612-.528-5.148-1.584A8.857 8.857 0 0 1 .72 9a8.857 8.857 0 0 1 3.312-4.176z" id="view-icon_svg__a"></path></defs><use fill="#009877" xlink:href="#view-icon_svg__a" fill-rule="evenodd"></use></svg>
                    {{ $userShop[0]->shop_visits }} Shop Visits
                    <hr><h5 class="title">Shop Website</h5>
                    <span class="name">
				     <a href="{{ isset($userShop[0]->shop_website) && !empty($userShop[0]->shop_website) ? $userShop[0]->shop_website : '#' }}" target="_blank">
					    {{ isset($userShop[0]->shop_website) && !empty($userShop[0]->shop_website) ? 'Website Link' : 'N/A' }}
					</a>
					</span>
                    <h5 class="title">Shop Phone</h5>
                    <span class="name">
				     <a href="{{ isset($userShop[0]->shop_phone) && !empty($userShop[0]->shop_phone) ? 'tel:' . $userShop[0]->shop_phone : '#' }}">
					    <div class="icon--3D09z small--2q8vN fill-color--iBGk8 fill--2tkQ8">
					        {{ isset($userShop[0]->shop_phone) && !empty($userShop[0]->shop_phone) ? $userShop[0]->shop_phone : 'N/A' }}
					    </div>
					</a>
					</span>
                    
                    <?php /*?>
                    
                    <h5 class="title">Shop Email</h5>
                    <?php
                    if($userShop[0]->shop_email=='')
                    {
                    ?>
                        <i class="far fa-envelope" style="color: #dadada"></i>
                    <?php 
                    }
                    else
                    {
		  
                        $out = '';
                        $btnLink = '#contactUser';
                        $btnClass = '';
                        if (!auth()->check()) {
                            if (config('settings.single.guest_can_contact_authors') != '1') {
                                $btnLink = '#quickLogin';
                            }
                        }

//                        if (true) {
//                            $out .= '<a href="' . $btnLink . '" data-bs-toggle="modal">';
//                            $out .= '<i class="far fa-envelope" data-bs-toggle="tooltip" title="' . t('Send a message') . '"></i>';
//                        } else 
                    {
//                            if ($btnBlock) {
                                $btnClass = $btnClass . ' btn-block';
//                            }

                            $out .= '<a href="' . $btnLink . '" data-bs-toggle="modal" class="btn btn-default' . $btnClass . '">';
                            $out .= '<i class="far fa-envelope"></i> ';
                            $out .= t('Send a message');
                        }
                        $out .= '</a>';
                        echo $out;
                    }
                    ?>
                    <?php */?>
                    
                    
                    <hr>
                    <h5 class="title">Shop Location</h5>
                    <i class="fa fa-map-marker" aria-hidden="true"></i><span>
				    {{ isset($userShop[0]->shop_location) && !empty($userShop[0]->shop_location) ? $userShop[0]->shop_location : 'N/A' }}
 
					</span><hr>
                    <h5 class="title">Shop Open</h5>
					<span class="name">
				    <pre style="font-weight: 100;">{{ isset($userShop[0]->shop_open_hours) && !empty($userShop[0]->shop_open_hours) ? $userShop[0]->shop_open_hours : 'N/A' }}
</pre>
					</span>
                    <hr>
                    <h5 class="title">About Shop</h5>
					<pre>
				    {{ isset($userShop[0]->shop_details) && !empty($userShop[0]->shop_details) ? $userShop[0]->shop_details : 'N/A' }}

					</pre>
                    
                    
                    
				</div>
			</div>
		@endif

	</div>
    
    
    <div class="modal fade" id="contactUser" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title">
					<i class="fas fa-envelope"></i> Contact Shop
				</h4>
				
				<button type="button" class="close" data-bs-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">{{ t('Close') }}</span>
				</button>
			</div>
<!--			action="{{ url('account/messages/shops/' . $userShop[0]->id) }}"-->
			<form role="form"
			      method="POST"
			      action="#"
			      enctype="multipart/form-data"
			>
				{!! csrf_field() !!}
				@honeypot
				<div class="modal-body">

					@if (isset($errors) && $errors->any() && old('messageForm')=='1')
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ t('Close') }}"></button>
							<ul class="list list-check">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					
					@php
						$authUser = auth()->check() ? auth()->user() : null;
						$isNameCanBeHidden = (!empty($authUser));
						$isEmailCanBeHidden = (!empty($authUser) && !empty($authUser->email));
						$isPhoneCanBeHidden = (!empty($authUser) && !empty($authUser->phone));
						$authFieldValue = data_get($post, 'auth_field', getAuthField());
					@endphp
					
					{{-- name --}}
					@if ($isNameCanBeHidden)
						<input type="hidden" name="name" value="{{ $authUser->name ?? null }}">
					@else
						@php
							$fromNameError = (isset($errors) && $errors->has('name')) ? ' is-invalid' : '';
						@endphp
						<div class="mb-3 required">
							<label class="control-label" for="name">{{ t('Name') }} <sup>*</sup></label>
							<div class="input-group">
								<input id="fromName" name="name"
									   type="text"
									   class="form-control{{ $fromNameError }}"
									   placeholder="{{ t('your_name') }}"
									   value="{{ old('name', $authUser->name ?? null) }}"
								>
							</div>
						</div>
					@endif
					
					{{-- email --}}
					@if ($isEmailCanBeHidden)
						<input type="hidden" name="email" value="{{ $authUser->email ?? null }}">
					@else
						@php
							$fromEmailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : '';
						@endphp
						<div class="mb-3 required">
							<label class="control-label" for="email">{{ t('E-mail') }}
								@if ($authFieldValue == 'email')
									<sup>*</sup>
								@endif
							</label>
							<div class="input-group">
								<span class="input-group-text"><i class="far fa-envelope"></i></span>
								<input id="fromEmail" name="email"
									   type="text"
									   class="form-control{{ $fromEmailError }}"
									   placeholder="{{ t('eg_email') }}"
									   value="{{ old('email', $authUser->email ?? null) }}"
								>
							</div>
						</div>
					@endif
					
					{{-- phone --}}
					@if ($isPhoneCanBeHidden)
						<input type="hidden" name="phone" value="{{ $authUser->phone ?? null }}">
						<input name="phone_country" type="hidden" value="{{ $authUser->phone_country ?? config('country.code') }}">
					@else
						@php
							$fromPhoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : '';
							$phoneValue = $authUser->phone ?? null;
							$phoneCountryValue = $authUser->phone_country ?? config('country.code');
							$phoneValue = phoneE164($phoneValue, $phoneCountryValue);
							$phoneValueOld = phoneE164(old('phone', $phoneValue), old('phone_country', $phoneCountryValue));
						@endphp
						<div class="mb-3 required">
							<label class="control-label" for="phone">{{ t('phone_number') }}
								@if ($authFieldValue == 'phone')
									<sup>*</sup>
								@endif
							</label>
							<input id="fromPhone" name="phone"
								   type="tel"
								   maxlength="60"
								   class="form-control m-phone{{ $fromPhoneError }}"
								   placeholder="{{ t('phone_number') }}"
								   value="{{ $phoneValueOld }}"
							>
							<input name="phone_country" type="hidden" value="{{ old('phone_country', $phoneCountryValue) }}">
						</div>
					@endif
					
					{{-- auth_field --}}
					<input name="auth_field" type="hidden" value="{{ $authFieldValue }}">
					
					{{-- body --}}
					<?php $bodyError = (isset($errors) && $errors->has('body')) ? ' is-invalid' : ''; ?>
					<div class="mb-3 required">
						<label class="control-label" for="body">
							{{ t('Message') }} <span class="text-count">(500 max)</span> <sup>*</sup>
						</label>
						<textarea id="body" name="body"
							rows="5"
							class="form-control required{{ $bodyError }}"
							style="height: 150px;"
							placeholder="{{ t('your_message_here') }}"
						></textarea>
					</div>
					@php
						$catType = data_get($post, 'category.parent.type', data_get($post, 'category.type'));
					@endphp
					@if ($catType == 'job-offer')
						{{-- filename --}}
						<?php $filenameError = (isset($errors) && $errors->has('filename')) ? ' is-invalid' : ''; ?>
						<div class="mb-3 required" {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!}>
							<label class="control-label{{ $filenameError }}" for="filename">{{ t('Resume') }} </label>
							<input id="filename" name="filename" type="file" class="file{{ $filenameError }}">
							<div class="form-text text-muted">
								{{ t('file_types', ['file_types' => showValidFileTypes('file')]) }}
							</div>
						</div>
						<input type="hidden" name="catType" value="{{ $catType }}">
					@endif
					
					@include('layouts.inc.tools.captcha', ['label' => true])
					
					<input type="hidden" name="country_code" value="{{ config('country.code') }}">
					<input type="hidden" name="post_id" value="{{ $userShop[0]->id }}">
					<input type="hidden" name="messageForm" value="1">
				</div>
				
				<div class="modal-footer">
					<button disabled type="submit" class="btn btn-primary float-end">{{ t('send_message') }}</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ t('Cancel') }}</button>
				</div>
			</form>
			
		</div>
	</div>
</div>
    
    
	<?php /*?>
	@if (config('settings.single.show_listing_on_googlemap'))
		@php
			$mapHeight = 250;
			$mapPlace = (!empty(data_get($post, 'city')))
				? data_get($post, 'city.name') . ',' . config('country.name')
				: config('country.name');
			$mapUrl = getGoogleMapsEmbedUrl(config('services.googlemaps.key'), $mapPlace);
		@endphp
		<div class="card sidebar-card">
			<div class="card-header">{{ t('location_map') }}</div>
			<div class="card-content">
				<div class="card-body text-start p-0">
					<div class="posts-googlemaps">
						<iframe id="googleMaps" width="100%" height="{{ $mapHeight }}" src="{{ $mapUrl }}"></iframe>
					</div>
				</div>
			</div>
		</div>
	@endif
	
	@if (isVerifiedPost($post))
		@includeFirst([
			config('larapen.core.customizedViewPath') . 'layouts.inc.social.horizontal',
			'layouts.inc.social.horizontal'
		])
	@endif
	<?php */?>
	<div class="card sidebar-card">
<!--
		<div class="card-header">About Shop</div>
		<div class="card-content">
			<div class="card-body text-start">
				{{ $userShop[0]->shop_details }}
			</div>
		</div>
-->
	</div>
</aside>
