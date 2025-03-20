<?php
	$currDisplay = config('settings.list.display_mode');
	$typeOfDisplay = [
		'list'    => 'make-list',
		'compact' => 'make-compact',
		'grid'    => 'make-grid',
	];
	// '$display' var is sent from the FileController file through view(...)->render()
	if (isset($display) && !empty($display) && isset($typeOfDisplay[$display])) {
		$currDisplay = $typeOfDisplay[$display];
	}
	
	// Default ribbons positions (related to the page size)
	// https://getbootstrap.com/docs/5.0/layout/breakpoints/

	$rBorderWidth = 12;
	$rWidth = 140;
	$rLeft = 0;
	$rTop = 30;
	$rsFontSize = 11;
	$rsPaddingStart = 10;
	$rsTop = 0;
	
	if (config('settings.list.left_sidebar')) {
		// xxl (>=1400px)
		$rWidthXxl = 140;
		$rsFontSizeXxl = 11;
		
		// xl (>=1200px)
		$rWidthXl = 120;
		$rsFontSizeXl = 11;
		
		// lg (>=992px)
		$rWidthLg = 100;
		$rsFontSizeLg = 10;
		
		// md (>=768px)
		$rWidthMd = 80;
		$rsFontSizeMd = 9;
		$rsTopMd = -1;
		$rsPaddingStartMd = 5;
		
		// sm (>=576px)
		$rWidthSm = 140;
		$rsFontSizeSm = 9;
		$rsTopSm = -1;
		$rsPaddingStartSm = 5;
		
		// xs (<576px)
		$rWidthXs = 180;
		$rsFontSizeXs = 12;
	} else {
		// xxl (>=1400px)
		$rWidthXxl = 160;
		$rsFontSizeXxl = 11;
		
		// xl (>=1200px)
		$rWidthXl = 120;
		$rsFontSizeXl = 11;
		
		// lg (>=992px)
		$rWidthLg = 100;
		$rsFontSizeLg = 10;
		
		// md (>=768px)
		$rWidthMd = 80;
		$rsFontSizeMd = 9;
		$rsTopMd = -1;
		
		// sm (>=576px)
		$rWidthSm = 140;
		$rsFontSizeSm = 9;
		$rsTopSm = -1;
		
		// xs (<576px)
		$rWidthXs = 180;
		$rsFontSizeXs = 11;
	}

	if (in_array($currDisplay, ['make-list', 'make-compact'])) {
		if (config('settings.list.left_sidebar')) {
			$rWidth = $rWidthXxl = 100;
		} else {
			$rWidth = $rWidthXxl = 140;
		}
		$rWidthLg = 90;
		$rWidthMd = 60;
		$rWidthSm = 60;
		$rWidthXs = 250;
		
		$rsFontSizeLg = $rsFontSizeXs = 9;
		$rsTop = -1;
		
		$rsPaddingStart = 5;
		if ($currDisplay == 'make-compact') {
			$rWidthXxl = 130;
			$rWidthXl = 130;
			$rWidthLg = 120;
			$rWidthMd = 100;
			$rWidthSm = 100;
			
			$rBorderWidth = 8;
			
			$rTop = $rTopXs = 0;
			
			$rsFontSize = $rsFontSizeXxl = $rsFontSizeXl = 9;
		}
	} else {
		$gridViewCols = config('settings.list.grid_view_cols');
		
		$rWidthXs = 120;
		$rsFontSizeXs = 10;
		
		if (config('settings.list.left_sidebar')) {
			$rBorderWidth = 10;
			if ($gridViewCols == 4) {
				$rWidth = $rWidthXxl = 120;
				$rsFontSizeXs = 9;
				$rsTop = -1;
			}
			if ($gridViewCols == 3) {
				$rsFontSizeXs = 9;
				$rsTop = -1;
			}
		}
	}
?>
<style>
	
	/* Ribbons: Media Screen - Dynamic */
	@media (min-width: 1400px) {
		.item-list .ribbon-horizontal {
			width: <?php echo e($rWidthXxl ?? $rWidth); ?>px !important;
			<?php if(config('lang.direction') == 'rtl'): ?>
				right: <?php echo e($rLeftXxl ?? $rLeft); ?>px !important;
			<?php else: ?>
				left: <?php echo e($rLeftXxl ?? $rLeft); ?>px !important;
			<?php endif; ?>
			top: <?php echo e($rTopXxl ?? $rTop); ?>px !important;
			border-width: <?php echo e($rBorderWidthXxl ?? $rBorderWidth); ?>px;
		}
		.ribbon-horizontal span {
			font-size: <?php echo e($rsFontSizeXxl ?? $rsFontSize); ?>px;
			<?php if(config('lang.direction') == 'rtl'): ?>
				padding-right: <?php echo e($rsPaddingStartXxl ?? $rsPaddingStart); ?>px;
			<?php else: ?>
				padding-left: <?php echo e($rsPaddingStartXxl ?? $rsPaddingStart); ?>px;
			<?php endif; ?>
			top: <?php echo e($rsTopXxl ?? $rsTop); ?>px !important;
		}
	}
	@media (min-width: 1200px) and (max-width: 1399px) {
		.item-list .ribbon-horizontal {
			width: <?php echo e($rWidthXl ?? $rWidth); ?>px !important;
			<?php if(config('lang.direction') == 'rtl'): ?>
				right: <?php echo e($rLeftXl ?? $rLeft); ?>px !important;
			<?php else: ?>
				left: <?php echo e($rLeftXl ?? $rLeft); ?>px !important;
			<?php endif; ?>
			top: <?php echo e($rTopXl ?? $rTop); ?>px !important;
			border-width: <?php echo e($rBorderWidthXl ?? $rBorderWidth); ?>px;
		}
		.ribbon-horizontal span {
			font-size: <?php echo e($rsFontSizeXl ?? $rsFontSize); ?>px;
			<?php if(config('lang.direction') == 'rtl'): ?>
				padding-right: <?php echo e($rsPaddingStartXl ?? $rsPaddingStart); ?>px;
			<?php else: ?>
				padding-left: <?php echo e($rsPaddingStartXl ?? $rsPaddingStart); ?>px;
			<?php endif; ?>
			top: <?php echo e($rsTopXl ?? $rsTop); ?>px !important;
		}
	}
	@media (min-width: 992px) and (max-width: 1199px) {
		.item-list .ribbon-horizontal {
			width: <?php echo e($rWidthLg ?? $rWidth); ?>px !important;
			<?php if(config('lang.direction') == 'rtl'): ?>
				right: <?php echo e($rLeftLg ?? $rLeft); ?>px !important;
			<?php else: ?>
				left: <?php echo e($rLeftLg ?? $rLeft); ?>px !important;
			<?php endif; ?>
			top: <?php echo e($rTopLg ?? $rTop); ?>px !important;
			border-width: <?php echo e($rBorderWidthLg ?? $rBorderWidth); ?>px;
		}
		.ribbon-horizontal span {
			font-size: <?php echo e($rsFontSizeLg ?? $rsFontSize); ?>px;
			<?php if(config('lang.direction') == 'rtl'): ?>
				padding-right: <?php echo e($rsPaddingStartLg ?? $rsPaddingStart); ?>px;
			<?php else: ?>
				padding-left: <?php echo e($rsPaddingStartLg ?? $rsPaddingStart); ?>px;
			<?php endif; ?>
			top: <?php echo e($rsTopLg ?? $rsTop); ?>px !important;
		}
	}
	@media (min-width: 768px) and (max-width: 991px) {
		.item-list .ribbon-horizontal {
			width: <?php echo e($rWidthMd ?? $rWidth); ?>px !important;
			<?php if(config('lang.direction') == 'rtl'): ?>
				right: <?php echo e($rLeftMd ?? $rLeft); ?>px !important;
			<?php else: ?>
				left: <?php echo e($rLeftMd ?? $rLeft); ?>px !important;
			<?php endif; ?>
			top: <?php echo e($rTopMd ?? $rTop); ?>px !important;
			border-width: <?php echo e($rBorderWidthMd ?? $rBorderWidth); ?>px;
		}
		.ribbon-horizontal span {
			font-size: <?php echo e($rsFontSizeMd ?? $rsFontSize); ?>px;
			<?php if(config('lang.direction') == 'rtl'): ?>
				padding-right: <?php echo e($rsPaddingStartMd ?? $rsPaddingStart); ?>px;
			<?php else: ?>
				padding-left: <?php echo e($rsPaddingStartMd ?? $rsPaddingStart); ?>px;
			<?php endif; ?>
			top: <?php echo e($rsTopMd ?? $rsTop); ?>px !important;
		}
	}
	@media (min-width: 576px) and (max-width: 767px) {
		.item-list .ribbon-horizontal {
			width: <?php echo e($rWidthSm ?? $rWidth); ?>px !important;
			<?php if(config('lang.direction') == 'rtl'): ?>
				right: <?php echo e($rLeftSm ?? $rLeft); ?>px !important;
			<?php else: ?>
				left: <?php echo e($rLeftSm ?? $rLeft); ?>px !important;
			<?php endif; ?>
			top: <?php echo e($rTopSm ?? $rTop); ?>px !important;
			border-width: <?php echo e($rBorderWidthSm ?? $rBorderWidth); ?>px;
		}
		.ribbon-horizontal span {
			font-size: <?php echo e($rsFontSizeSm ?? $rsFontSize); ?>px;
			<?php if(config('lang.direction') == 'rtl'): ?>
				padding-right: <?php echo e($rsPaddingStartSm ?? $rsPaddingStart); ?>px;
			<?php else: ?>
				padding-left: <?php echo e($rsPaddingStartSm ?? $rsPaddingStart); ?>px;
			<?php endif; ?>
			top: <?php echo e($rsTopSm ?? $rsTop); ?>px !important;
		}
	}
	@media (max-width: 575px) {
		.item-list .ribbon-horizontal {
			width: <?php echo e($rWidthXs ?? $rWidth); ?>px !important;
			<?php if(config('lang.direction') == 'rtl'): ?>
				right: <?php echo e($rLeftXs ?? $rLeft); ?>px !important;
			<?php else: ?>
				left: <?php echo e($rLeftXs ?? $rLeft); ?>px !important;
			<?php endif; ?>
			top: <?php echo e($rTopXs ?? $rTop); ?>px !important;
			border-width: <?php echo e($rBorderWidthXs ?? $rBorderWidth); ?>px;
		}
		.ribbon-horizontal span {
			font-size: <?php echo e($rsFontSizeXs ?? $rsFontSize); ?>px;
			<?php if(config('lang.direction') == 'rtl'): ?>
				padding-right: <?php echo e($rsPaddingStartXs ?? $rsPaddingStart); ?>px;
			<?php else: ?>
				padding-left: <?php echo e($rsPaddingStartXs ?? $rsPaddingStart); ?>px;
			<?php endif; ?>
			top: <?php echo e($rsTopXs ?? $rsTop); ?>px !important;
		}
	}

</style><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/common/css/ribbons.blade.php ENDPATH**/ ?>