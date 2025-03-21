<?php if(!empty($cat) || !empty($cats)): ?>
<div class="container mb-3 hide-xs">
    
    
    
	<?php if(!empty($cat)): ?>
		<?php if(!empty(data_get($cat, 'children'))): ?>
			<div class="row row-cols-lg-4 row-cols-md-3 p-2 g-2" id="categoryBadge">
				<?php $__currentLoopData = data_get($cat, 'children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="col">
						<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat, null, $city ?? null)); ?>">
							<?php if(in_array(config('settings.list.show_category_icon'), [3, 5, 7, 8])): ?>
								<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
							<?php endif; ?>
							<?php echo e(data_get($iSubCat, 'name')); ?>

						</a>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
		<?php else: ?>
			<?php if(!empty(data_get($cat, 'parent.children'))): ?>
				<div class="row row-cols-lg-4 row-cols-md-3 p-2 g-2" id="categoryBadge">
					<?php $__currentLoopData = data_get($cat, 'parent.children'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col">
							<?php if(data_get($iSubCat, 'id') == data_get($cat, 'id')): ?>
								<span class="fw-bold">
									<?php if(in_array(config('settings.list.show_category_icon'), [3, 5, 7, 8])): ?>
										<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
									<?php endif; ?>
									<?php echo e(data_get($iSubCat, 'name')); ?>

								</span>
							<?php else: ?>
								<a href="<?php echo e(\App\Helpers\UrlGen::category($iSubCat, null, $city ?? null)); ?>">
									<?php if(in_array(config('settings.list.show_category_icon'), [3, 5, 7, 8])): ?>
										<i class="<?php echo e(data_get($iSubCat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
									<?php endif; ?>
									<?php echo e(data_get($iSubCat, 'name')); ?>

								</a>
							<?php endif; ?>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
<!--  move the code from line 63 to 77 of the file /resources/views/search/results.blade.php to this place -->



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
			<?php else: ?>
				
				<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.categories-root', 'search.inc.categories-root'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
			<?php endif; ?>
		<?php endif; ?>
	<?php else: ?>
		
		<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'search.inc.categories-root', 'search.inc.categories-root'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
	<?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
   
$(document).ready(function() {
    $('.title-3').html('Spotlight <span style="font-weight: bold;">Ads</span>');
});
</script>

<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/search/inc/categories.blade.php ENDPATH**/ ?>