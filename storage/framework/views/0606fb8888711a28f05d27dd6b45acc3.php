
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h4 class="modal-title" id="errorModalTitle">
					Title
				</h4>
				
				<button type="button" class="close" data-bs-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div id="errorModalBody" class="col-12">
						Content...
					</div>
				</div>
			</div>
			
			<div class='modal-footer'>
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?php echo e(t('Close')); ?></button>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/layouts/inc/modal/error.blade.php ENDPATH**/ ?>