<?php
	$countryCode ??= config('country.code');
	$countryCode = strtolower($countryCode);
	$adminType ??= 0;
	
	$apiResult ??= [];
	$admins = data_get($apiResult, 'data');
	$totalAdmins = (int)data_get($apiResult, 'meta.total', 0);
	$areAdminsPagingable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
	
	$languageCode ??= config('app.locale');
	$currSearch ??= [];
	$unWantedInputs ??= [];
	
	$queryArray = (is_array($currSearch)) ? $currSearch : [];
	$adminQueryArray = $queryArray;
	if (isset($adminQueryArray['distance'])) {
		unset($adminQueryArray['distance']);
	}
	$queryString = !empty($adminQueryArray) ? '?' . http_build_query($adminQueryArray) : '';
?>
<?php if(!empty($admins) && $totalAdmins > 0): ?>
	<?php
		$rowCols = ($adminType == 2) ? 'row-cols-lg-3 row-cols-md-2 row-cols-sm-1' : 'row-cols-lg-4 row-cols-md-3 row-cols-sm-2';
	?>
	<div class="row <?php echo e($rowCols); ?> row-cols-1">
		<?php
			$url = url('ajax/locations/' . $countryCode . '/cities');
			$url = $url . $queryString;
		?>
		<div class="col mb-1 list-link list-unstyled">
			<a href="" data-url="<?php echo e($url); ?>" class="is-admin">
				<?php echo e(t('all_cities', [], 'global', $languageCode)); ?>

			</a>
		</div>
		<?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				$url = url('ajax/locations/' . $countryCode . '/admins/' . $adminType . '/' . data_get($admin, 'code') . '/cities');
				$url = $url . $queryString;
				
				$admin1 = null;
				$adminName = data_get($admin, 'name');
				if ($adminType == 2) {
					$admin1 = data_get($admin, 'subAdmin1');
					$admin1Name = data_get($admin1, 'name');
					$fullAdminName = !empty($admin1Name) ? $adminName . ', ' . $admin1Name : $adminName;
				} else {
					$fullAdminName = $adminName;
				}
			?>
			<div class="col mb-1 list-link list-unstyled">
				<a href=""
				   data-url="<?php echo e($url); ?>"
				   class="is-admin"
				   data-bs-toggle="tooltip"
				   data-bs-custom-class="modal-tooltip"
				   title="<?php echo e($fullAdminName); ?>"
				>
					<?php echo e($fullAdminName); ?>

				</a>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
	<?php if($areAdminsPagingable): ?>
		<br>
		<?php echo $__env->make('vendor.pagination.api.ajax.bootstrap-4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php else: ?>
	<div class="row">
		<div class="col-12">
			<?php echo e(t('no_admin_divisions_found', [], 'global', $languageCode)); ?>

		</div>
	</div>
<?php endif; ?><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/modal/location/admins.blade.php ENDPATH**/ ?>