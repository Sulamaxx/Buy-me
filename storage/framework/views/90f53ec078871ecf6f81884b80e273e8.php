<?php
$sectionOptions = $getCategoriesOp ?? [];
$sectionData ??= [];
$categories = (array)data_get($sectionData, 'categories');
$subCategories = (array)data_get($sectionData, 'subCategories');
$countPostsPerCat = (array)data_get($sectionData, 'countPostsPerCat');
$countPostsPerCat = collect($countPostsPerCat)->keyBy('id')->toArray();

$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';

$catDisplayType = data_get($sectionOptions, 'cat_display_type');
$maxSubCats = (int)data_get($sectionOptions, 'max_sub_cats');

$sectionOptions = $getSearchFormOp ?? [];
$sectionData ??= [];

// Get Search Form Options
$enableFormAreaCustomization = data_get($sectionOptions, 'enable_extended_form_area') ?? '0';
$hideTitles = data_get($sectionOptions, 'hide_titles') ?? '0';

$headerTitle = data_get($sectionOptions, 'title_' . config('app.locale'));
$headerTitle = (!empty($headerTitle)) ? replaceGlobalPatterns($headerTitle) : null;

$headerSubTitle = data_get($sectionOptions, 'sub_title_' . config('app.locale'));
$headerSubTitle = (!empty($headerSubTitle)) ? replaceGlobalPatterns($headerSubTitle) : null;

$parallax = data_get($sectionOptions, 'parallax') ?? '0';
$hideForm = data_get($sectionOptions, 'hide_form') ?? '0';
$displayStatesSearchTip = config('settings.list.display_states_search_tip');
$topAdvertising ??= [];
?>
<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="container<?php echo e($hideOnMobile); ?>">
	<div class="col-xl-14 content-box layout-section" style="background-color: transparent;border-radius: 0%">
		<div class="row row-featured row-featured-category" style="margin-inline: 0px">
			
			
			<?php if($catDisplayType == 'c_picture_list'): ?>
				<!-- all category display #001 
				<div class="col-lg-2 col-md-3 col-sm-4 col-3 f-category">
				     <a href="/search?c=&q=&r=&l=&location=">
				          <img  src="/public/images/all-icon.png" class="img-fluid" alt="All"><BR> <h4> <?php echo e(t('All')); ?> </h4> </a> 
				     
			    </div>-->
			   
<style>
    .custom-col-lg {
        width: 11.111111% !important; /* 7 items per row for large screens */
    }
        .f-category {
    	padding: 5px 5px 5px !important;
		background-color:transparent;
    }

	.white-box {
        background-color: white;
		border-radius: 0%;
    }

	.see-all-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    #see-all-box {
        height: 100%;
    }
    
    @media (max-width: 767.98px) {
    .custom-col-lg {
        width: 33.3% !important; /* 2 items per row for small screens (50% else 33.3) */
    }
     .f-category {
    	padding: 5px 5px 5px 5px !important;
    }

}
 
</style>
           
<?php
// Split categories into first 8 and the rest
$firstEight = array_slice($categories, 0, 8);
$remaining = array_slice($categories, 8);
?>

<!-- Display the first 8 categories -->
<?php $__currentLoopData = $firstEight; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="custom-col-lg custom-col-md custom-col-sm custom-col-xs f-category" style="border: none">
	<div class="white-box">
		<a href="<?php echo e(\App\Helpers\UrlGen::category($cat)); ?>">
			<img src="<?php echo e(data_get($cat, 'picture_url')); ?>" class="lazyload img-fluid" alt="<?php echo e(data_get($cat, 'name')); ?>" style="height: max-content">
			<h4 style="font-size: small; color: #666666;padding-top: 0%;padding-bottom: 0%;margin-block-start: 0rem !important;margin-block-end: 0rem !important;"><br>
				<?php echo e(data_get($cat, 'name')); ?>

				<?php if(config('settings.list.count_categories_listings')): ?>
					&nbsp;(<?php echo e($countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0); ?>)
				<?php endif; ?>
			</h4>
		</a>
	</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if(!empty($remaining)): ?>
<!-- Display "See All" box as the 9th item -->
<div class="custom-col-lg custom-col-md custom-col-sm custom-col-xs f-category" id="see-all-box" style="border: none">
	<div class="white-box" >
		<a href="#" id="see-all-link">
			<img src="/images/categories/see-all.jpg" class="img-fluid" alt="See All" style="height: max-content">
			<h4 style="font-size: small; color: #666666;padding-top: 0%;padding-bottom: 0%;margin-block-start: 0rem !important;margin-block-end: 0rem !important;"><br>
				See All
			</h4>
		</a>
	</div>
</div>

<!-- Display remaining categories, hidden initially -->
<?php $__currentLoopData = $remaining; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="custom-col-lg custom-col-md custom-col-sm custom-col-xs f-category hidden-category" style="border: none; display: none;">
		<div class="white-box">
			<a href="<?php echo e(\App\Helpers\UrlGen::category($cat)); ?>">
				<img src="<?php echo e(data_get($cat, 'picture_url')); ?>" class="lazyload img-fluid" alt="<?php echo e(data_get($cat, 'name')); ?>"style="height: max-content">
				<h4 style="font-size: small; color: #666666;padding-top: 0%;padding-bottom: 0%;margin-block-start: 0rem !important;margin-block-end: 0rem !important;"><br>
					<?php echo e(data_get($cat, 'name')); ?>

					<?php if(config('settings.list.count_categories_listings')): ?>
						&nbsp;(<?php echo e($countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0); ?>)
					<?php endif; ?>
				</h4>
			</a>
		</div>
	</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<!-- Display "See All" box as the 9th item -->
<div class="custom-col-lg custom-col-md custom-col-sm custom-col-xs f-category" id="see-less-box" style="border: none;display:none;">
	<div class="white-box" >
		<a href="#" id="see-less-link">
			<img src="/images/categories/see-less.jpg" class="img-fluid" alt="See Less" style="height: max-content">
			<h4 style="font-size: small; color: #666666;padding-top: 0%;padding-bottom: 0%;margin-block-start: 0rem !important;margin-block-end: 0rem !important;"><br>
				See Less
			</h4>
		</a>
	</div>
</div>

<?php endif; ?>
				
			<?php elseif($catDisplayType == 'c_bigIcon_list'): ?>
				
				<?php if(!empty($categories)): ?>
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						  <div class="custom-col-lg custom-col-md custom-col-sm custom-col-xs f-category">
							<a href="<?php echo e(\App\Helpers\UrlGen::category($cat)); ?>" title="<?php echo e(\App\Helpers\UrlGen::category($cat)); ?>">
								<?php if(in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8])): ?>
									<i class="<?php echo e(data_get($cat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
								<?php endif; ?>
								<h6>
									<?php echo e(data_get($cat, 'name')); ?>

									<?php if(config('settings.list.count_categories_listings')): ?>
										&nbsp;(<?php echo e($countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0); ?>)
									<?php endif; ?>
								</h6>
							</a>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
				
			<?php elseif(in_array($catDisplayType, ['cc_normal_list', 'cc_normal_list_s'])): ?>
				
				<div style="clear: both;"></div>
				<?php $styled = ($catDisplayType == 'cc_normal_list_s') ? ' styled' : ''; ?>
				
				<?php if(!empty($categories)): ?>
					<div class="col-xl-14">
						<div class="list-categories-children<?php echo e($styled); ?>">
							<div class="row px-3">
								<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cols): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="col-md-4 col-sm-4 <?php echo e((count($categories) == $key+1) ? 'last-column' : ''); ?>">
										<?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											
											<?php
												$randomId = '-' . substr(uniqid(rand(), true), 5, 5);
											?>
										
											<div class="cat-list">
												<h3 class="cat-title rounded">
													<?php if(in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8])): ?>
														<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'fas fa-check'); ?>"></i>&nbsp;
													<?php endif; ?>
													<a href="<?php echo e(\App\Helpers\UrlGen::category($iCat)); ?>">
														<?php echo e(data_get($iCat, 'name')); ?>

														<?php if(config('settings.list.count_categories_listings')): ?>
															&nbsp;(<?php echo e($countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0); ?>)
														<?php endif; ?>
													</a>
													<span class="btn-cat-collapsed collapsed"
														  data-bs-toggle="collapse"
														  data-bs-target=".cat-id-<?php echo e(data_get($iCat, 'id') . $randomId); ?>"
														  aria-expanded="false"
													>
														<span class="icon-down-open-big"></span>
													</span>
												</h3>
												<ul class="cat-collapse collapse show cat-id-<?php echo e(data_get($iCat, 'id') . $randomId); ?> long-list-home">
													<?php if(isset($subCategories[data_get($iCat, 'id')])): ?>
														<?php $catSubCats = $subCategories[data_get($iCat, 'id')]; ?>
														<?php $__currentLoopData = $catSubCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<li>
																<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat)); ?>">
																	<?php echo e(data_get($iSubCat, 'name')); ?>

																</a>
																<?php if(config('settings.list.count_categories_listings')): ?>
																	&nbsp;(<?php echo e($countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0); ?>)
																<?php endif; ?>
															</li>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
												</ul>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
						<div style="clear: both;"></div>
					</div>
				<?php endif; ?>
				
			<?php else: ?>
				
				<?php
				$listTab = [
					'c_border_list' => 'list-border',
				];
				$catListClass = (isset($listTab[$catDisplayType])) ? 'list ' . $listTab[$catDisplayType] : 'list';
				?>
				<?php if(!empty($categories)): ?>
					<div class="col-xl-14">
						<div class="list-categories">
							<div class="row">
								<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<ul class="cat-list <?php echo e($catListClass); ?> col-md-4 <?php echo e((count($categories) == $key+1) ? 'cat-list-border' : ''); ?>">
										<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li>
												<?php if(in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8])): ?>
													<i class="<?php echo e(data_get($cat, 'icon_class') ?? 'fas fa-check'); ?>"></i>&nbsp;
												<?php endif; ?>
												<a href="<?php echo e(\App\Helpers\UrlGen::category($cat)); ?>">
													<?php echo e(data_get($cat, 'name')); ?>

												</a>
												<?php if(config('settings.list.count_categories_listings')): ?>
													&nbsp;(<?php echo e($countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0); ?>)
												<?php endif; ?>
											</li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
			<?php endif; ?>
	
		</div>
	</div>
</div>



<?php $__env->startSection('before_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('before_scripts'); ?>
	<?php if($maxSubCats >= 0): ?>
		<script>
			var maxSubCats = <?php echo e($maxSubCats); ?>;
		</script>
	<?php endif; ?>
	<script>
        document.addEventListener('DOMContentLoaded', function() {
            var seeAllLink = document.getElementById('see-all-link');
            if (seeAllLink) {
                seeAllLink.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent the link from navigating
                    // Hide the "See All" box
                    document.getElementById('see-all-box').style.display = 'none';
                    // Show all hidden categories
                    var hiddenCats = document.querySelectorAll('.hidden-category');
                    hiddenCats.forEach(function(cat) {
                        cat.style.display = 'block';
                    });
					document.getElementById('see-less-box').style.display = 'block';
                });
            }
			var seeLessLink = document.getElementById('see-less-link');
            if (seeLessLink) {
                seeLessLink.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent the link from navigating
                    // Hide the "See All" box
                    document.getElementById('see-less-box').style.display = 'none';

                    // Show all hidden categories
                    var hiddenCats = document.querySelectorAll('.hidden-category');
                    hiddenCats.forEach(function(cat) {
						cat.style.display = 'none';
                    });
					document.getElementById('see-all-box').style.display = 'block';
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/home/inc/categories.blade.php ENDPATH**/ ?>