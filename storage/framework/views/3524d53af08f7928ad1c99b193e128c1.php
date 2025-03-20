<?php
	$city ??= null;
	$admin ??= null;
	
	$adminType = config('country.admin_type', 0);
	$adminCode = data_get($city, 'subadmin' . $adminType . '_code') ?? data_get($admin, 'code') ?? 0;
?>

<div class="modal fade" id="browseCategories" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title" id="categoriesModalLabel">
					<i class="far fa-map"></i> <?php echo e(t('select_a_category')); ?>

				</h4>
				
				<button type="button" class="close" data-bs-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-xl-12" id="selectCats"></div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<script>
		var editLabel = '<?php echo e(t('Edit')); ?>';
		
		
		var defaultAdminType = '<?php echo e($adminType); ?>';
		var defaultAdminCode = '<?php echo e($adminCode); ?>';
	</script>
<?php $__env->stopSection(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/createOrEdit/inc/category-modal.blade.php ENDPATH**/ ?>