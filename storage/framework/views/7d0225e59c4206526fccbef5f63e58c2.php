<?php
	$post ??= [];
?>
<div class="reg-sidebar-inner text-center">
	
	<?php if(request()->segment(1) == 'create' || request()->segment(2) == 'create'): ?>
		
		<div class="promo-text-box">
			<i class="far fa-image fa-4x icon-color-1"></i>
			<h3><strong><?php echo e(t('create_new_listing')); ?></strong></h3>
			<p>
				<div><?php echo e(t('do_you_have_something_text', ['url' => getUrlPageByType('ad-posting-rules')])); ?> </div>
				
			</p>
		</div>
	<?php else: ?>
		
		<?php if(config('settings.single.publication_form_type') == '2'): ?>
			
			<?php if(auth()->check()): ?>
				<?php if(auth()->user()->getAuthIdentifier() == data_get($post, 'user_id')): ?>
					<div class="card sidebar-card panel-contact-seller">
						<div class="card-header"><?php echo e(t('author_actions')); ?></div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" class="btn btn-default btn-block">
									<i class="far fa-hand-point-right"></i> <?php echo e(t('Return to the listing')); ?>

								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		<?php else: ?>
			
			<?php if(auth()->check()): ?>
				<?php if(auth()->user()->getAuthIdentifier() == data_get($post, 'user_id')): ?>
					<div class="card sidebar-card panel-contact-seller">
						<div class="card-header"><?php echo e(t('author_actions')); ?></div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a id="btnReturnToAdPreview" href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" class="btn btn-default btn-block">
									<i class="far fa-hand-point-right"></i> <?php echo e(t('Return to the listing')); ?>

								</a>
								<a id="btnUpdatePhotos" href="<?php echo e(url('posts/' . data_get($post, 'id') . '/photos')); ?>" class="btn btn-default btn-block">
									<i class="fas fa-camera"></i> <?php echo e(t('Update Photos')); ?>

								</a>
								<?php if(isset($countPackages) && isset($countPaymentMethods) && $countPackages > 0 && $countPaymentMethods > 0): ?>
									<a id="btnSetPromoNow" href="<?php echo e(url('posts/' . data_get($post, 'id') . '/payment')); ?>" class="btn btn-success btn-block">
										<i class="far fa-check-circle"></i> <?php echo e(t('Make It Premium')); ?>

									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		<?php endif; ?>
	<?php endif; ?>
	
	<div class="card sidebar-card border-color-primary">
		<div class="card-header bg-primary border-color-primary text-white uppercase">
			<strong><?php echo e(t('how_to_sell_quickly')); ?></strong>
		</div>
		<div class="card-content">
			<div class="card-body text-start">
				<ul class="list-check">
					<li> <?php echo e(t('sell_quickly_advice_1')); ?> </li>
					<li> <?php echo e(t('sell_quickly_advice_2')); ?></li>
					<li> <?php echo e(t('sell_quickly_advice_3')); ?></li>
					<li> <?php echo e(t('sell_quickly_advice_4')); ?></li>
					<li> <?php echo e(t('sell_quickly_advice_5')); ?></li>
				</ul>
			</div>
		</div>
	</div>
	
</div><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/post/createOrEdit/inc/right-sidebar.blade.php ENDPATH**/ ?>