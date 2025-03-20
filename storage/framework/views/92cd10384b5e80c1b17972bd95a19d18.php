<?php
	$categoriesOptions ??= [];
	$catDisplayType = data_get($categoriesOptions, 'cat_display_type');
	$maxSubCats = (int)data_get($categoriesOptions, 'max_sub_cats');
	
	$apiResult ??= [];
	$totalCategories = (int)data_get($apiResult, 'meta.total', 0);
	$areCategoriesPagingable = (!empty(data_get($apiResult, 'links.prev')) || !empty(data_get($apiResult, 'links.next')));
	
	$categories ??= [];
	$subCategories ??= [];
	$category ??= null;
	$hasChildren ??= false;
	$catId ??= 0; /* The selected category ID */
?>
<?php if(!$hasChildren): ?>
	
	
	
	<?php if(!empty($category)): ?>
		<?php if(!empty(data_get($category, 'children'))): ?>
			<a href="#browseCategories" data-bs-toggle="modal" class="cat-link" data-id="<?php echo e(data_get($category, 'id')); ?>">
				<?php echo e(data_get($category, 'name')); ?>

			</a>
		<?php else: ?>
			<?php echo e(data_get($category, 'name')); ?>&nbsp;
			[ <a href="#browseCategories"
				 data-bs-toggle="modal"
				 class="cat-link"
				 data-id="<?php echo e(data_get($category, 'parent.id', 0)); ?>"
			><i class="far fa-edit"></i> <?php echo e(t('Edit')); ?></a> ]
		<?php endif; ?>
	<?php else: ?>
		<a href="#browseCategories" data-bs-toggle="modal" class="cat-link" data-id="0">
			<?php echo e(t('select_a_category')); ?>

		</a>
	<?php endif; ?>
	
<?php else: ?>
	
	

	<?php if(!empty($category)): ?>
		<p>
			<a href="#" class="btn btn-sm btn-success btn-sm-3 cat-link" style="width: 100px !important; background-color:#008D000 !important" data-id="<?php echo e(data_get($category, 'parent_id')); ?>">
				<i class="fas fa-reply"></i> <?php echo e(t('go_to_parent_categories')); ?>

			</a>&nbsp;
			<strong><?php echo e(data_get($category, 'name')); ?></strong>
		</p>
		<div style="clear:both"></div>
	<?php endif; ?>
	
	<?php if(!empty($categories)): ?>
		<div class="col-xl-12 content-box layout-section">
			<div class="row row-featured row-featured-category">
				<?php if($catDisplayType == 'c_picture_list'): ?>
					
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$_hasChildren = (!empty(data_get($cat, 'children'))) ? 1 : 0;
							$_parentId = data_get($cat, 'parent.id', 0);
							$_hasLink = (data_get($cat, 'id') != $catId || $_hasChildren == 1);
						?>
						<div class="col-lg-2 col-md-3 col-sm-4 col-6 f-category">
							<?php if($_hasLink): ?>
								<a href="#" class="cat-link"
								   data-id="<?php echo e(data_get($cat, 'id')); ?>"
								   data-parent-id="<?php echo e($_parentId); ?>"
								   data-has-children="<?php echo e($_hasChildren); ?>"
								   data-type="<?php echo e(data_get($cat, 'type')); ?>"
								>
							<?php endif; ?>
								<img src="<?php echo e(data_get($cat, 'picture_url')); ?>" class="lazyload img-fluid" alt="<?php echo e(data_get($cat, 'name')); ?>">
								<h6 class="<?php echo e(!$_hasLink ? 'text-secondary' : ''); ?>">
									<?php echo e(data_get($cat, 'name')); ?>

								</h6>
							<?php if($_hasLink): ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
				<?php elseif($catDisplayType == 'c_bigIcon_list'): ?>
					
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$_hasChildren = (!empty(data_get($cat, 'children'))) ? 1 : 0;
							$_parentId = data_get($cat, 'parent.id', 0);
							$_hasLink = (data_get($cat, 'id') != $catId || $_hasChildren == 1);
						?>
						<div class="col-lg-2 col-md-3 col-sm-4 col-6 f-category">
							<?php if($_hasLink): ?>
								<a href="#" class="cat-link"
								   data-id="<?php echo e(data_get($cat, 'id')); ?>"
								   data-parent-id="<?php echo e($_parentId); ?>"
								   data-has-children="<?php echo e($_hasChildren); ?>"
								   data-type="<?php echo e(data_get($cat, 'type')); ?>"
								>
							<?php endif; ?>
								<?php if(in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8])): ?>
									<i class="<?php echo e(data_get($cat, 'icon_class') ?? 'fas fa-folder'); ?>"></i>
								<?php endif; ?>
								<h6 class="<?php echo e(!$_hasLink ? 'text-secondary' : ''); ?>">
									<?php echo e(data_get($cat, 'name')); ?>

								</h6>
							<?php if($_hasLink): ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
				<?php elseif(in_array($catDisplayType, ['cc_normal_list', 'cc_normal_list_s'])): ?>
					
					<div style="clear: both;"></div>
					<?php
						$styled = ($catDisplayType == 'cc_normal_list_s') ? ' styled' : '';
					?>
					<div class="col-xl-12">
						<div class="list-categories-children<?php echo e($styled); ?>">
							<div class="row">
								<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cols): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="col-md-4 col-sm-4 <?php echo e((count($categories) == $key+1) ? 'last-column' : ''); ?>">
										<?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											
											<?php
												$randomId = '-' . substr(uniqid(rand(), true), 5, 5);
												$_hasChildren = (!empty(data_get($iCat, 'children'))) ? 1 : 0;
												$_parentId = data_get($iCat, 'parent.id', 0);
												$_hasLink = (data_get($iCat, 'id') != $catId || $_hasChildren == 1);
											?>
											
											<div class="cat-list">
												<h3 class="cat-title rounded<?php echo e(!$_hasLink ? ' text-secondary' : ''); ?>">
													<?php if(in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8])): ?>
														<i class="<?php echo e(data_get($iCat, 'icon_class') ?? 'fas fa-check'); ?>"></i>&nbsp;
													<?php endif; ?>
													<?php if($_hasLink): ?>
														<a href="#" class="cat-link"
														   data-id="<?php echo e(data_get($iCat, 'id')); ?>"
														   data-parent-id="<?php echo e($_parentId); ?>"
														   data-has-children="<?php echo e($_hasChildren); ?>"
														   data-type="<?php echo e(data_get($iCat, 'type')); ?>"
														>
													<?php endif; ?>
														<?php echo e(data_get($iCat, 'name')); ?>

													<?php if($_hasLink): ?>
														</a>
													<?php endif; ?>
													<span class="btn-cat-collapsed collapsed"
														  data-bs-toggle="collapse"
														  data-bs-target=".cat-id-<?php echo e(data_get($iCat, 'id') . $randomId); ?>"
														  aria-expanded="false"
													>
															<span class="icon-down-open-big"></span>
														</span>
												</h3>
												<ul class="cat-collapse collapse show cat-id-<?php echo e(data_get($iCat, 'id') . $randomId); ?> long-list-home">
													<?php
														$tmpSubCats = data_get($subCategories, data_get($iCat, 'id')) ?? [];
													?>
													<?php if(!empty($tmpSubCats)): ?>
														<?php $__currentLoopData = $tmpSubCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iSubCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php
																$_hasChildren2 = (!empty(data_get($iSubCat, 'children'))) ? 1 : 0;
																$_parentId2 = data_get($iSubCat, 'parent.id', 0);
																$_hasLink2 = (data_get($iSubCat, 'id') != $catId || $_hasChildren2 == 1);
															?>
															<li class="<?php echo e(!$_hasLink2 ? 'text-secondary fw-bold' : ''); ?>">
																<?php if($_hasLink2): ?>
																	<a href="#" class="cat-link"
																	   data-id="<?php echo e(data_get($iSubCat, 'id')); ?>"
																	   data-parent-id="<?php echo e($_parentId2); ?>"
																	   data-has-children="<?php echo e($_hasChildren2); ?>"
																	   data-type="<?php echo e(data_get($iSubCat, 'type')); ?>"
																	>
																<?php endif; ?>
																	<?php echo e(data_get($iSubCat, 'name')); ?>

																<?php if($_hasLink2): ?>
																	</a>
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
				
				<?php else: ?>
					
					<?php
						$listTab = [
							'c_border_list' => 'list-border',
						];
						$catListClass = (isset($listTab[$catDisplayType])) ? 'list ' . $listTab[$catDisplayType] : 'list';
					?>
					<div class="col-xl-12">
						<div class="list-categories">
							<div class="row">
								<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<ul class="cat-list <?php echo e($catListClass); ?> col-md-4 <?php echo e((count($categories) == $key+1) ? 'cat-list-border' : ''); ?>">
										<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php
												$_hasChildren = (!empty(data_get($cat, 'children'))) ? 1 : 0;
												$_parentId = data_get($cat, 'parent.id', 0);
												$_hasLink = (data_get($cat, 'id') != $catId || $_hasChildren == 1);
											?>
											<li class="<?php echo e(!$_hasLink ? 'text-secondary fw-bold' : ''); ?>">
												<?php if(in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8])): ?>
													<i class="<?php echo e(data_get($cat, 'icon_class') ?? 'fas fa-check'); ?>"></i>&nbsp;
												<?php endif; ?>
												<?php if($_hasLink): ?>
													<a href="#" class="cat-link"
													   data-id="<?php echo e(data_get($cat, 'id')); ?>"
													   data-parent-id="<?php echo e($_parentId); ?>"
													   data-has-children="<?php echo e($_hasChildren); ?>"
													   data-type="<?php echo e(data_get($cat, 'type')); ?>"
													>
												<?php endif; ?>
													<?php echo e(data_get($cat, 'name')); ?>

												<?php if($_hasLink): ?>
													</a>
												<?php endif; ?>
											</li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
				
				<?php endif; ?>
			
			</div>
		</div>
		<?php if($totalCategories > 0 && $areCategoriesPagingable): ?>
			<br>
			<?php echo $__env->make('vendor.pagination.api.bootstrap-4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
	<?php else: ?>
		<?php echo e($apiMessage ?? t('no_categories_found')); ?>

	<?php endif; ?>
<?php endif; ?>

<?php $__env->startSection('before_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('before_scripts'); ?>
	<?php if($maxSubCats >= 0): ?>
		<script>
			var maxSubCats = <?php echo e($maxSubCats); ?>;
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/post/createOrEdit/inc/category/select.blade.php ENDPATH**/ ?>