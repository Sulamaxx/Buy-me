<?php if(config('settings.app.show_countries_charts')): ?>
	<?php
		$postsPerCountry ??= [];
		
		$countPostsCountries = (int)data_get($postsPerCountry, 'countCountries');
		$postsDataArr = json_decode(data_get($postsPerCountry, 'data'), true);
		$postsDataArrLabels = data_get($postsDataArr, 'labels') ?? [];
		$countPostsLabels = (is_array($postsDataArrLabels) && count($postsDataArrLabels) > 1) ? count($postsDataArrLabels) : 0;
	?>
	
	<?php if($countPostsCountries > 1): ?>
		<div class="col-lg-6 col-md-12">
			<div class="card rounded shadow-sm">
				<div class="card-body">
					<div class="d-flex">
						<div>
							<h4 class="card-title mb-1 fw-bold">
								<span class="lstick d-inline-block align-middle"></span><?php echo e(data_get($postsPerCountry, 'title')); ?>

							</h4>
						</div>
						<div class="ms-auto">
						
						</div>
					</div>
					<div class="position-relative chart-responsive">
						<?php if($countPostsLabels > 0): ?>
							<canvas id="pieChartPosts"></canvas>
						<?php else: ?>
							<?php echo trans('admin.No data found'); ?>

						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php $__env->startPush('dashboard_styles'); ?>
		<style>
			canvas {
				-moz-user-select: none;
				-webkit-user-select: none;
				-ms-user-select: none;
			}
		</style>
	<?php $__env->stopPush(); ?>
	
	<?php $__env->startPush('dashboard_scripts'); ?>
		<script>
			<?php if($countPostsCountries > 1): ?>
				<?php if($countPostsLabels > 0): ?>
					<?php
						$postsDisplayLegend = ($countPostsLabels <= 15) ? 'true' : 'false';
					?>
					
					var config1 = {
						type: 'pie', /* pie, doughnut */
						data: <?php echo data_get($postsPerCountry, 'data'); ?>,
						options: {
							responsive: true,
							legend: {
								display: <?php echo e($postsDisplayLegend); ?>,
								position: 'left'
							},
							title: {
								display: false
							},
							animation: {
								animateScale: true,
								animateRotate: true
							}
						}
					};
					
					$(function () {
						var ctx = document.getElementById('pieChartPosts').getContext('2d');
						window.myPostsDoughnut = new Chart(ctx, config1);
					});
				<?php endif; ?>
			<?php endif; ?>
		</script>
	<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/dashboard/inc/charts/chartjs/pie/posts-per-country.blade.php ENDPATH**/ ?>