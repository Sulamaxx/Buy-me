
<?php
	$htmlLang = getLangTag(config('app.locale'));
	$htmlDir = (config('lang.direction') == 'rtl') ? ' dir="rtl"' : '';
	
	$plugins = array_keys((array)config('plugins'));
	$publicDisk = \Storage::disk(config('filesystems.default'));
	
	// Apple Icons
	$appleIcon = $publicDisk->url('app/default/ico/apple-touch-icon.png') . getPictureVersion();
	$faviconico = $publicDisk->url('app/default/ico/favicon.ico') . getPictureVersion();
	$favicon32 = $publicDisk->url('app/default/ico/favicon-32x32.png') . getPictureVersion();
	$favicon16 = $publicDisk->url('app/default/ico/favicon-16x16.png') . getPictureVersion();
	$appleIcon57 = $publicDisk->url('app/default/ico/apple-touch-icon-57-precomposed.png') . getPictureVersion();
 
	
	
	
?>
<!DOCTYPE html>
<html lang="<?php echo e($htmlLang); ?>"<?php echo $htmlDir; ?>>
<head>
	<meta charset="<?php echo e(config('larapen.core.charset', 'utf-8')); ?>">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.meta-robots', 'common.meta-robots'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-title" content="<?php echo e(config('settings.app.name')); ?>">
	<meta name="facebook-domain-verification" content="hjahk6hrc1rz607bly6c948nswoki0" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e($appleIcon); ?>">
	<link rel="apple-touch-icon-precomposed" href="<?php echo e($appleIcon57); ?>">
	
	 
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo e($favicon32); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo e($favicon16); ?>">
 
        <link rel="alternate" href="https://buyme.lk/locale/en" hreflang="en" />
        <link rel="alternate" href="https://buyme.lk/locale/si_LK" hreflang="si-LK" />
        <link rel="alternate" href="https://buyme.lk/locale/ta_LK" hreflang="ta-LK" />
	<link rel="alternate" href="https://buyme.lk/locale/en" hreflang="x-default" />
	<link rel="icon" href="<?php echo e($faviconico); ?>" type="image/x-icon">
         
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo e($faviconico); ?>">
	<title><?php echo MetaTag::get('title'); ?></title>
	<?php echo MetaTag::tag('description'); ?><?php echo MetaTag::tag('keywords'); ?>

	<link rel="canonical" href="<?php echo e(request()->fullUrl()); ?>"/>
	
	<base target="_top"/>
	<?php if(isset($post)): ?>
		<?php if(isVerifiedPost($post)): ?>
			<?php if(config('services.facebook.client_id')): ?>
				<meta property="fb:app_id" content="<?php echo e(config('services.facebook.client_id')); ?>" />
			<?php endif; ?>
			<?php echo $og->renderTags(); ?>

			<?php echo MetaTag::twitterCard(); ?>

		<?php endif; ?>
	<?php else: ?>
		<?php if(config('services.facebook.client_id')): ?>
			<meta property="fb:app_id" content="<?php echo e(config('services.facebook.client_id')); ?>" />
		<?php endif; ?>
		<?php echo $og->renderTags(); ?>

		<?php echo MetaTag::twitterCard(); ?>

	<?php endif; ?>
	<?php echo $__env->make('feed::links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo seoSiteVerification(); ?>

	
	<?php if(file_exists(public_path('manifest.json'))): ?>
		<link rel="manifest" href="/manifest.json">
	<?php endif; ?>
	
	<?php echo $__env->yieldPushContent('before_styles_stack'); ?>
    <?php echo $__env->yieldContent('before_styles'); ?>
	
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
		<link href="<?php echo e(url(mix('css/app.rtl.css'))); ?>" rel="stylesheet">
	<?php else: ?>
		<link href="<?php echo e(url(mix('css/app.css'))); ?>" rel="stylesheet">
	<?php endif; ?>
	<?php if(config('plugins.detectadsblocker.installed')): ?>
		<link href="<?php echo e(url('assets/detectadsblocker/css/style.css') . getPictureVersion()); ?>" rel="stylesheet">
	<?php endif; ?>
	
	<?php
		$skinQs = (request()->filled('skin')) ? '?skin=' . request()->query('skin') : null;
		if (request()->filled('display')) {
			$skinQs .= (!empty($skinQs)) ? '&' : '?';
			$skinQs .= 'display=' . request()->query('display');
		}
		// style.css
		$styleCssUrl = url('common/css/style.css') . $skinQs . getPictureVersion(!empty($skinQs));
	?>
	<link href="<?php echo e($styleCssUrl); ?>" rel="stylesheet">
	<?php
		$homeStyle = '';
		if (isset($getSearchFormOp) && is_array($getSearchFormOp)) {
			$homeStyle = view('common.css.homepage', ['getSearchFormOp', $getSearchFormOp])->render();
		}
	?>
	<?php echo $homeStyle; ?>

	
	<link href="<?php echo e(url()->asset('css/custom.css') . getPictureVersion()); ?>" rel="stylesheet">
	
	<?php echo $__env->yieldPushContent('after_styles_stack'); ?>
    <?php echo $__env->yieldContent('after_styles'); ?>
	
	<?php if(!empty($plugins)): ?>
		<?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->yieldContent($plugin . '_styles'); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
    
    <?php if(config('settings.style.custom_css')): ?>
		<?php echo printCss(config('settings.style.custom_css')) . "\n"; ?>

    <?php endif; ?>
	
	<?php if(config('settings.other.js_code')): ?>
		<?php echo printJs(config('settings.other.js_code')) . "\n"; ?>

	<?php endif; ?>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
 
	<script>
		paceOptions = {
			elements: true
		};
	</script>
	<script defer src="<?php echo e(url()->asset('assets/plugins/pace/0.4.17/pace.min.js')); ?>"></script>
	<script defer src="<?php echo e(url()->asset('assets/plugins/modernizr/modernizr-custom.js')); ?>"></script>
	<script  src="<?php echo e(url()->asset('assets/js/bannerRotator.js')); ?>"></script>
	
	<?php echo $__env->yieldContent('captcha_head'); ?>
	<?php $__env->startSection('recaptcha_head'); ?>
		<?php
			$captcha = config('settings.security.captcha');
			$reCaptchaVersion = config('recaptcha.version', 'v2');
			$isReCaptchaEnabled = (
				$captcha == 'recaptcha'
				&& !empty(config('recaptcha.site_key'))
				&& !empty(config('recaptcha.secret_key'))
				&& in_array($reCaptchaVersion, ['v2', 'v3'])
			);
		?>
		<?php if($isReCaptchaEnabled): ?>
			<style>
				.is-invalid .g-recaptcha iframe,
				.has-error .g-recaptcha iframe {
					border: 1px solid #f85359;
				}
			</style>
			<?php if($reCaptchaVersion == 'v3'): ?>
				<script type="text/javascript">
					function myCustomValidation(token){
						/* read HTTP status */
						/* console.log(token); */
						let gRecaptchaResponseEl = $('#gRecaptchaResponse');
						if (gRecaptchaResponseEl.length) {
							gRecaptchaResponseEl.val(token);
						}
					}
				</script>
				<?php echo recaptchaApiV3JsScriptTag([
					'action' 		    => request()->path(),
					'custom_validation' => 'myCustomValidation'
				]); ?>

			<?php else: ?>
				<?php echo recaptchaApiJsScriptTag(); ?>

			<?php endif; ?>
		<?php endif; ?>
	<?php echo $__env->yieldSection(); ?>
</head>
<body class="skin">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNSJZK3R"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper">
	
	<?php $__env->startSection('header'); ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.header', 'layouts.inc.header'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php $__env->startSection('search'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php $__env->startSection('wizard'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php if(isset($siteCountryInfo)): ?>
		<div class="p-0 mt-lg-4 mt-md-3 mt-3"></div>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="alert alert-warning alert-dismissible mb-3">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo e(t('Close')); ?>"></button>
						<?php echo $siteCountryInfo; ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php echo $__env->yieldContent('content'); ?>
	
	<?php $__env->startSection('info'); ?>
	<?php echo $__env->yieldSection(); ?>
	
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.auto', 'layouts.inc.advertising.auto'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
	<?php $__env->startSection('footer'); ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.footer', 'layouts.inc.footer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldSection(); ?>
	
</div>

<?php $__env->startSection('modal_location'); ?>
<?php echo $__env->yieldSection(); ?>
<?php $__env->startSection('modal_abuse'); ?>
<?php echo $__env->yieldSection(); ?>
<?php $__env->startSection('modal_message'); ?>
<?php echo $__env->yieldSection(); ?>

<?php echo $__env->renderWhen(!auth()->check(), 'auth.login.inc.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.change-country', 'layouts.inc.modal.change-country'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.error', 'layouts.inc.modal.error'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('cookie-consent::index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(config('plugins.detectadsblocker.installed')): ?>
	<?php if(view()->exists('detectadsblocker::modal')): ?>
		<?php echo $__env->make('detectadsblocker::modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php endif; ?>

<?php echo $__env->make('common.js.init', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
	var countryCode = '<?php echo e(config('country.code', 0)); ?>';
	var timerNewMessagesChecking = <?php echo e((int)config('settings.other.timer_new_messages_checking', 0)); ?>;
	
	/* Complete langLayout translations */
	langLayout.hideMaxListItems = {
		'moreText': "<?php echo e(t('View More')); ?>",
		'lessText': "<?php echo e(t('View Less')); ?>"
	};
	langLayout.select2 = {
		errorLoading: function(){
			return "<?php echo t('The results could not be loaded'); ?>"
		},
		inputTooLong: function(e){
			var t = e.input.length - e.maximum, n = <?php echo t('Please delete X character'); ?>;
			return t != 1 && (n += 's'),n
		},
		inputTooShort: function(e){
			var t = e.minimum - e.input.length, n = <?php echo t('Please enter X or more characters'); ?>;
			return n
		},
		loadingMore: function(){
			return "<?php echo t('Loading more results'); ?>"
		},
		maximumSelected: function(e){
			var t = <?php echo t('You can only select N item'); ?>;
			return e.maximum != 1 && (t += 's'),t
		},
		noResults: function(){
			return "<?php echo t('No results found'); ?>"
		},
		searching: function(){
			return "<?php echo t('Searching'); ?>"
		}
	};
	var loadingWd = '<?php echo e(t('loading_wd')); ?>';
	
	
	var defaultAuthField = '<?php echo e(old('auth_field', getAuthField())); ?>';
	var phoneCountry = '<?php echo e(config('country.code')); ?>';
	
	
	var fakeLocationsResults = "<?php echo e(config('settings.list.fake_locations_results', 0)); ?>";
	var stateOrRegionKeyword = "<?php echo e(t('area')); ?>";
	var errorText = {
		errorFound: "<?php echo e(t('error_found')); ?>"
	};
	var refreshBtnText = "<?php echo e(t('refresh')); ?>";
</script>

<?php echo $__env->yieldPushContent('before_scripts_stack'); ?>
<?php echo $__env->yieldContent('before_scripts'); ?>

<script defer src="<?php echo e(url('common/js/intl-tel-input/countries.js') . getPictureVersion()); ?>"></script>
<script   src="<?php echo e(url(mix('js/app.js'))); ?>"></script>
<?php if(config('settings.optimization.lazy_loading_activation') == 1): ?>
	<script   src="<?php echo e(url()->asset('assets/plugins/lazysizes/lazysizes.min.js')); ?>" async=""></script>
<?php endif; ?>
<?php if(file_exists(public_path() . '/assets/plugins/select2/js/i18n/'.config('app.locale').'.js')): ?>
	<script defer src="<?php echo e(url()->asset('assets/plugins/select2/js/i18n/'.config('app.locale').'.js')); ?>"></script>
<?php endif; ?>
<?php if(config('plugins.detectadsblocker.installed')): ?>
	<script defer src="<?php echo e(url('assets/detectadsblocker/js/script.js') . getPictureVersion()); ?>"></script>
<?php endif; ?>
<script>
	$(document).ready(function () {
		
		let largeDataSelect2Params = {
			width: '100%',
			dropdownAutoWidth: 'true'
		};
		
		let select2Params = {...largeDataSelect2Params};
		
		select2Params.minimumResultsForSearch = Infinity;
		
		if (typeof langLayout !== 'undefined' && typeof langLayout.select2 !== 'undefined') {
			select2Params.language = langLayout.select2;
			largeDataSelect2Params.language = langLayout.select2;
		}
		
		$('.selecter').select2(select2Params);
		$('.large-data-selecter').select2(largeDataSelect2Params);
		
		
		$('.share').ShareLink({
			title: '<?php echo e(addslashes(MetaTag::get('title'))); ?>',
			text: '<?php echo addslashes(MetaTag::get('title')); ?>',
			url: '<?php echo request()->fullUrl(); ?>',
			width: 640,
			height: 480
		});
		
		
		<?php if(isset($errors) && $errors->any()): ?>
			<?php if($errors->any() && old('quickLoginForm')=='1'): ?>
				
				openLoginModal();
			<?php endif; ?>
		<?php endif; ?>
	});
</script>

<?php echo $__env->yieldPushContent('after_scripts_stack'); ?>
<?php echo $__env->yieldContent('after_scripts'); ?>
<?php echo $__env->yieldContent('captcha_footer'); ?>

<?php if(!empty($plugins)): ?>
	<?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $__env->yieldContent($plugin . '_scripts'); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(config('settings.footer.tracking_code')): ?>
	<?php echo printJs(config('settings.footer.tracking_code')) . "\n"; ?>

<?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/master.blade.php ENDPATH**/ ?>