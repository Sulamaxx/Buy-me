<?php
	$post ??= [];
?>
<div class="items-details">
	<ul class="nav nav-tabs" id="itemsDetailsTabs" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active"
					id="item-details-tab"
					data-bs-toggle="tab"
					data-bs-target="#item-details"
					role="tab"
					aria-controls="item-details"
					aria-selected="true"
			>
				<span class="title-3 lh-base"><?php echo e(t('listing_details')); ?></span>
			</button>
		</li>
		<?php if(config('plugins.reviews.installed')): ?>
			<li class="nav-item" role="presentation">
				<button class="nav-link"
						id="item-<?php echo e(config('plugins.reviews.name')); ?>-tab"
						data-bs-toggle="tab"
						data-bs-target="#item-<?php echo e(config('plugins.reviews.name')); ?>"
						role="tab"
						aria-controls="item-<?php echo e(config('plugins.reviews.name')); ?>"
						aria-selected="false"
				>
					<span class="title-3 lh-base">
						<?php echo e(trans('reviews::messages.Reviews')); ?> (<?php echo e(data_get($post, 'rating_count', 0)); ?>)
					</span>
				</button>
			</li>
		<?php endif; ?>
	</ul>
	
	
	<div class="tab-content p-3 mb-3" id="itemsDetailsTabsContent">
		<div class="tab-pane show active" id="item-details" role="tabpanel" aria-labelledby="item-details-tab">
			<div class="row pb-3">
				<div class="items-details-info col-md-12 col-sm-12 col-12 enable-long-words from-wysiwyg">
					
					<div class="row">
						
						<div class="col-md-6 col-sm-6 col-6">
							<h4 class="fw-normal p-0">
								<span class="fw-bold"><i class="bi bi-geo-alt"></i> <?php echo e(t('location')); ?>: </span>
								<span>
									<a href="<?php echo \App\Helpers\UrlGen::city(data_get($post, 'city')); ?>">
										<?php echo e(data_get($post, 'city.name')); ?>

									</a>
								</span>
							</h4>
						</div>
						
						
						<div class="col-md-6 col-sm-6 col-6 text-end">
							<h4 class="fw-normal p-0">
								<span class="fw-bold">
									<?php echo e(data_get($post, 'price_label')); ?>

								</span>
								<span>
									<?php echo data_get($post, 'price_formatted'); ?>

									<?php if(data_get($post, 'negotiable') == 1): ?>
										<small class="label bg-success"> <?php echo e(t('negotiable')); ?></small>
									<?php endif; ?>
								</span>
							</h4>
						</div>
					</div>
					<hr class="border-0 bg-secondary">
					
					
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.show.inc.details.fields-values', 'post.show.inc.details.fields-values'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					
					<div class="row">
						<div class="col-12 detail-line-content">
						     <BR>
						     <H4> <?php echo e(t('ad_description')); ?></H4>
						     <BR>
						<span>	<?php echo data_get($post, 'description'); ?></span>
						</div>
					</div>
					

					
					
					<?php if(!empty(data_get($post, 'tags'))): ?>
						<div class="row mt-3">
							<div class="col-12">
								<h4 class="p-0 my-3"><i class="bi bi-tags"></i> <?php echo e(t('Tags')); ?>:</h4>
								<?php $__currentLoopData = data_get($post, 'tags'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<span class="d-inline-block border border-inverse bg-light rounded-1 py-1 px-2 my-1 me-1">
										<a href="<?php echo e(\App\Helpers\UrlGen::tag($iTag)); ?>">
											<?php echo e($iTag); ?>

										</a>
									</span>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					<?php endif; ?>
					
					
					<?php if(!auth()->check() || (auth()->check() && auth()->id() != data_get($post, 'user_id'))): ?>
						<div class="row text-center h2 mt-4">
							<div class="col-4">
								<?php if(auth()->check()): ?>
									<?php if(auth()->user()->id == data_get($post, 'user_id')): ?>
										<a href="<?php echo e(\App\Helpers\UrlGen::editPost($post)); ?>">
											<i class="far fa-edit" data-bs-toggle="tooltip" title="<?php echo e(t('Edit')); ?>"></i>
										</a>
									<?php else: ?>
										<?php echo genEmailContactBtn($post, false, true); ?>

									<?php endif; ?>
								<?php else: ?>
									<?php echo genEmailContactBtn($post, false, true); ?>

								<?php endif; ?>
							</div>
							<?php if(isVerifiedPost($post)): ?>
								<div class="col-4">
									<a class="make-favorite" id="<?php echo e(data_get($post, 'id')); ?>" href="javascript:void(0)">
										<?php if(auth()->check()): ?>
											<?php if(!empty(data_get($post, 'savedByLoggedUser'))): ?>
												<i class="fas fa-bookmark" data-bs-toggle="tooltip" title="<?php echo e(t('Remove favorite')); ?>"></i>
											<?php else: ?>
												<i class="far fa-bookmark" data-bs-toggle="tooltip" title="<?php echo e(t('Save listing')); ?>"></i>
											<?php endif; ?>
										<?php else: ?>
											<i class="far fa-bookmark" data-bs-toggle="tooltip" title="<?php echo e(t('Save listing')); ?>"></i>
										<?php endif; ?>
									</a>
								</div>
								<div class="col-4">
									<a href="<?php echo e(\App\Helpers\UrlGen::reportPost($post)); ?>">
										<i class="far fa-flag" data-bs-toggle="tooltip" title="<?php echo e(t('Report abuse')); ?>"></i>
									</a>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			
			</div>
		</div>
		
		<?php if(config('plugins.reviews.installed')): ?>
			<?php if(view()->exists('reviews::comments')): ?>
				<?php echo $__env->make('reviews::comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	
	<div class="content-footer text-start">
		<?php if(auth()->check()): ?>
			<?php if(auth()->user()->id == data_get($post, 'user_id')): ?>
				<a class="btn btn-default" href="<?php echo e(\App\Helpers\UrlGen::editPost($post)); ?>">
					<i class="far fa-edit"></i> <?php echo e(t('Edit')); ?>

				</a>
			<?php else: ?>
				<?php echo genPhoneNumberBtn($post); ?>

				<?php echo genEmailContactBtn($post); ?>

			<?php endif; ?>
		<?php else: ?>
			<?php echo genPhoneNumberBtn($post); ?>

			<?php echo genEmailContactBtn($post); ?>

		<?php endif; ?>
	</div>
</div>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/post/show/inc/details.blade.php ENDPATH**/ ?>