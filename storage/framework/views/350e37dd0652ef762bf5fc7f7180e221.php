<?php echo $__env->make('common.css.skin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
/* === Body === */

<?php
// Logo Max Sizes
$logoMaxWidth = config('larapen.core.logoSize.max.width', 430);
$logoMaxHeight = config('larapen.core.logoSize.max.height', 80);
if (!empty(config('settings.style.header_height'))) {
	$logoMaxHeight = strToDigit(config('settings.style.header_height'), $logoMaxHeight);
}

// Logo Sizes
$logoWidth = strToDigit(config('settings.style.logo_width'), 108);
$logoHeight = strToDigit(config('settings.style.logo_height'), 20);
if (config('settings.style.logo_aspect_ratio')) {
	if ($logoHeight <= $logoWidth) {
		$logoWidth = 'auto';
		$logoHeight = $logoHeight . 'px';
	} else {
		$logoWidth = $logoWidth . 'px';
		$logoHeight = 'auto';
	}
} else {
	$logoWidth = $logoWidth . 'px';
	$logoHeight = $logoHeight . 'px';
}
?>
.main-logo {
	width: <?php echo e($logoWidth); ?>;
	height: <?php echo e($logoHeight); ?>;
	max-width: <?php echo e($logoMaxWidth); ?>px !important;
	max-height: <?php echo e($logoMaxHeight); ?>px !important;
}
<?php if(!empty(config('settings.style.page_width'))): ?>
	<?php $pageWidth = strToDigit(config('settings.style.page_width')) . 'px'; ?>
	@media (min-width: 1200px) {
		.container {
			max-width: <?php echo e($pageWidth); ?>;
		}
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.body_background_color')) || !empty(config('settings.style.body_text_color')) || !empty(config('settings.style.body_background_image'))): ?>
	body {
	<?php if(!empty(config('settings.style.body_background_color'))): ?>
		background-color: <?php echo e(config('settings.style.body_background_color')); ?>;
	<?php endif; ?>
	<?php if(!empty(config('settings.style.body_text_color'))): ?>
		color: <?php echo e(config('settings.style.body_text_color')); ?>;
	<?php endif; ?>
	<?php if(!empty(config('settings.style.body_background_image_url'))): ?>
		background-image: url(<?php echo e(config('settings.style.body_background_image_url')); ?>);
		background-repeat: repeat;
		<?php if(!empty(config('settings.style.body_background_image_fixed'))): ?>
			background-attachment: fixed;
		<?php endif; ?>
	<?php endif; ?>
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.body_background_color')) || !empty(config('settings.style.body_background_image'))): ?>
	#wrapper { background-color: rgba(0, 0, 0, 0); }
<?php endif; ?>
<?php if(!empty(config('settings.style.title_color'))): ?>
	.skin h1,
	.skin h2,
	.skin h3,
	.skin h4,
	.skin h5,
	.skin h6 {
		color: <?php echo e(config('settings.style.title_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.link_color'))): ?>
	.skin a,
	.skin .link-color {
		color: <?php echo e(config('settings.style.link_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.link_color_hover'))): ?>
	.skin a:hover,
	.skin a:focus {
		color: <?php echo e(config('settings.style.link_color_hover')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.progress_background_color'))): ?>
	.skin .pace .pace-progress {
		background: <?php echo e(config('settings.style.progress_background_color')); ?> none repeat scroll 0 0;
	}
<?php endif; ?>

/* === Header === */
<?php if(!empty(config('settings.style.header_sticky'))): ?>
	.navbar.navbar-site {
		position: fixed !important;
	}
<?php else: ?>
	.navbar.navbar-site {
		position: absolute !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_height'))): ?>
	<?php
	// Default values
	$defaultHeight = 80;
	$defaultPadding = 20;
	$defaultMargin = 0;
	
	// Get known value from Settings
	$headerHeight = strToDigit(config('settings.style.header_height'));
	
	$headerBottomBorderSize = 0;
	if (!empty(config('settings.style.header_bottom_border_width'))) {
		$headerBottomBorderSize = strToDigit(config('settings.style.header_bottom_border_width'));
	}
	$wrapperPaddingTop = $headerHeight + $headerBottomBorderSize;
	
	// Calculate unknown values
	$padding = floor(($headerHeight * $defaultPadding) / $defaultHeight);
	$margin = floor(($headerHeight * $defaultMargin) / $defaultHeight);
	$padding = abs(($padding - ($defaultPadding / 2)) * 2);
	$margin = abs(($margin - ($defaultMargin / 2)) * 2);
	
	$padding = $padding + 10;
	// $wrapperPaddingTop + 4 for default margin/padding values
	?>
	#wrapper {
		padding-top: <?php echo e(($wrapperPaddingTop + 4)); ?>px;
	}
	
	.navbar.navbar-site .navbar-identity .navbar-brand {
		height: <?php echo e($headerHeight); ?>px;
		padding-top: <?php echo e($padding + 10); ?>px;
		padding-bottom: <?php echo e($padding); ?>px;
	}
	
	@media (max-width: 767px) {
		#wrapper {
			padding-top: <?php echo e($wrapperPaddingTop); ?>px;
		}
		.navbar-site.navbar .navbar-identity {
			height: <?php echo e($headerHeight); ?>px;
		}
		.navbar-site.navbar .navbar-identity .btn,
		.navbar-site.navbar .navbar-identity .navbar-toggler {
			margin-top: <?php echo e($padding); ?>px;
		}
		.navbar.navbar-site .navbar-identity .navbar-brand {
		height: <?php echo e($headerHeight); ?>px;
		padding-top: <?php echo e($padding); ?>px;
		padding-bottom: <?php echo e($padding); ?>px;
	}
	}
	
	@media (max-width: 479px) {
		#wrapper {
			padding-top: <?php echo e($wrapperPaddingTop); ?>px;
		}
		.navbar-site.navbar .navbar-identity {
			height: <?php echo e($headerHeight); ?>px;
		}
	}
	
	@media (min-width: 768px) and (max-width: 992px) {
		.navbar.navbar-site .navbar-identity a.logo {
			height: <?php echo e($headerHeight); ?>px;
		}
		.navbar.navbar-site .navbar-identity a.logo-title {
			padding-top: <?php echo e($padding); ?>px;
		}
	}
	
	@media (min-width: 768px) {
		.navbar.navbar-site .navbar-identity {
			margin-top: <?php echo e($margin); ?>px;
		}
		.navbar.navbar-site .navbar-collapse {
			margin-top: <?php echo e($margin); ?>px;
		}
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_background_color'))): ?>
	.navbar.navbar-site {
		background-color: <?php echo e(config('settings.style.header_background_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_bottom_border_width'))): ?>
	<?php $headerBottomBorderSize = strToDigit(config('settings.style.header_bottom_border_width')) . 'px'; ?>
	.navbar.navbar-site {
		border-bottom-width: <?php echo e($headerBottomBorderSize); ?> !important;
		border-bottom-style: solid !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_bottom_border_color'))): ?>
	.navbar.navbar-site {
		border-bottom-color: <?php echo e(config('settings.style.header_bottom_border_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_link_color'))): ?>
	@media (min-width: 768px) {
		.navbar.navbar-site ul.navbar-nav > li > a {
			color: <?php echo e(config('settings.style.header_link_color')); ?> !important;
		}
	}
	
	.navbar.navbar-site ul.navbar-nav > .open > a,
	.navbar.navbar-site ul.navbar-nav > .open > a:focus,
	.navbar.navbar-site ul.navbar-nav > .open > a:hover {
		color: <?php echo e(config('settings.style.header_link_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.header_link_color_hover'))): ?>
	@media (min-width: 768px) {
		.navbar.navbar-site ul.navbar-nav > li > a:hover,
		.navbar.navbar-site ul.navbar-nav > li > a:focus {
			color: <?php echo e(config('settings.style.header_link_color_hover')); ?> !important;
		}
	}
<?php endif; ?>

/* === Footer === */
<?php if(!empty(config('settings.style.footer_background_color'))): ?>
	.footer-content {
		background: <?php echo e(config('settings.style.footer_background_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_text_color'))): ?>
	.footer-content {
		color: <?php echo e(config('settings.style.footer_text_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_title_color'))): ?>
	.footer-title {
		color: <?php echo e(config('settings.style.footer_title_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_link_color'))): ?>
	.footer-nav li a:not(.btn):not(.icon-color),
	.copy-info a {
		color: <?php echo e(config('settings.style.footer_link_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.footer_link_color_hover'))): ?>
	.skin .footer-nav li a:not(.btn):not(.icon-color):hover,
	.skin .footer-nav li a:not(.btn):not(.icon-color):focus,
	.copy-info a:focus,
	.copy-info a:hover {
		color: <?php echo e(config('settings.style.footer_link_color_hover')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_top_border_width'))): ?>
	<?php $paymentIconTopBorderSize = strToDigit(config('settings.style.payment_icon_top_border_width')) . 'px'; ?>
	.payment-method-logo {
		border-top-width: <?php echo e($paymentIconTopBorderSize); ?>;
	}
	.footer-content hr {
		border-top-width: <?php echo e($paymentIconTopBorderSize); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_top_border_color'))): ?>
	.payment-method-logo {
		border-top-color: <?php echo e(config('settings.style.payment_icon_top_border_color')); ?>;
	}
	.footer-content hr {
		border-top-color: <?php echo e(config('settings.style.payment_icon_top_border_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_bottom_border_width'))): ?>
	<?php $paymentIconBottomBorderSize = strToDigit(config('settings.style.payment_icon_bottom_border_width')) . 'px'; ?>
	.payment-method-logo {
		border-bottom-width: <?php echo e($paymentIconBottomBorderSize); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.payment_icon_bottom_border_color'))): ?>
	.payment-method-logo {
		border-bottom-color: <?php echo e(config('settings.style.payment_icon_bottom_border_color')); ?>;
	}
<?php endif; ?>

/* === Button: Add Listing === */
<?php if(!empty(config('settings.style.btn_listing_bg_top_color')) || !empty(config('settings.style.btn_listing_bg_bottom_color'))): ?>
	<?php
	$btnBackgroundTopColor = '#ffeb43';
	$btnBackgroundBottomColor = '#fcde11';
	if (!empty(config('settings.style.btn_listing_bg_top_color'))) {
		$btnBackgroundTopColor = config('settings.style.btn_listing_bg_top_color');
	}
	if (!empty(config('settings.style.btn_listing_bg_bottom_color'))) {
		$btnBackgroundBottomColor = config('settings.style.btn_listing_bg_bottom_color');
	}
	?>
	a.btn-listing,
	button.btn-listing,
	.navbar.navbar-site ul.navbar-nav > li.postadd > a.btn-listing,
	#homepage a.btn-listing {
		background-image: linear-gradient(to bottom, <?php echo e($btnBackgroundTopColor); ?> 0,<?php echo e($btnBackgroundBottomColor); ?> 100%);
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_border_color'))): ?>
	a.btn-listing,
	button.btn-listing,
	.navbar.navbar-site ul.navbar-nav > li.postadd > a.btn-listing,
	#homepage a.btn-listing {
		border-color: <?php echo e(config('settings.style.btn_listing_border_color')); ?>;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_text_color'))): ?>
	a.btn-listing,
	button.btn-listing,
	.navbar.navbar-site ul.navbar-nav > li.postadd > a.btn-listing,
	#homepage a.btn-listing {
		color: <?php echo e(config('settings.style.btn_listing_text_color')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_bg_top_color_hover')) || !empty(config('settings.style.btn_listing_bg_bottom_color_hover'))): ?>
	<?php
	$btnBackgroundTopColorHover = '#fff860';
	$btnBackgroundBottomColorHover = '#ffeb43';
	if (!empty(config('settings.style.btn_listing_bg_top_color_hover'))) {
		$btnBackgroundTopColorHover = config('settings.style.btn_listing_bg_top_color_hover');
	}
	if (!empty(config('settings.style.btn_listing_bg_bottom_color_hover'))) {
		$btnBackgroundBottomColorHover = config('settings.style.btn_listing_bg_bottom_color_hover');
	}
	?>
	a.btn-listing:hover,
	a.btn-listing:focus,
	button.btn-listing:hover,
	button.btn-listing:focus,
	li.postadd > a.btn-listing:hover,
	li.postadd > a.btn-listing:focus,
	#homepage a.btn-listing:hover,
	#homepage a.btn-listing:focus {
		background-image: linear-gradient(to bottom, <?php echo e($btnBackgroundTopColorHover); ?> 0,<?php echo e($btnBackgroundBottomColorHover); ?> 100%) !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_border_color_hover'))): ?>
	a.btn-listing:hover,
	a.btn-listing:focus,
	button.btn-listing:hover,
	button.btn-listing:focus,
	.navbar.navbar-site ul.navbar-nav > li.postadd > a.btn-listing:hover,
	.navbar.navbar-site ul.navbar-nav > li.postadd > a.btn-listing:focus,
	#homepage a.btn-listing:hover,
	#homepage a.btn-listing:focus {
		border-color: <?php echo e(config('settings.style.btn_listing_border_color_hover')); ?> !important;
	}
<?php endif; ?>
<?php if(!empty(config('settings.style.btn_listing_text_color_hover'))): ?>
	a.btn-listing:hover,
	a.btn-listing:focus,
	button.btn-listing:hover,
	button.btn-listing:focus,
	.navbar.navbar-site ul.navbar-nav > li.postadd > a.btn-listing:hover,
	.navbar.navbar-site ul.navbar-nav > li.postadd > a.btn-listing:focus,
	#homepage a.btn-listing:hover,
	#homepage a.btn-listing:focus {
		color: <?php echo e(config('settings.style.btn_listing_text_color_hover')); ?> !important;
	}
<?php endif; ?>

/* === Other: Grid View Columns === */
<?php if(!empty(config('settings.list.grid_view_cols'))): ?>
	<?php
	$gridViewCols = config('settings.list.grid_view_cols');
	$gridWidth = round_val(100 / $gridViewCols, 2);
	?>
	<?php if(config('lang.direction') == 'rtl'): ?>
		.make-grid .item-list {
			width: <?php echo e($gridWidth); ?>% !important;
		}
		@media (max-width: 767px) {
			.make-grid .item-list {
				width: 50% !important;
			}
		}
		
		/* Item Border */
		.posts-wrapper.make-grid .item-list:nth-child(4n+4),
		.category-list.make-grid .item-list:nth-child(4n+4) {
			border-left: solid 1px #ddd;
		}
		
		.posts-wrapper.make-grid .item-list:nth-child(3n+3),
		.category-list.make-grid .item-list:nth-child(3n+3) {
			border-left: solid 1px #ddd;
		}
		
		.posts-wrapper.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>),
		.category-list.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>) {
			border-left: none;
		}
		
		@media (max-width: 991px) {
			.posts-wrapper.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>),
			.category-list.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>) {
				border-left-style: solid;
				border-left-width: 1px;
				border-left-color: #ddd;
			}
		}
	<?php else: ?>
		.make-grid .item-list {
			width: <?php echo e($gridWidth); ?>% !important;
		}
		@media (max-width: 767px) {
			.make-grid .item-list {
				width: 50% !important;
			}
		}
		
		/* Item Border */
		.posts-wrapper.make-grid .item-list:nth-child(4n+4),
		.category-list.make-grid .item-list:nth-child(4n+4) {
			border-right: solid 1px #ddd;
		}
		
		.posts-wrapper.make-grid .item-list:nth-child(3n+3),
		.category-list.make-grid .item-list:nth-child(3n+3) {
			border-right: solid 1px #ddd;
		}
		
		.posts-wrapper.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>),
		.category-list.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>) {
			border-right: none;
		}
		
		@media (max-width: 991px) {
			.posts-wrapper.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>),
			.category-list.make-grid .item-list:nth-child(<?php echo e($gridViewCols); ?>n+<?php echo e($gridViewCols); ?>) {
				border-right-style: solid;
				border-right-width: 1px;
				border-right-color: #ddd;
			}
		}
	<?php endif; ?>
<?php endif; ?>
</style>

<style>
/* === CSS Fix === */
.f-category h6 {
	color: #333;
}
.photo-count {
	color: #292b2c;
}
.page-info-lite h5 {
	color: #999999;
}
h4.item-price {
	color: #292b2c;
}
h5.company-title a {
	color: #999;
}
</style>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/common/css/style.blade.php ENDPATH**/ ?>