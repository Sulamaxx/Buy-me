<?php
	$admin ??= null;
	$city ??= null;
	$cat ??= null;
	
	$cats ??= [];
	
	// Keywords
	$keywords = request()->query('q');
	$keywords = (is_string($keywords)) ? $keywords : null;
	$keywords = rawurldecode($keywords);
	
	// Category
	$qCategory = request()->query('c');
	$qCategory = (is_numeric($qCategory) || is_string($qCategory)) ? $qCategory : null;
	$qCategory = data_get($cat, 'id', $qCategory);
	
	// Location
	$qLocationId = 0;
	$qAdminName = null;
	if (!empty($city)) {
		$qLocationId = data_get($city, 'id') ?? 0;
		$qLocation = data_get($city, 'name');
	} else {
		$qLocationId = request()->query('l');
		$qLocation = request()->query('location');
		$qAdminName = request()->query('r');
		
		$qLocationId = (is_numeric($qLocationId)) ? $qLocationId : null;
		$qLocation = (is_string($qLocation)) ? $qLocation : null;
		$qAdminName = (is_string($qAdminName)) ? $qAdminName : null;
		
		if (!empty($qAdminName)) {
			$qAdminName = data_get($admin, 'name', $qAdminName);
			$isAdminCode = (bool)preg_match('#^[a-z]{2}\.(.+)$#i', $qAdminName);
			$qLocation = !$isAdminCode ? t('area') . rawurldecode($qAdminName) : null;
		}
	}
	
	// FilterBy
	$qFilterBy = request()->query('filterBy');
	$qFilterBy = (is_string($qFilterBy)) ? $qFilterBy : null;
	
	 
	
	$displayStatesSearchTip = config('settings.list.display_states_search_tip');
?>
<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container mb-2 serp-search-bar">
	<form   id="search" name="search" action="<?php echo e(\App\Helpers\UrlGen::searchWithoutQuery()); ?>" method="GET">
		<?php if(!empty($qFilterBy)): ?>
			<input type="hidden" name="filterBy" value="<?php echo e($qFilterBy); ?>">
		<?php endif; ?>
		<div class="row m-0">
			<div class="col-12 px-1 py-sm-1 bg-primary rounded">
				<div class="row gx-1 gy-1">
			
					<div class="col-xl-3 col-md-3 col-sm-12 col-12">
						<select name="c" id="catSearch" class="form-control selecter">
							<option value="" <?php echo e(($qCategory=='') ? 'selected="selected"' : ''); ?>>
								<?php echo e(t('all_categories')); ?>

							</option>
							<?php if(!empty($cats)): ?>
								<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e(data_get($itemCat, 'id')); ?>" <?php if($qCategory == data_get($itemCat, 'id')): echo 'selected'; endif; ?>>
										<?php echo e(data_get($itemCat, 'name')); ?>

									</option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
					
					<div class="col-xl-4 col-md-4 col-sm-12 col-12">
						<input name="q" class="form-control keyword" type="text" placeholder="<?php echo e(t('what')); ?>" value="<?php echo e($keywords); ?>">
					</div>
					
					<input type="hidden" id="rSearch" name="r" value="<?php echo e($qAdminName); ?>">
					<input type="hidden" id="lSearch" name="l" value="<?php echo e($qLocationId); ?>">
					
					<div class="col-xl-3 col-md-3 col-sm-12 col-12 search-col locationicon">
						<?php if($displayStatesSearchTip): ?>
							<input class="form-control locinput input-rel searchtag-input"
								   type="text"
								   id="locSearch"
								   name="location"
								   placeholder="<?php echo e(t('where')); ?>"
								   value="<?php echo e($qLocation); ?>"
								   data-bs-placement="top"
								   data-bs-toggle="tooltipHover"
								   title="<?php echo e(t('Enter a city name OR a state name with the prefix')); ?>"
							>
						<?php else: ?>
							<input class="form-control locinput input-rel searchtag-input"
								   type="text"
								   id="locSearch"
								   name="location"
								   placeholder="<?php echo e(t('where')); ?>"
								   value="<?php echo e($qLocation); ?>"
							>
						<?php endif; ?>
					</div>
					
					<div class="col-xl-2 col-md-2 col-sm-12 col-12">
						<button class="btn btn-block btn-primary " style="width: 100px;">
							<i class="fa fa-search"></i> <strong><?php echo e(t('find')); ?></strong>
						</button>
					</div>
		
				</div>
			</div>
		</div>
	</form>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		$(document).ready(function () {
			$('#locSearch').on('change', function () {
				if ($(this).val() == '') {
					$('#lSearch').val('');
					$('#rSearch').val('');
				}
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/form.blade.php ENDPATH**/ ?>