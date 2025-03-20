


<?php
	$apiResult ??= [];
	$posts = (array)data_get($apiResult, 'data');
	$totalPosts = (int)data_get($apiResult, 'meta.total', 0);
	$pagePath ??= null;
	
	$pageTitles = [
		'list' => [
			'icon'  => 'fas fa-bullhorn',
			'title' => t('my_listings'),
		],
		'archived' => [
			'icon'  => 'fas fa-calendar-times',
			'title' => t('archived_listings'),
		],
		'favourite' => [
			'icon'  => 'fas fa-bookmark',
			'title' => t('favourite_listings'),
		],
		'pending-approval' => [
			'icon'  => 'fas fa-hourglass-half',
			'title' => t('pending_approval'),
		],
	];
?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<?php if(session()->has('flash_notification')): ?>
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="col-md-3 page-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>

				<div class="col-md-9 page-content">
					<div class="inner-box">
						<h2 class="title-2">
							<i class="<?php echo e($pageTitles[$pagePath]['icon'] ?? 'fas fa-bullhorn'); ?>"></i>
							<?php echo e($pageTitles[$pagePath]['title'] ?? t('posts')); ?>

						</h2>
						
						<div class="table-responsive">
							<form name="listForm" method="POST" action="<?php echo e(url('account/posts/' . $pagePath . '/delete')); ?>">
								<?php echo csrf_field(); ?>

								<div class="table-action">
									<div class="btn-group hidden-sm" role="group">
										<button type="button" class="btn btn-sm-1 btn-sm btn-default pb-0">
											<input type="checkbox" id="checkAll" class="from-check-all">
										</button>
										<button type="button" class="btn btn-sm-1 btn-sm btn-default from-check-all">
											<?php echo e(t('Select')); ?>: <?php echo e(t('All')); ?>

										</button>
									</div>
									
									<button type="submit" class="btn btn-sm-1 btn-sm btn-default confirm-simple-action">
										<i class="fa fa-trash"></i> <?php echo e(t('Delete')); ?>

									</button>
									
									<div class="table-search float-end col-sm-7">
										<div class="row">
											<label class="col-5 form-label text-end"><?php echo e(t('search')); ?> <br>
												<a title="clear filter" class="clear-filter" href="#clear">[<?php echo e(t('clear')); ?>]</a>
											</label>
											<div class="col-7 searchpan px-3">
												<input type="text" class="form-control" id="filter">
											</div>
										</div>
									</div>
								</div>
								
								<table id="addManageTable"
									   class="table table-striped table-bordered add-manage-table table demo"
									   data-filter="#filter"
									   data-filter-text-only="true"
								>
									<thead>
									<tr>
										<th data-type="numeric" data-sort-initial="true"></th>
										<th><?php echo e(t('Photo')); ?></th>
										<th data-sort-ignore="true"><?php echo e(t('listing_details')); ?></th>
										<th data-type="numeric">--</th>
										<th><?php echo e(t('Option')); ?></th>
									</tr>
									</thead>
									<tbody>
									
									<?php if(!empty($posts) && $totalPosts > 0): ?>
										<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td style="width:2%" class="add-img-selector">
													<div class="checkbox">
														<label><input type="checkbox" name="entries[]" value="<?php echo e(data_get($post, 'id')); ?>"></label>
													</div>
												</td>
												<td style="width:20%" class="add-img-td">
													<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>">
														<img class="img-thumbnail img-fluid" src="<?php echo e(data_get($post, 'picture.url.medium')); ?>" alt="img">
													</a>
												</td>
												<td style="width:52%" class="items-details-td">
													<div>
														<p>
															<strong>
																<a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" title="<?php echo e(data_get($post, 'title')); ?>">
																	<?php echo e(str(data_get($post, 'title'))->limit(40)); ?>

																</a>
															</strong>
															<?php if(in_array($pagePath, ['list', 'archived', 'pending-approval'])): ?>
																<?php if(!empty(data_get($post, 'payment')) && !empty(data_get($post, 'payment.package'))): ?>
																	<?php
																		if (data_get($post, 'featured') == 1) {
																			$color = data_get($post, 'payment.package.ribbon');
																			$packageInfo = '';
																		} else {
																			$color = '#ddd';
																			$packageInfo = ' (' . t('expired') . ')';
																		}
																	?>
																	<i class="fa fa-check-circle"
																		style="color: <?php echo e($color); ?>;"
																		data-bs-placement="bottom"
																		data-bs-toggle="tooltip"
																		title="<?php echo e(data_get($post, 'payment.package.short_name') . $packageInfo); ?>"
																	></i>
																<?php endif; ?>
															<?php endif; ?>
														</p>
														<p>
															<strong>
																<i class="far fa-clock" title="<?php echo e(t('Posted On')); ?>"></i>
															</strong>&nbsp;<?php echo data_get($post, 'created_at_formatted'); ?>

														</p>
														<p>
															<strong><i class="far fa-eye" title="<?php echo e(t('Visitors')); ?>"></i></strong> <?php echo e(data_get($post, 'visits') ?? 0); ?>

															<strong><i class="bi bi-geo-alt" title="<?php echo e(t('Located In')); ?>"></i></strong> <?php echo e(data_get($post, 'city.name') ?? '-'); ?>

															<img src="<?php echo e(data_get($post, 'country_flag_url')); ?>" data-bs-toggle="tooltip" title="<?php echo e(data_get($post, 'country.name')); ?>">
														</p>
													</div>
												</td>
												<td style="width:16%" class="price-td">
													<div>
														<strong>
															<?php echo data_get($post, 'price_formatted'); ?>

														</strong>
													</div>
												</td>
												<td style="width:10%" class="action-td">
													<div>
														<?php if(
																in_array($pagePath, ['list', 'pending-approval'])
																&& data_get($post, 'user_id') == $authUser->id
																&& empty(data_get($post, 'archived_at'))
															): ?>
															<p>
																<a class="btn btn-primary btn-sm" href="<?php echo e(\App\Helpers\UrlGen::editPost($post)); ?>">
																	<i class="fa fa-edit"></i> <?php echo e(t('Edit')); ?>

																</a>
															</p>
														<?php endif; ?>
														<?php if($pagePath == 'list' && isVerifiedPost($post) && empty(data_get($post, 'archived_at'))): ?>
															<p>
																<a class="btn btn-warning btn-sm confirm-simple-action"
																   href="<?php echo e(url('account/posts/'.$pagePath.'/'.data_get($post, 'id').'/offline')); ?>"
																>
																	<i class="fas fa-eye-slash"></i> <?php echo e(t('Offline')); ?>

																</a>
															</p>
														<?php endif; ?>
														<?php if(
															$pagePath == 'archived'
															&& data_get($post, 'user_id') == $authUser->id
															&& !empty(data_get($post, 'archived_at'))
														): ?>
															<p>
																<a class="btn btn-info btn-sm confirm-simple-action"
																	href="<?php echo e(url('account/posts/' . $pagePath . '/' . data_get($post, 'id') . '/repost')); ?>"
																>
																	<i class="fa fa-recycle"></i> <?php echo e(t('Repost')); ?>

																</a>
															</p>
														<?php endif; ?>
														<p>
															<a class="btn btn-danger btn-sm confirm-simple-action"
																href="<?php echo e(url('account/posts/' . $pagePath . '/' . data_get($post, 'id') . '/delete')); ?>"
															>
																<i class="fa fa-trash"></i> <?php echo e(t('Delete')); ?>

															</a>
														</p>
													</div>
												</td>
											</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
									</tbody>
								</table>
							</form>
						</div>
						
						<nav>
							<?php echo $__env->make('vendor.pagination.api.bootstrap-4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</nav>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
	<style>
		.action-td p {
			margin-bottom: 5px;
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script src="<?php echo e(url('assets/js/footable.js?v=2-0-1')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/js/footable.filter.js?v=2-0-1')); ?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				let selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

			$('.from-check-all').click(function () {
				checkAll(this);
			});
		});
	</script>
	
	<script>
		function checkAll(bx) {
			if (bx.type !== 'checkbox') {
				bx = document.getElementById('checkAll');
				bx.checked = !bx.checked;
			}
			
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type === 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/posts.blade.php ENDPATH**/ ?>