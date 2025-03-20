<div class="modal fade" id="securityTips" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			
			<div class="modal-header px-3">
				<h5 class="modal-title fw-bold" id="securityTipsLabel"><?php echo e(t('phone_number')); ?></h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<?php
				$phoneModal = '';
				$phoneModalLink = '';
				// If the 'hide_phone_number' option is disabled, append phone number in modal
				if (config('settings.single.hide_phone_number') == '') {
					if (isset($post, $post->phone)) {
						$phoneModal = $post->phone;
						$phoneModalLink = 'tel:' . $post->phone;
					}
				}
			?>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-12 text-center">
						<div id="phoneModal" class="p-4 border-2 border-danger bg-light rounded h2 fw-bold">
							<?php echo e($phoneModal); ?>

						</div>
					</div>
					<div class="col-12 mt-4">
						<h3 class="text-danger fw-bold">
							<i class="fas fa-exclamation-triangle"></i> <?php echo t('security_tips_title'); ?>

						</h3>
					</div>
					<div class="col-12">
						<?php echo t('security_tips_text', ['appName' => config('app.name')]); ?>

					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<a id="phoneModalLink" href="<?php echo e($phoneModalLink); ?>" class="btn btn-primary">
					<i class="fas fa-mobile-alt"></i> <?php echo e(t('call_now')); ?>

				</a>
				<button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo e(t('Close')); ?></button>
			</div>
			
		</div>
	</div>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/show/inc/security-tips.blade.php ENDPATH**/ ?>