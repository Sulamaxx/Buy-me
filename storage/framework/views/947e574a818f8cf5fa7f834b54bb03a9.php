<?php
$isPriceFilterCanBeDisplayed = ((isset($cat) && !empty($cat)) && !in_array(data_get($cat, 'type'), ['not-salable']));

// Clear Filter Button
$clearFilterBtn = \App\Helpers\UrlGen::getPriceFilterClearLink($cat ?? null, $city ?? null);
?>
<?php if($isPriceFilterCanBeDisplayed): ?>
	
	<div class="block-title has-arrow sidebar-header">
		<h5>
			<span class="fw-bold">
				<?php echo e((!in_array(data_get($cat, 'type'), ['job-offer', 'job-search'])) ? t('price_range') : t('salary_range')); ?>

			</span> <?php echo $clearFilterBtn; ?>

		</h5>
	</div>
	<div class="block-content list-filter number-range-slider-wrapper">
<!--		<form role="form" class="form-inline" action="<?php echo e(request()->url()); ?>" method="GET">-->
			<?php $__currentLoopData = request()->except(['page', 'minPrice', 'maxPrice', '_token']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(is_array($value)): ?>
					<?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if(is_array($v)): ?>
							<?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ik => $iv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if(is_array($iv)) continue; ?>
								<input type="hidden" name="<?php echo e($key.'['.$k.']['.$ik.']'); ?>" value="<?php echo e($iv); ?>">
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php else: ?>
							<input type="hidden" name="<?php echo e($key.'['.$k.']'); ?>" value="<?php echo e($v); ?>">
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
					<input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<div class="row px-1 gx-1 gy-1">
				<div class="col-12 mb-3 number-range-slider" id="priceRangeSlider"></div>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<input type="number"
					       min="0"
					       id="minPrice"
					       name="minPrice"
					       class="form-control"
					       placeholder="<?php echo e(t('Min')); ?>"
					       value="<?php echo e(request()->query('minPrice')); ?>"
					>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<input type="number"
					       min="0"
					       id="maxPrice"
					       name="maxPrice"
					       class="form-control"
					       placeholder="<?php echo e(t('Max')); ?>"
					       value="<?php echo e(request()->query('maxPrice')); ?>"
					>
				</div>
                <br>
<br>
<br>
<hr />
				<div class="col-lg-12 col-md-12 col-sm-12">
					<button class="btn btn-success btn-block btn-sm-10 " type="submit"><?php echo e(t('go')); ?></button>
				</div>
			</div>
		</form>
	</div>
	<div style="clear:both"></div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	
	<?php if($isPriceFilterCanBeDisplayed): ?>
		<link href="<?php echo e(url('assets/plugins/noUiSlider/15.5.0/nouislider.css')); ?>" rel="stylesheet">
		<style>
			/* Hide Arrows From Input Number */
			/* Chrome, Safari, Edge, Opera */
			.number-range-slider-wrapper input::-webkit-outer-spin-button,
			.number-range-slider-wrapper input::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}
			/* Firefox */
			.number-range-slider-wrapper input[type=number] {
				-moz-appearance: textfield;
			}
		</style>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<?php if($isPriceFilterCanBeDisplayed): ?>
		<script src="<?php echo e(url('assets/plugins/noUiSlider/15.5.0/nouislider.js')); ?>"></script>
		<?php
			$minPrice = (int)config('settings.list.min_price', 0);
			$maxPrice = (int)config('settings.list.max_price', 10000);
			$priceSliderStep = (int)config('settings.list.price_slider_step', 50);
			
			$startPrice = (int)request()->query('minPrice', $minPrice);
			$endPrice = (int)request()->query('maxPrice', $maxPrice);
		?>
		<script>
			$(document).ready(function ()
			{
				let minPrice = <?php echo e($minPrice); ?>;
				let maxPrice = <?php echo e($maxPrice); ?>;
				let priceSliderStep = <?php echo e($priceSliderStep); ?>;
				
				
				let startPrice = <?php echo e($startPrice); ?>;
				let endPrice = <?php echo e($endPrice); ?>;
				
				let priceRangeSliderEl = document.getElementById('priceRangeSlider');
				noUiSlider.create(priceRangeSliderEl, {
					connect: true,
					start: [startPrice, endPrice],
					step: priceSliderStep,
					keyboardSupport: true,     			 /* Default true */
					keyboardDefaultStep: 5,    			 /* Default 10 */
					keyboardPageMultiplier: 5, 			 /* Default 5 */
					keyboardMultiplier: priceSliderStep, /* Default 1 */
					range: {
						'min': minPrice,
						'max': maxPrice
					}
				});
				
				let minPriceEl = document.getElementById('minPrice');
				let maxPriceEl = document.getElementById('maxPrice');
				
				priceRangeSliderEl.noUiSlider.on('update', function (values, handle) {
					let value = values[handle];
					
					if (handle) {
						maxPriceEl.value = Math.round(value);
					} else {
						minPriceEl.value = Math.round(value);
					}
				});
				minPriceEl.addEventListener('change', function () {
					priceRangeSliderEl.noUiSlider.set([this.value, null]);
				});
				maxPriceEl.addEventListener('change', function () {
					if (this.value <= maxPrice) {
						priceRangeSliderEl.noUiSlider.set([null, this.value]);
					}
				});
			});
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/sidebar/price.blade.php ENDPATH**/ ?>