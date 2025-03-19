<?php
	$titleSlug ??= '';
?>

<div id="picturesCarouselIndicators" class="gallery-container carousel carousel-dark slide" data-bs-ride="carousel">
	<div class="carousel-indicators">
		<?php $__empty_1 = true; $__currentLoopData = $pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
			<?php
				$activeSlideAttr = '';
				if ($loop->first) {
					$activeSlideAttr = ' class="active" aria-current="true"';
				}
			?>
			<button type="button"
					data-bs-target="#picturesCarouselIndicators"
					data-bs-slide-to="<?php echo e($key); ?>"<?php echo $activeSlideAttr; ?>

					aria-label="Picture <?php echo e($key); ?>"
			></button>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
			<button type="button"
					data-bs-target="#picturesCarouselIndicators"
					data-bs-slide-to="<?php echo e($key); ?>"
					class="active"
					aria-current="true"
					aria-label="Picture <?php echo e($key); ?>"
			></button>
		<?php endif; ?>
	</div>
	<?php if(!empty($price)): ?>
		<div class="p-price-tag"><?php echo $price; ?></div>
	<?php endif; ?>
	<div class="carousel-inner">
		<?php $__empty_1 = true; $__currentLoopData = $pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
			<?php
				$activeItemClass = '';
				if ($loop->first) {
					$activeItemClass = ' active';
				}
			?>
			<div class="carousel-item<?php echo e($activeItemClass); ?>">
				<?php
					$picAttr = [
						'alt'   => $titleSlug . '-big-' . $key,
						'class' => 'd-block',
					];
				?>
				<?php echo imgTag(data_get($image, 'filename'), 'big', $picAttr); ?>

			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
			<div class="carousel-item active">
				<img src="<?php echo e(imgUrl(config('larapen.core.picture.default'), 'big')); ?>" alt="img" class="d-block w-100 default-picture">
			</div>
		<?php endif; ?>
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#picturesCarouselIndicators" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden"><?php echo e(t('Previous')); ?></span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#picturesCarouselIndicators" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden"><?php echo e(t('Next')); ?></span>
	</button>
</div>

<?php $__env->startSection('after_styles'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_styles'); ?>
	<style>
		.gallery-container {
			display: block;
			width: 100%;
			height: auto;
			position: relative;
		}
		
		.carousel-inner {
			width: 100%;
			height: 100%;
			margin-left: auto;
			margin-right: auto;
			
			/* Apply shadow for the main gallery */
			-moz-box-shadow: 0 0 5px #ccc;
			-webkit-box-shadow: 0 0 5px #ccc;
			box-shadow: 0 0 5px #ccc;
			border: 5px solid #fff;
			background: #fff;
			border-radius: 6px;
			
			/* Bottom spacer */
			margin-bottom: 10px;
		}
		
		.carousel-inner img {
			margin: auto;
			border-radius: 6px;
			cursor: pointer;
		}
	</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		$(document).ready(function () {
			
			let picturesCarouselIndicatorsEl = document.querySelector('#picturesCarouselIndicators');
			let carousel = new bootstrap.Carousel(picturesCarouselIndicatorsEl, {
				interval: false,
				ride: false
			});
			
			/* Full Size Images Gallery */
			$(document).on('mousedown', '.carousel-item img', function (e) {
				e.preventDefault();
				
				let currentSrc = $(this).attr('src');
				let imgTitle = "<?php echo e(data_get($post, 'title')); ?>";
				
				let wrapperSelector = '.carousel-item img:not(.default-picture)';
				let imgSrcArray = getFullSizeSrcOfAllImg(wrapperSelector, currentSrc);
				if (imgSrcArray === undefined || imgSrcArray.length === 0) {
					return false;
				}
				
				
				let swipeboxItems = formatImgSrcArrayForSwipebox(imgSrcArray, imgTitle);
				let swipeboxOptions = {
					hideBarsDelay: (1000 * 60 * 5),
					loopAtEnd: false
				};
				$.swipebox(swipeboxItems, swipeboxOptions);
			});
			
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/post/show/inc/pictures-slider/bootstrap-carousel.blade.php ENDPATH**/ ?>