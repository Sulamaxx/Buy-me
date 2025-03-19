<?php
	$countryCode ??= config('country.code');
	$countryCode = strtolower($countryCode);
	$adminType ??= 0;
	$adminType = !empty($adminType) ? $adminType : config('country.admin_type', 0);
	$relAdminType = (in_array($adminType, ['1', '2'])) ? $adminType : 1;
	$selectedAdminCode = $adminCode ?? 0;
	
	$apiResult ??= [];
	$cities = data_get($apiResult, 'data');
	$totalCities = (int)data_get($apiResult, 'meta.total', 0);
	$areCitiesPagingable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
	$admin ??= null;
	
	$languageCode ??= config('app.locale');
	$currSearch ??= [];
	$unWantedInputs ??= [];
	$cityId ??= 0;
	
	$queryArray = (is_array($currSearch)) ? $currSearch : [];
	$cityQueryArray = $queryArray;
?>
<?php if(!empty($cities) && $totalCities > 0): ?>
	<?php
		$rowCols = (empty($admin) && $adminType == 2) ? 'row-cols-lg-2 row-cols-md-2 row-cols-sm-1' : 'row-cols-lg-4 row-cols-md-3 row-cols-sm-2';
	?>
	<div class="row <?php echo e($rowCols); ?> row-cols-1">
		<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				$relAdmin = data_get($city, 'subAdmin' . $relAdminType);
				$adminCode = data_get($relAdmin, 'code');
				$adminCode = (!empty($adminCode)) ? $adminCode : $selectedAdminCode;
				$adminName = data_get($relAdmin, 'name');
				if ($adminType == 2) {
					$relAdmin1 = data_get($city, 'subAdmin1');
					$admin1Name = data_get($relAdmin1, 'name');
					$adminName = !empty($adminName)
						? (!empty($admin1Name) ? $adminName . ', ' . $admin1Name : $adminName)
						: (!empty($admin1Name) ? $admin1Name : null);
				}
				
				$cityName = data_get($city, 'name');
				$fullCityName = !empty($adminName) ? $cityName . ', ' . $adminName : $cityName;
				$displayedCityName = str($cityName)->limit(25);
			?>
			<div class="col mb-1 list-link list-unstyled">
				<?php if(data_get($city, 'id') == $cityId): ?>
					<strong data-bs-toggle="tooltip" data-bs-custom-class="modal-tooltip" title="<?php echo e($fullCityName); ?>">
						<?php echo e(!empty($admin) ? $displayedCityName : $fullCityName); ?>

					</strong>
				<?php else: ?>
					<?php
						$cityQueryArray = array_merge($cityQueryArray, ['l' => data_get($city, 'id')]);
					?>
					<a href="<?php echo e(\App\Helpers\UrlGen::search($cityQueryArray, $unWantedInputs)); ?>"
					   data-bs-toggle="tooltip"
					   data-bs-custom-class="modal-tooltip"
					   title="<?php echo e($fullCityName); ?>"
					   data-admin-type="<?php echo e($adminType); ?>"
					   data-admin-code="<?php echo e($adminCode); ?>"
					   class="is-city"
					   data-id="<?php echo e(data_get($city, 'id')); ?>"
					   data-name="<?php echo e($fullCityName); ?>"
					>
						<?php echo e(!empty($admin) ? $displayedCityName : $fullCityName); ?>

					</a>
				<?php endif; ?>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
	<?php if($areCitiesPagingable): ?>
		<br>
		<?php echo $__env->make('vendor.pagination.api.ajax.bootstrap-4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php else: ?>
	<div class="row">
		<div class="col-12">
			<?php if(!empty(data_get($admin, 'code'))): ?>
				<?php echo e(t('no_cities_found', [], 'global', $languageCode)); ?>

			<?php else: ?>
				<?php echo e(t('admin_division_not_found', [], 'global', $languageCode)); ?>

			<?php endif; ?>
		</div>
	</div>
<?php endif; ?><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/modal/location/cities.blade.php ENDPATH**/ ?>