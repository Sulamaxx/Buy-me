<?php
	$admin ??= null;
	$city ??= null;
	
	$adminType = config('country.admin_type', 0);
	$relAdminType = (in_array($adminType, ['1', '2'])) ? $adminType : 1;
	$adminCode = data_get($city, 'subadmin' . $relAdminType . '_code') ?? data_get($admin, 'code') ?? 0;
	
	$inputs = request()->all();
	$currSearch = base64_encode(serialize($inputs));
?>

<div class="modal fade" id="browseLocations" tabindex="-1" aria-labelledby="browseLocationsLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title" id="browseLocationsLabel">
					<i class="far fa-map"></i> <?php echo e(t('select_a_location')); ?>

				</h4>
				
				<button type="button" class="close" data-bs-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div id="locationsTitle" style="height: 40px;" class="align-middle">
							<?php echo t('locations_in_country', ['country' => config('country.name')]); ?>

						</div>
						<div style="clear:both"></div>
						
						<div class="col-12 no-padding">
							<form id="locationsModalForm" method="POST">
								<input type="hidden" id="modalCountryChanged" name="country_changed" value="0">
								<input type="hidden" id="modalTriggerName" name="trigger_name" value="">
								<input type="hidden" id="modalUrl" name="url" value="">
								<input type="hidden" id="modalAdminType" name="admin_type" value="<?php echo e($adminType); ?>">
								<input type="hidden" id="modalAdminCode" name="admin_code" value="">
								<input type="hidden" id="currSearch" name="curr_search" value="<?php echo $currSearch; ?>">
								
								<div class="row g-3">
									<div class="col-sm-12 col-md-11 col-lg-10">
										<div class="input-group position-relative d-inline-flex align-items-center">
											<input type="text"
												   id="modalQuery"
												   name="query"
												   class="form-control input-md"
												   placeholder="<?php echo e(t('search_a_location')); ?>"
												   aria-label="<?php echo e(t('search_a_location')); ?>"
												   value=""
												   autocomplete="off"
											>
											<span class="input-group-text">
												<i id="modalQueryClearBtn" class="bi bi-x-lg" style="cursor: pointer;"></i>
											</span>
										</div>
									</div>
									<div class="col-sm-12 col-md-3 col-lg-2">
										<button id="modalQuerySearchBtn" class="btn btn-primary btn-block btn-sm-1"> <?php echo e(t('find')); ?> </button>
									</div>
								</div>
								
								<?php echo csrf_field(); ?>

							</form>
						</div>
						<div style="clear:both"></div>
						
						<hr class="border-0 bg-secondary">
					</div>
					<div class="col-12" id="locationsList"></div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		
		var defaultAdminType = '<?php echo e($adminType); ?>';
		var defaultAdminCode = '<?php echo e($adminCode); ?>';
	</script>
	<script src="<?php echo e(url('assets/js/app/browse.locations.js') . vTime()); ?>"></script>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/layouts/inc/modal/location.blade.php ENDPATH**/ ?>