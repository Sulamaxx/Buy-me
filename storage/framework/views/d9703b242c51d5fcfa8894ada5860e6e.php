<?php
	$countries ??= collect();
	$countryFlagShape = config('settings.localization.country_flag_shape');
?>

<div class="modal fade modalHasList" id="selectCountry" tabindex="-1" aria-labelledby="selectCountryLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title uppercase fw-bold" id="selectCountryLabel">
					<i class="far fa-map"></i> <?php echo e(t('select_country')); ?>

				</h4>
				
				<button type="button" class="close" data-bs-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2">
					
					<?php if($countries->isNotEmpty()): ?>
						<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col mb-1 cat-list">
								<?php
									$countryUrl = dmUrl($country, '/', true, !config('plugins.domainmapping.installed'));
									$countryName = $country->get('name');
									$countryNameLimited = str($countryName)->limit(21)->toString();
								?>
								<?php if($countryFlagShape == 'rectangle'): ?>
									<img src="<?php echo e(url('images/blank.webp') . getPictureVersion()); ?>"
										 class="flag flag-<?php echo e($country->get('icode')); ?>"
										 style="margin-bottom: 4px; margin-right: 5px;"
									     alt="<?php echo e($countryNameLimited); ?>"
									>
								<?php else: ?>
									<img src="<?php echo e($country->get('flag16_url')); ?>"
									     class=""
									     style="margin-bottom: 4px; margin-right: 5px;"
									     alt="<?php echo e($countryNameLimited); ?>"
									>
								<?php endif; ?>
								<a href="<?php echo e($countryUrl); ?>"
								   data-bs-toggle="tooltip"
								   data-bs-custom-class="modal-tooltip"
								   title="<?php echo e($countryName); ?>"
								>
									<?php echo e($countryNameLimited); ?>

								</a>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					
				</div>
			</div>
			
		</div>
	</div>
</div>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/modal/change-country.blade.php ENDPATH**/ ?>