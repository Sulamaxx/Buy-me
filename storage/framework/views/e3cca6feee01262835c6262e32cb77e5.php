


<?php
	$post ??= [];
	$catBreadcrumb ??= [];
	$topAdvertising ??= [];
	$bottomAdvertising ??= [];
	$midAdvertising ??= []; 
?>

<?php $__env->startSection('content'); ?>
	<?php echo csrf_field(); ?>

	<input type="hidden" id="postId" name="post_id" value="<?php echo e(data_get($post, 'id')); ?>">
	
	<?php if(session()->has('flash_notification')): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php
			$paddingTopExists = true;
		?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			</div>
		</div>
		<?php
			session()->forget('flash_notification.message');
		?>
	<?php endif; ?>
	
	
	<?php if(!empty(data_get($post, 'archived_at'))): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php
			$paddingTopExists = true;
		?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="alert alert-warning" role="alert">
						<?php echo t('This listing has been archived'); ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<div class="main-container">
		
		<?php if(!empty($topAdvertising)): ?>
			<?php echo $__env->first(
				[config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.top', 'layouts.inc.advertising.top'],
				['paddingTopExists' => $paddingTopExists ?? false]
			, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php
				$paddingTopExists = false;
			?>
		<?php endif; ?>
		
		<div class="container <?php echo e(!empty($topAdvertising) ? 'mt-3' : 'mt-2'); ?>">
			<div class="row">
				<div class="col-md-12">
					
					<nav aria-label="breadcrumb" role="navigation" class="float-start">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><i class="fas fa-home"></i></a></li>
							<li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(config('country.name')); ?></a></li>
							<?php if(is_array($catBreadcrumb) && count($catBreadcrumb) > 0): ?>
								<?php $__currentLoopData = $catBreadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li class="breadcrumb-item">
										<a href="<?php echo e($value->get('url')); ?>">
											<?php echo $value->get('name'); ?>

										</a>
									</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
							<li class="breadcrumb-item active" aria-current="page"><?php echo e(str(data_get($post, 'title'))->limit(70)); ?></li>
						</ol>
					</nav>
					
					<div class="float-end backtolist">
						<a href="<?php echo e(rawurldecode(url()->previous())); ?>">
							<i class="fa fa-angle-double-left"></i> <?php echo e(t('back_to_results')); ?>

						</a>
					</div>
				
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
                
                
                <?php 
                {        
                   $contentColSm = 'col-md-9';
                    if (isset($leftAdvertising) && !empty($leftAdvertising))
                        {
                         ?>
                        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.left','layouts.inc.advertising.left'], ['paddingTopExists' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                   <?php
                           $contentColSm = 'col-md-7';
                        }
                }
                ?> 
                
                
				<div class="<?php echo e($contentColSm); ?> page-content col-thin-right">
					<?php
						$innerBoxStyle = (!auth()->check() && plugin_exists('reviews')) ? 'overflow: visible;' : '';
					?>
					<div class="inner inner-box items-details-wrapper pb-0" style="<?php echo e($innerBoxStyle); ?>">
						<h1 class="h4 fw-bold enable-long-words">
							<strong>
								<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" title="<?php echo e(data_get($post, 'title')); ?>">
									<?php echo e(data_get($post, 'title')); ?>

                                </a>
                            </strong>
							<?php if(config('settings.single.show_listing_type')): ?>
								<?php if(!empty(data_get($post, 'postType'))): ?>
									<small class="label label-default adlistingtype"><?php echo e(data_get($post, 'postType.name')); ?></small>
								<?php endif; ?>
							<?php endif; ?>
							<?php if(data_get($post, 'featured') == 1 && !empty(data_get($post, 'payment.package'))): ?>
								<i class="fas fa-check-circle"
								   style="color: <?php echo e(data_get($post, 'payment.package.ribbon')); ?>;"
								   data-bs-placement="bottom"
								   data-bs-toggle="tooltip"
								   title="<?php echo e(data_get($post, 'payment.package.short_name')); ?>"
								></i>
                            <?php endif; ?>
						</h1>
						<span class="info-row">
							<?php if(!config('settings.single.hide_date')): ?>
							<span class="date"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
								<i class="far fa-clock"></i> <?php echo data_get($post, 'created_at_formatted'); ?>

							</span>&nbsp;
							<?php endif; ?>
							<span class="category"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
								<i class="bi bi-folder"></i> <?php echo e(data_get($post, 'category.parent.name', data_get($post, 'category.name'))); ?>

							</span>&nbsp;
							<span class="item-location"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
								<i class="bi bi-geo-alt"></i> <?php echo e(data_get($post, 'city.name')); ?>

							</span>&nbsp;
							<span class="category"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
								<i class="bi bi-eye"></i> <?php echo e(data_get($post, 'visits_formatted')); ?>

							</span>
							<span class="category float-md-end"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
							<!-- DE1 -->
								<?php if(auth()->check()): ?>
								<?php echo e(t('reference')); ?>: <?php echo e(data_get($post, 'reference')); ?>

                                                                <?php endif; ?>
							</span>
						</span>
						
						<?php echo $__env->make('post.show.inc.pictures-slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						
						<?php if(config('plugins.reviews.installed')): ?>
							<?php if(view()->exists('reviews::ratings-single')): ?>
								<?php echo $__env->make('reviews::ratings-single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endif; ?>
						<?php endif; ?>
						
						<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.show.inc.details', 'post.show.inc.details'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					       
						<?php echo $__env->first([
							config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.middle',
							'layouts.inc.advertising.middle'
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					</div>
				</div>
				
				<div class="col-lg-3 page-sidebar-right">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.show.inc.sidebar', 'post.show.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php 
                if (isset($rightAdvertising) && !empty($rightAdvertising))
                           {
                             ?>
                              <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.right_pd','layouts.inc.advertising.right_pd'], ['paddingTopExists' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php
                           }
                
                ?>
				</div>
			</div>

		</div>
		
		<?php if(config('settings.single.similar_listings') == '1' || config('settings.single.similar_listings') == '2'): ?>
			<?php
				$widgetType = (config('settings.single.similar_listings_in_carousel') ? 'carousel' : 'normal');
			?>
			<?php echo $__env->first([
					config('larapen.core.customizedViewPath') . 'search.inc.posts.widget.' . $widgetType,
					'search.inc.posts.widget.' . $widgetType
				],
				['widget' => ($widgetSimilarPosts ?? null), 'firstSection' => false]
			, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
		
		<?php echo $__env->first(
			[config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom', 'layouts.inc.advertising.bottom'],
			['firstSection' => false]
		, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<?php if(isVerifiedPost($post)): ?>
			<?php echo $__env->first(
				[config('larapen.core.customizedViewPath') . 'layouts.inc.tools.facebook-comments', 'layouts.inc.tools.facebook-comments'],
				['firstSection' => false]
			, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
		
	</div>
<?php $__env->stopSection(); ?>
<?php
	if (!session()->has('emailVerificationSent') && !session()->has('phoneVerificationSent')) {
		if (session()->has('message')) {
			session()->forget('message');
		}
	}
?>

<?php $__env->startSection('modal_message'); ?>
	<?php if(config('settings.single.show_security_tips') == '1'): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.show.inc.security-tips', 'post.show.inc.security-tips'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
	<?php if(auth()->check() || config('settings.single.guest_can_contact_authors')=='1'): ?>
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.messenger.modal.create', 'account.messenger.modal.create'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('before_scripts'); ?>
	<script>
		var showSecurityTips = '<?php echo e(config('settings.single.show_security_tips', '0')); ?>';
	</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php if(config('services.googlemaps.key')): ?>
		
        <script async src="https://maps.googleapis.com/maps/api/js?v=weekly&key=<?php echo e(config('services.googlemaps.key')); ?>"></script>
    <?php endif; ?>
    
	<script>
		
        var lang = {
            labelSavePostSave: "<?php echo t('Save listing'); ?>",
            labelSavePostRemove: "<?php echo t('Remove favorite'); ?>",
            loginToSavePost: "<?php echo t('Please log in to save the Listings'); ?>",
            loginToSaveSearch: "<?php echo t('Please log in to save your search'); ?>"
        };
		
		$(document).ready(function () {
			
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[rel="tooltip"]'));
			var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl)
			});
			
			<?php if(config('settings.single.show_listing_on_googlemap')): ?>
				
			<?php endif; ?>
			
			
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                /* save the latest tab; use cookies if you like 'em better: */
                /* localStorage.setItem('lastTab', $(this).attr('href')); */
				localStorage.setItem('lastTab', $(this).attr('data-bs-target'));
            });
			
            let lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
				
				let triggerEl = document.querySelector('button[data-bs-target="' + lastTab + '"]');
				if (typeof triggerEl !== 'undefined' && triggerEl !== null) {
					let tabObj = new bootstrap.Tab(triggerEl);
					if (tabObj !== null) {
						tabObj.show();
					}
				}
            }
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/post/show/index.blade.php ENDPATH**/ ?>