<?php
$leftAdvertising ??= [];
$rightAdvertising ??= [];
	$apiResult ??= [];
	$apiExtra ??= [];
	$count = (array)data_get($apiExtra, 'count');
	$posts = (array)data_get($apiResult, 'data');
	$totalPosts = (int)data_get($apiResult, 'meta.total', 0);
	$tags = (array)data_get($apiExtra, 'tags');
	
	$postTypes ??= [];
	$orderByOptions ??= [];
	$displayModes ??= [];
?>

<?php $__env->startSection('search'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('search'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.form', 'search.inc.form'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="main-container">
		
		<?php if(session()->has('flash_notification')): ?>
			<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php $paddingTopExists = true; ?>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.breadcrumbs', 'search.inc.breadcrumbs'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<?php if(config('settings.list.show_cats_in_top')): ?>
			<?php if(isset($cats) && !empty($cats)): ?>
				<div class="container mb-2 hide-xs">
					<div class="row p-0 m-0">
						<div class="col-12 p-0 m-0 border border-bottom-0 bg-light"></div>
					</div>
				</div>
			<?php endif; ?>
			<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.categories', 'search.inc.categories'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
<!--		remove this block from this file and move to /resources/views/search/inc/categories.blade.php -->
 		
		<?php if(isset($topAdvertising) && !empty($topAdvertising)): ?>
			<?php echo $__env->first([
				config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.top',
				'layouts.inc.advertising.top'
			], ['paddingTopExists' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php
				$paddingTopExists = false;
			?>
		<?php else: ?>
			<?php
				if (isset($paddingTopExists) && $paddingTopExists) {
					$paddingTopExists = false;
				}
			?>
		<?php endif; ?>
        
<!--		code-block moved from /resources/views/search/inc/categories.blade.php -->
<!-- disable spotlight feat temporary
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
-->		
<!--	end of the code-block	-->
		<div class="container">
			<div class="row">
				
				
                
                <?php 
                
                
                
                if(config('settings.list.left_sidebar'))
                {
                          
                   $contentColSm = 'col-md-9';
                    if (isset($leftAdvertising) && !empty($leftAdvertising))
                        {
                         ?>
                      
                    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.sidebar', 'search.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                   <?php
                           $contentColSm = 'col-md-7';
                        if (isset($rightAdvertising) && !empty($rightAdvertising))
                           {
                            $contentColSm = 'col-md-7';
                           }
                        }
                    else
                    {
                        $contentColSm = 'col-md-7';
                       ?>
                    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.sidebar', 'search.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                   <?php  
                    }
                }
                else
                {
                    $contentColSm = 'col-md-12';
                }
                
                
                
                ?>
                
                <?php /*?>@if (config('settings.list.left_sidebar'))
                    @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar', 'search.inc.sidebar'])
					<?php
						$contentColSm = 'col-md-9';
					?>
                @else
					<?php
						$contentColSm = 'col-md-12';
					?>
                @endif<?php */?>

				
				<div class="<?php echo e($contentColSm); ?> page-content col-thin-left mb-4">
					<div class="category-list <?php echo e(config('settings.list.display_mode', 'make-grid')); ?><?php echo e(($contentColSm == 'col-md-12') ? ' noSideBar' : ''); ?>">
						<div class="tab-box">

							
							<ul id="postType" class="nav nav-tabs add-tabs tablist" role="tablist">
								<?php
									$aClass = '';
									$spanClass = 'alert-danger';
									if (config('settings.single.show_listing_type')) {
										if (!request()->filled('type') || request()->query('type') == '') {
											$aClass = ' active';
											$spanClass = 'bg-danger';
										}
									} else {
										$aClass = ' active';
										$spanClass = 'bg-danger';
									}
								?>
								<li class="nav-item">
									<a href="<?php echo request()->fullUrlWithoutQuery(['page', 'type']); ?>" class="nav-link<?php echo e($aClass); ?>">
										<?php echo e(t('All Listings')); ?> <span class="badge badge-pill <?php echo $spanClass; ?>"><?php echo e(data_get($count, '0')); ?></span>
									</a>
								</li>
								<?php if(config('settings.single.show_listing_type')): ?>
									<?php if(!empty($postTypes)): ?>
										<?php $__currentLoopData = $postTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php
												$postTypeUrl = request()->fullUrlWithQuery(['type' => data_get($postType, 'id'), 'page' => null]);
												$postTypeCount = data_get($count, data_get($postType, 'id')) ?? 0;
											?>
											<?php if(request()->filled('type') && request()->query('type') == data_get($postType, 'id')): ?>
												<li class="nav-item">
													<a href="<?php echo $postTypeUrl; ?>" class="nav-link active">
														<?php echo e(data_get($postType, 'name')); ?>

														<span class="badge badge-pill bg-danger">
															<?php echo e($postTypeCount); ?>

														</span>
													</a>
												</li>
											<?php else: ?>
<!--
												<li class="nav-item">
													<a href="<?php echo $postTypeUrl; ?>" class="nav-link">
														<?php echo e(data_get($postType, 'name')); ?>

														<span class="badge badge-pill alert-danger">
															<?php echo e($postTypeCount); ?>

														</span>
													</a>
												</li>
-->
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								<?php endif; ?>
							</ul>
							
							<div class="tab-filter pb-2">
								
								<select id="orderBy" title="sort by" class="niceselecter select-sort-by small" data-style="btn-select" data-width="auto">
									<?php if(!empty($orderByOptions)): ?>
										<?php $__currentLoopData = $orderByOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if(data_get($option, 'condition')): ?>
												<?php
													$optionUrl = request()->fullUrlWithQuery((array)data_get($option, 'query'));
												?>
												<option <?php if(data_get($option, 'isSelected')): echo 'selected'; endif; ?> value="<?php echo $optionUrl; ?>">
													<?php echo e(data_get($option, 'label')); ?>

												</option>
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
							</div>

						</div>
						
						<div class="listing-filter">
							<div class="float-start col-md-9 col-sm-8 col-12">
								<h1 class="h6 pb-0 breadcrumb-list">
									<?php echo (isset($htmlTitle)) ? $htmlTitle : ''; ?>

								</h1>
                                <div style="clear:both;"></div>
							</div>
							
							
							<?php if(!empty($posts) && $totalPosts > 0): ?>
								<?php
									$currDisplay = config('settings.list.display_mode');
								?>
								<div class="float-end col-md-3 col-sm-4 col-12 text-end listing-view-action">
									<?php if(!empty($displayModes)): ?>
										<?php $__currentLoopData = $displayModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $displayMode => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<span class="grid-view<?php echo e(($currDisplay == $displayMode) ? ' active' : ''); ?>">
												<?php if($currDisplay == $displayMode): ?>
													<i class="<?php echo e(data_get($value, 'icon')); ?>"></i>
												<?php else: ?>
													<?php
														$displayModeUrl = request()->fullUrlWithQuery((array)data_get($value, 'query'));
													?>
													<a href="<?php echo $displayModeUrl; ?>" rel="nofollow">
														<i class="<?php echo e(data_get($value, 'icon')); ?>"></i>
													</a>
												<?php endif; ?>
											</span>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							
							<div style="clear:both"></div>
						</div>
						
						
						<div class="mobile-filter-bar col-xl-12">
							<ul class="list-unstyled list-inline no-margin no-padding">
								<?php if(config('settings.list.left_sidebar')): ?>
									<li class="filter-toggle">
										<a class=""><i class="fas fa-bars"></i> <?php echo e(t('Filters')); ?></a>
									</li>
								<?php endif; ?>
								<li>
									
									<div class="dropdown">
										<a class="dropdown-toggle" data-bs-toggle="dropdown"><?php echo e(t('Sort by')); ?></a>
										<ul class="dropdown-menu">
											<?php if(!empty($orderByOptions)): ?>
												<?php $__currentLoopData = $orderByOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if(data_get($option, 'condition')): ?>
														<?php
															$optionUrl = request()->fullUrlWithQuery((array)data_get($option, 'query'));
														?>
														<li>
															<a href="<?php echo $optionUrl; ?>" rel="nofollow">
																<?php echo e(data_get($option, 'label')); ?>

															</a>
														</li>
													<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</ul>
									</div>
								</li>
							</ul>
						</div>
						<div class="menu-overly-mask"></div>
						
						
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="contentAll" role="tabpanel" aria-labelledby="tabAll">
								<div id="postsList" class="category-list-wrapper posts-wrapper row no-margin">
									<?php if(config('settings.list.display_mode') == 'make-list'): ?>
										<?php echo $__env->first([
											config('larapen.core.customizedViewPath') . 'search.inc.posts.template.list',
											'search.inc.posts.template.list'
										], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									<?php elseif(config('settings.list.display_mode') == 'make-compact'): ?>
										<?php echo $__env->first([
											config('larapen.core.customizedViewPath') . 'search.inc.posts.template.compact',
											'search.inc.posts.template.compact'
										], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									<?php else: ?>
										<?php echo $__env->first([
											config('larapen.core.customizedViewPath') . 'search.inc.posts.template.grid',
											'search.inc.posts.template.grid'
										], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						<?php if(request()->filled('q') && request()->query('q') != '' && data_get($count, '0') > 0): ?>
							<div class="tab-box save-search-bar text-center">
								<a id="saveSearch"
								   data-name="<?php echo request()->fullUrlWithoutQuery(['_token', 'location']); ?>"
								   data-count="<?php echo e(data_get($count, '0')); ?>"
								>
									<i class="far fa-bell"></i> <?php echo e(t('Save Search')); ?>

								</a>
							</div>
						<?php endif; ?>
					</div>
					
					<nav class="mt-3 mb-0 pagination-sm" aria-label="">
						<?php echo $__env->make('vendor.pagination.api.bootstrap-4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</nav>
					
				</div>
                
                <?php 
                if (isset($rightAdvertising) && !empty($rightAdvertising))
                           {
                             ?>
                              <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.right','layouts.inc.advertising.right'], ['paddingTopExists' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php
                           }
                
                ?>
                
			</div>
		</div>
		
		
		<?php echo $__env->first([
			config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom',
			'layouts.inc.advertising.bottom'
		], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		
		<div class="container mb-3">
			<div class="card border-light text-dark bg-light mb-3">
				<div class="card-body text-center">
					<h2><?php echo e(t('do_you_have_anything')); ?></h2>
					<h5><?php echo e(t('sell_products_and_services_online_for_free')); ?></h5>
					<?php if(!auth()->check() && config('settings.single.guest_can_submit_listings') != '1'): ?>
						<a id="btnPostAdlink2"  href="#quickLogin" class="btn btn-block btn-border btn-primary" data-bs-toggle="modal">
							<?php echo e(t('start_now')); ?>

						</a>
					<?php else: ?>
						<a id="btnPostAdlink2" href="<?php echo e(\App\Helpers\UrlGen::addPost()); ?>" class="btn btn-block btn-border btn-primary">
							<?php echo e(t('start_now')); ?>

						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		
		<?php if(isset($cat) && !empty(data_get($cat, 'description'))): ?>
			<?php if(!(bool)data_get($cat, 'hide_description')): ?>
				<div class="container mb-3">
					<div class="card border-light text-dark bg-light mb-3">
						<div class="card-body">
							<?php echo data_get($cat, 'description'); ?>

						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		
		<?php if(config('settings.list.show_listings_tags')): ?>
			<?php if(!empty($tags)): ?>
				<div class="container">
					<div class="card mb-3">
						<div class="card-body">
							<h2 class="card-title"><i class="fas fa-tags"></i> <?php echo e(t('Tags')); ?>:</h2>
							<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<span class="d-inline-block border border-inverse bg-light rounded-1 py-1 px-2 my-1 me-1">
									<a href="<?php echo e(\App\Helpers\UrlGen::tag($iTag)); ?>">
										<?php echo e($iTag); ?>

									</a>
								</span>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal_location'); ?>
	<?php echo $__env->first([
		config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location',
		'layouts.inc.modal.location'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		$(document).ready(function () {
		    
			$('#postType a').click(function (e) {
				e.preventDefault();
				let goToUrl = $(this).attr('href');
				redirect(goToUrl);
			});
			$('#orderBy').change(function () {
				let goToUrl = $(this).val();
				redirect(goToUrl);
			});
		});
		// revlenece part 2 start
		// ignored
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/search/results.blade.php ENDPATH**/ ?>