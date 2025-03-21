<?php
// Clear Filter Button
$clearFilterBtn = \App\Helpers\UrlGen::getDateFilterClearLink($cat ?? null, $city ?? null);
?>

<div class="block-title has-arrow sidebar-header">
	<h5>
		<span class="fw-bold">
			<?php echo e(t('Date Posted')); ?>

		</span> <?php echo $clearFilterBtn; ?>

	</h5>
</div>
<div class="block-content list-filter">
	<div class="filter-date filter-content">
		<ul>
			<?php if(isset($periodList) && !empty($periodList)): ?>
				<?php $__currentLoopData = $periodList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<input type="radio"
							   name="postedDate"
							   value="<?php echo e($key); ?>"
							   id="postedDate_<?php echo e($key); ?>" <?php echo e((request()->query('postedDate')==$key) ? 'checked="checked"' : ''); ?>

						>
						<label for="postedDate_<?php echo e($key); ?>"><?php echo e($value); ?></label>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			<input type="hidden" id="postedQueryString" value="<?php echo e(\App\Helpers\Arr::query(request()->except(['page', 'postedDate']))); ?>">
		</ul>
	</div>
</div>
<div style="clear:both"></div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	
	<script>
		$(document).ready(function ()
		{
			$('input[type=radio][name=postedDate]').click(function() {
				let postedQueryString = $('#postedQueryString').val();
				
				if (postedQueryString !== '') {
					postedQueryString = postedQueryString + '&';
				}
				postedQueryString = postedQueryString + 'postedDate=' + $(this).val();
				
				let searchUrl = baseUrl + '?' + postedQueryString;
				redirect(searchUrl);
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/sidebar/date.blade.php ENDPATH**/ ?>