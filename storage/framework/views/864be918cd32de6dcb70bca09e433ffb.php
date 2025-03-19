<?php
	$widget ??= [];
	$posts = (array)data_get($widget, 'posts');
	$totalPosts = (int)data_get($widget, 'totalPosts', 0);
	
	$sectionOptions ??= [];
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';
	$carouselEl = '_' . createRandomString(6);
	
	$isFromHome ??= false;
?>
<?php if($totalPosts > 0): ?>
	<?php if($isFromHome): ?>
		<?php echo $__env->first([
			config('larapen.core.customizedViewPath') . 'home.inc.spacer',
			'home.inc.spacer'
		], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php
//  print_r($widget)  ;
//exit;
?>
	<div class="container<?php echo e($isFromHome ? '' : ' my-3'); ?><?php echo e($hideOnMobile); ?>">
		<div class="col-xl-12 content-box layout-section">
			<div class="row row-featured row-featured-category">
				<div class="col-xl-12 box-title">
					<div class="inner">
						<h2>
							<span class="title-3"><?php echo data_get($widget, 'title'); ?></span>
							<a href="<?php echo e(data_get($widget, 'link')); ?>" class="sell-your-item">
								<?php echo e(t('View more')); ?> <i class="fas fa-bars"></i>
							</a>
						</h2>
					</div>
				</div>
		
				<div style="clear: both"></div>
		
				<div class="relative content featured-list-row clearfix">
					
					<div class="large-12 columns">
						<div class="no-margin featured-list-slider <?php echo e($carouselEl); ?> owl-carousel owl-theme">
							<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="item">
									<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>">
										<span class="item-carousel-thumb">
											<span class="photo-count">
												<i class="fa fa-camera"></i> <?php echo e(data_get($post, 'count_pictures')); ?>

											</span>
											<?php
												echo imgTag(data_get($post, 'picture.filename'), 'medium', [
														'style' => 'border: 1px solid #e7e7e7; margin-top: 2px;',
														'alt'   => data_get($post, 'title')
													]);
											?>
										</span>
										<span class="item-name"><?php echo e(str(data_get($post, 'title'))->limit(70)); ?></span>
										
										<?php if(config('plugins.reviews.installed')): ?>
											<?php if(view()->exists('reviews::ratings-list')): ?>
												<?php echo $__env->make('reviews::ratings-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
											<?php endif; ?>
										<?php endif; ?>
										
										<span class="price">
											<?php echo data_get($post, 'price_formatted'); ?>

										</span>
									</a>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
		
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $__env->startSection('after_style'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		
		let rtlIsEnabled = false;
		if ($('html').attr('dir') === 'rtl') {
			rtlIsEnabled = true;
		}
		
		
		let carouselItems = <?php echo e($totalPosts ?? 0); ?>;
		let carouselAutoplay = <?php echo e(data_get($sectionOptions, 'autoplay') ?? 'true'); ?>;
		let carouselAutoplayTimeout = <?php echo e((int)(data_get($sectionOptions, 'autoplay_timeout') ?? 1500)); ?>;
		let carouselLang = {
			'navText': {
				'prev': "<?php echo e(t('prev')); ?>",
				'next': "<?php echo e(t('next')); ?>"
			}
		};
		
		
		let carouselObject = $('.featured-list-slider.<?php echo e($carouselEl); ?>');
		let responsiveObject = {
			0: {
				items: 1,
				nav: true
			},
			576: {
				items: 2,
				nav: false
			},
			768: {
				items: 3,
				nav: false
			},
			992: {
				items: 5,
				nav: false,
				loop: (carouselItems > 5)
			}
		};
		carouselObject.owlCarousel({
			rtl: rtlIsEnabled,
			nav: false,
			navText: [carouselLang.navText.prev, carouselLang.navText.next],
			loop: true,
			responsiveClass: true,
			responsive: responsiveObject,
			autoWidth: true,
			autoplay: carouselAutoplay,
			autoplayTimeout: carouselAutoplayTimeout,
			autoplayHoverPause: true
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/search/inc/posts/widget/carousel.blade.php ENDPATH**/ ?>