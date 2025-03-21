<?php
// Clear Filter Button
$clearFilterBtn = \App\Helpers\UrlGen::getCityFilterClearLink($cat ?? null, $city ?? null);
?>
<?php
/*
 * Check if the City Model exists in the Cities eloquent collection
 * If it doesn't exist in the collection,
 * Then, add it into the Cities eloquent collection
 */
if (isset($cities, $city) && !collect($cities)->contains($city)) {
	collect($cities)->push($city)->toArray();
}
?>

<div class="block-title has-arrow sidebar-header">
	<h5>
		<span class="fw-bold">
			<?php echo e(t('locations')); ?>

		</span> <?php echo $clearFilterBtn; ?>

	</h5>
</div>
<div class="block-content list-filter locations-list">
	<ul class="browse-list list-unstyled long-list">
		<?php if(isset($cities) && !empty($cities)): ?>
			<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li>
					<?php if(
						(
							isset($city)
							&& data_get($city, 'id') == data_get($iCity, 'id')
						)
						|| request()->input('l') == data_get($iCity, 'id')
						): ?>
						<strong>
							<a href="<?php echo \App\Helpers\UrlGen::city($iCity, null, $cat ?? null); ?>" title="<?php echo e(data_get($iCity, 'name')); ?>">
								<?php echo e(data_get($iCity, 'name')); ?>

								<?php if(config('settings.list.count_cities_listings')): ?>
									<span class="count">&nbsp;<?php echo e(data_get($iCity, 'posts_count') ?? 0); ?></span>
								<?php endif; ?>
							</a>
						</strong>
					<?php else: ?>
						<a href="<?php echo \App\Helpers\UrlGen::city($iCity, null, $cat ?? null); ?>" title="<?php echo e(data_get($iCity, 'name')); ?>">
							<?php echo e(data_get($iCity, 'name')); ?>

							<?php if(config('settings.list.count_cities_listings')): ?>
								<span class="count">&nbsp;<?php echo e(data_get($iCity, 'posts_count') ?? 0); ?></span>
							<?php endif; ?>
						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</ul>
</div>
<div style="clear:both"></div><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/sidebar/cities.blade.php ENDPATH**/ ?>